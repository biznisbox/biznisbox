<?php

namespace App\Utils;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SerialNumberFormatter
{
    private $valid_placeholders = [
        'DATE', // {{DATE:Y-m-d}} - Y-m-d is the format of the date
        'NUMBER', // {{NUMBER:4}} - 4 is the number of digits of the number to be inserted
        'TEXT', // {{TEXT:"text to be inserted"}} - 'text to be inserted' is the text to be inserted
        'DELIMITER', // {{DELIMITER}} - delimiter is delimiter char
    ];

    /**
     * Function for get placeholders
     * @param string $string - string with placeholders
     */
    public function getPlaceholders($string)
    {
        $placeholders = [];
        $matches = [];
        preg_match_all('/{{(.*?)}}/', $string, $matches);
        foreach ($matches[1] as $match) {
            $placeholders[] = $match;
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
            $placeholder = explode(':', $placeholder);
            if (!in_array($placeholder[0], $this->valid_placeholders)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Function for generate number
     * @param array   $placeholders - placeholders
     * @param string  $delimiter - delimiter
     * @param integer $last_item_number - last item number
     */
    public function generateNumber($placeholders, $delimiter = '-', $module = null)
    {
        $number = '';
        foreach ($placeholders as $placeholder) {
            $placeholder = explode(':', $placeholder);
            switch ($placeholder[0]) {
                case 'DATE':
                    $number .= date($placeholder[1]);
                    break;
                case 'NUMBER':
                    $last_item_number = $this->getLastItemNumber($module) + 1; // get last item number from cache
                    $number .= str_pad($last_item_number, $placeholder[1], '0', STR_PAD_LEFT);
                    break;
                case 'TEXT':
                    $number .= $placeholder[1];
                    break;
                case 'DELIMITER':
                    $number .= $delimiter;
                    break;
            }
        }
        return rtrim($number, $delimiter);
    }

    /**
     * Function for generate next number
     * @param string  $format - number format
     * @param integer $last_item_number - last item number
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
     * Function for increment last item number
     *
     * @param string $module - application module (documents, invoices, estimates, etc.)
     * @return integer $last_item_number - last item number (incremented)
     */
    public function incrementLastItemNumber($module)
    {
        $last_item_number = $this->getLastItemNumber($module) + 1; // get last item number from cache
        DB::table('numbering')
            ->where([
                'module' => $module,
                'year' => date('Y'),
            ])
            ->update([
                'number' => $last_item_number,
            ]);
        return $last_item_number;
    }

    /**
     * Function for decrement last item number
     *
     * @param string $module - application module (documents, invoices, estimates, etc.)
     * @return integer $last_item_number - last item number (decremented)
     */

    public function decrementLastItemNumber($module)
    {
        $last_item_number = $this->getLastItemNumber($module) - 1; // get last item number from cache
        DB::table('numbering')
            ->where([
                'module' => $module,
                'year' => date('Y'),
            ])
            ->update([
                'number' => $last_item_number,
            ]);
        return $last_item_number;
    }

    /**
     * Function for get last item number from database
     *
     * @param string $module - application module (documents, invoices, estimates, etc.)
     * @return integer $last_number - last item number
     */
    public function getLastItemNumber($module)
    {
        $last_number = DB::table('numbering')
            ->where('year', date('Y'))
            ->where('module', $module)
            ->first();

        if (!$last_number) {
            $last_number = DB::table('numbering')->insert([
                'id' => Str::uuid(),
                'module' => $module,
                'year' => date('Y'),
                'number' => 0, // set default number to 0 (if there is no number in database) - this will be incremented to 1
            ]);
            return 0;
        }
        return $last_number->number;
    }
}
