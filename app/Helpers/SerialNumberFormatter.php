<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class SerialNumberFormatter
{
    private $validPlaceholders = [
        'DATE', // {{DATE:Y-m-d}} - Y-m-d is the format of the date
        'NUMBER', // {{NUMBER:4}} - 4 is the number of digits of the number to be inserted
        'TEXT', // {{TEXT:"text to be inserted"}} - 'text to be inserted' is the text to be inserted
        'DELIMITER', // {{DELIMITER}} - delimiter is delimiter char
    ];

    /**
     * Function for get placeholders
     * @param string $string - string with placeholders
     */
    public static function getPlaceholders($string)
    {
        $placeholders = [];
        preg_match_all('/{{(.*?)}}/', $string, $matches);
        if (isset($matches[1])) {
            foreach ($matches[1] as $match) {
                $placeholders[] = $match;
            }
        }
        return $placeholders;
    }

    /**
     * Function for validate placeholders
     * @param array $placeholders - placeholders
     */
    public function validatePlaceholders($placeholders)
    {
        foreach ($placeholders as $placeholder) {
            $placeholderParts = explode(':', $placeholder, 2);
            if (!in_array($placeholderParts[0], $this->validPlaceholders)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks if the format contains a DATE placeholder, which implies a yearly reset.
     * @param array $placeholders
     * @return bool
     */
    private function formatHasYearlyReset(array $placeholders): bool
    {
        foreach ($placeholders as $placeholder) {
            if (strpos($placeholder, 'DATE') === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Function for generate number
     * @param array   $placeholders - placeholders
     * @param string  $delimiter - delimiter
     * @param string  $module - application module (documents, invoices, estimates, etc.)
     */
    public function generateNumber($placeholders, $delimiter = '-', $module = null)
    {
        $number = '';
        // KEY CHANGE: Determine ONCE if this format requires a yearly reset.
        $needsYearlyReset = $this->formatHasYearlyReset($placeholders);

        foreach ($placeholders as $placeholder) {
            $placeholderParts = explode(':', $placeholder, 2);
            $type = $placeholderParts[0];
            $value = $placeholderParts[1] ?? null;

            switch ($type) {
                case 'DATE':
                    $number .= date($value);
                    break;
                case 'NUMBER':
                    $last_item_number = $this->getLastItemNumber($module, $needsYearlyReset) + 1;
                    $number .= str_pad($last_item_number, (int) $value, '0', STR_PAD_LEFT);
                    break;
                case 'TEXT':
                    // Support quoted text
                    $number .= trim($value, '"');
                    break;
                case 'DELIMITER':
                    $number .= $delimiter;
                    break;
                default:
                    break;
            }
        }
        return rtrim($number, $delimiter);
    }

    /**
     * Function for generate next number
     * @param string  $format - number format
     * @param string  $module - application module
     */
    public function generateNumberFromFormat($format, $module = null)
    {
        $placeholders = $this->getPlaceholders($format);
        if (!$this->validatePlaceholders($placeholders)) {
            return __('response.invalid_format');
        }
        return $this->generateNumber($placeholders, '-', $module);
    }

    /**
     * Function for get last item number from database.
     *
     * @param string $module - application module (documents, invoices, estimates, etc.)
     * @param boolean $needsYearlyReset - If true, number resets to 0 on new year.
     * @return integer $last_number - last item number
     */
    public function getLastItemNumber($module, $needsYearlyReset = false)
    {
        // If the format includes a date, the year is the current year.
        // Otherwise, we use a constant year (0) for a continuous, non-resetting counter.
        $year = $needsYearlyReset ? date('Y') : 0;

        $lastNumberRecord = DB::table('numbering')->where('module', $module)->where('year', $year)->first();

        if (!$lastNumberRecord) {
            DB::table('numbering')->insert([
                'module' => $module,
                'year' => $year,
                'number' => 0,
            ]);
            return 0;
        }

        return $lastNumberRecord->number;
    }

    /**
     * Function for increment last item number
     * @param string $module - application module
     * @param string $format - The number format string is required to determine the reset logic
     * @return integer $new_number - new last item number
     */
    public function incrementLastItemNumber($module, $format)
    {
        $placeholders = $this->getPlaceholders($format);
        $needsYearlyReset = $this->formatHasYearlyReset($placeholders);
        $year = $needsYearlyReset ? date('Y') : 0;

        // Use `increment` for an atomic update to prevent race conditions.
        // This also handles the case where the row doesn't exist yet, but it's safer to ensure it does.
        $this->getLastItemNumber($module, $needsYearlyReset); // This ensures the row exists.

        return DB::table('numbering')->where('module', $module)->where('year', $year)->increment('number');
    }

    /**
     * Function for decrement last item number
     * @param string $module - application module
     * @param string $format - The number format string is required to determine the reset logic
     * @return integer $new_number - new last item number
     */
    public function decrementLastItemNumber($module, $format)
    {
        $placeholders = $this->getPlaceholders($format);
        $needsYearlyReset = $this->formatHasYearlyReset($placeholders);
        $year = $needsYearlyReset ? date('Y') : 0;

        $this->getLastItemNumber($module, $needsYearlyReset); // Ensures row exists.

        return DB::table('numbering')->where('module', $module)->where('year', $year)->decrement('number');
    }

    /**
     * Function for convert number format to array for frontend
     * @param string $item
     * @return array
     */
    public static function convertNumberFormatToArray($item)
    {
        $items = self::getPlaceholders($item);
        $number_format = [];
        foreach ($items as $itemValue) {
            $parts = explode(':', $itemValue, 2);
            $number_format[] = [
                'type' => $parts[0],
                'value' => $parts[1] ?? null,
            ];
        }
        return $number_format;
    }

    /**
     * Function for convert number format to string for backend
     * @param array $number_format
     * @return string
     */
    public static function convertNumberFormatToString($number_format)
    {
        $number_format_string = '';
        foreach ($number_format as $item) {
            $valuePart = isset($item['value']) ? ':' . $item['value'] : '';
            $number_format_string .= '{{' . $item['type'] . $valuePart . '}}';
        }
        return $number_format_string;
    }

    /**
     * @param array $format
     * @param string $module
     * @return string
     */
    public function generatePreview($format, $module = 'invoice')
    {
        $string = self::convertNumberFormatToString($format);
        $placeholders = self::getPlaceholders($string);
        if (!$this->validatePlaceholders($placeholders)) {
            return __('response.invalid_format');
        }
        return $this->generateNumber($placeholders, '-', $module);
    }
}
