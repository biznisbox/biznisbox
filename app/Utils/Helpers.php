<?php
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Utils\SerialNumberFormatter;
use Clockwork\Request\Log;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Log as FacadesLog;

if (!function_exists('api_response')) {
    /**
     * Function generate API response (JSON)
     * @param array $data - data
     * @param string $message - message
     * @param integer $status_code - status code
     * @return object $response
     */
    function api_response($data = null, $message = '', $status_code = 200)
    {
        return response()->json(
            [
                'data' => $data,
                'message' => $message,
            ],
            $status_code
        );
    }
}

if (!function_exists('settings')) {
    /**
     * Function access to application settings in database
     * @param string $key - key of setting
     * @param string $default - default value
     * @return object|string setting
     */
    function settings($key = null, $default = null)
    {
        $setting = new \App\Models\Settings();

        if (is_null($key)) {
            return $setting;
        }

        if (is_array($key)) {
            return $setting->set($key);
        }

        return $setting->get($key, value($default));
    }
}

if (!function_exists('user_data')) {
    /**
     * Function for get data about logged user
     * @param $token
     * @return object|bool|null
     */
    function user_data($token = null)
    {
        $request = Request::capture();
        $token = $token ?? $request->bearerToken();
        if ($token !== null) {
            $auth = new AuthService();
            return $auth->decodeToken($token);
        }
        return null;
    }
}

if (!function_exists('get_current_user_id')) {
    /**
     * Function for get user id
     * @return uuid|null
     */
    function get_current_user_id()
    {
        $user_data = user_data();
        if ($user_data !== null) {
            return $user_data->data->id;
        }
        return null;
    }
}

if (!function_exists('activity_log')) {
    /**
     * Function for create activity log
     * @param string $user_id - user id
     * @param string $event
     * @param string $auditable_id
     * @param string $auditable_type
     * @param string $tags
     * @return void
     */
    function activity_log(
        $user_id = null,
        $event = null,
        $auditable_id = null,
        $auditable_type = null,
        $tags = null,
        $type = null,
        $external_key = null
    ) {
        $activity = new \App\Models\ActivityLog();
        $activity->createLog($user_id, $event, $auditable_id, $auditable_type, $tags, $type, $external_key);
    }
}

if (!function_exists('generate_external_key')) {
    /**
     * Function for generate external key
     * @param string $module - module name
     * @param string $module_item_id - module item id
     * @param string $creation_method - creation method (default: manual)
     * @param string $expiries_at - expiries date (default: null)
     * @return string $key
     */
    function generate_external_key($module, $module_item_id, $creation_method = 'manual', $expires_at = null)
    {
        $external_key = new \App\Models\ExternalKeys();
        return $external_key->createExternalKey($module, $module_item_id, $creation_method, $expires_at);
    }
}

if (!function_exists('validate_external_key')) {
    /**
     * Function for validate key
     * @param string $key - external key
     * @param string $module - module name
     * @return bool
     */
    function validate_external_key($key, $module)
    {
        $external_key = new \App\Models\ExternalKeys();
        return $external_key->validateKey($key, $module);
    }
}

if (!function_exists('format_timestamp')) {
    /**
     * Function for format dateformat from js to php
     * @param string $value - dateformat from js - saved in database
     * @return string $value - dateformat from php
     */
    function format_timestamp($value)
    {
        $value = str_replace('YYYY', 'Y', $value);
        $value = str_replace('MM', 'm', $value);
        $value = str_replace('DD', 'd', $value);
        $value = str_replace('HH', 'H', $value);
        $value = str_replace('mm', 'i', $value);
        $value = str_replace('ss', 's', $value);
        return $value;
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Function for format js dateformat to php dateformat
     *
     * @param string $value - date for format
     * @param string $format - dateformat from js - saved in database
     * @return string $value - formatted date
     */
    function format_datetime($value, $format)
    {
        $format = format_timestamp($format);
        return date($format, strtotime($value));
    }
}

if (!function_exists('format_permissions')) {
    /**
     * Function for format permissions to array
     * @param array $permissions - permissions
     * @return array $formatted_permissions - formatted permissions
     */
    function format_permissions($permissions)
    {
        $formatted_permissions = [];
        foreach ($permissions as $permission) {
            array_push($formatted_permissions, $permission->name);
        }
        return $formatted_permissions;
    }
}

if (!function_exists('has_permission')) {
    /**
     * Function for check if user has permission
     * @param string $permission - permission name
     * @return bool
     */
    function has_permission($permission)
    {
        $user_permissions = user_data()->data->permissions;

        if (in_array($permission, $user_permissions)) {
            return true;
        }
    }
}

if (!function_exists('generate_next_number')) {
    /**
     * Function for generate next number
     * @param string  $format - number format
     * @param integer $module - number
     */
    function generate_next_number($format, $module)
    {
        $number = new SerialNumberFormatter();
        return $number->generateNumberFromFormat($format, $module);
    }
}

/**
 * Function for increment number
 * @param string $module - module name
 * @return void
 */
if (!function_exists('incrementLastItemNumber')) {
    function incrementLastItemNumber($module)
    {
        $number = new SerialNumberFormatter();
        $number->incrementLastItemNumber($module);
    }
}

if (!function_exists('formatHTML')) {
    /**
     * Function for format html
     * @param string $html - html
     * @return string $html - formatted html
     */
    function formatHTML($html)
    {
        $html = trim($html);
        $html = str_replace("\n", '', $html);
        $html = str_replace("\r", '', $html);
        $html = str_replace("\t", '', $html);
        $html = stripslashes($html);
        $html = htmlspecialchars($html);
        return $html;
    }
}

if (!function_exists('processRelation')) {
    /**
     * Function for process relation
     * @param Relation $relation - relation
     * @param array $items - items
     * @return void
     */
    function processRelation(Relation $relation, array $items)
    {
        $relation->getResults()->each(function ($model) use ($items) {
            foreach ($items as $item) {
                if ($model->id === ($item['id'] ?? null)) {
                    $model->fill($item)->save();
                    return;
                }
            }

            return $model->delete();
        });

        foreach ($items as $item) {
            if (!isset($item['id'])) {
                $relation->create($item);
            }
        }
    }
}

if (!function_exists('getCurrencyRate')) {
    /**
     * Function for get currency rate
     * @param string $currency - currency
     * @return float $rate - currency rate
     */
    function getCurrencyRate($currency)
    {
        $currency_rate = new \App\Models\Currencies();
        $rate = $currency_rate->getCurrencyRate($currency);
        return $rate;
    }
}

if (!function_exists('calculateDiscountHelper')) {
    /**
     * Function for calculate discount
     * @param float $total - total
     * @param float $discount - discount
     * @param string $discount_type - discount type
     * @return float $total - total
     */
    function calculateDiscountHelper($total, $discount, $discount_type = 'percentage')
    {
        if ($discount_type === 'percentage') {
            $total = $total - ($total * $discount) / 100;
        } else {
            $total = $total - $discount;
        }
        return $total;
    }
}

if (!function_exists('calculateTaxHelper')) {
    /**
     * Function for calculate tax
     * @param float $total - total
     * @param float $tax - tax
     * @param string $tax_type - tax type
     * @return float $total - total
     */
    function calculateTaxHelper($total, $tax, $tax_type = 'percentage')
    {
        if ($tax_type === 'percentage') {
            $total = $total + ($total * $tax) / 100;
        } else {
            $total = $total + $tax;
        }
        return $total;
    }
}

if (!function_exists('calculateItemTotalHelper')) {
    /**
     * Function for calculate item total
     * @param array $item - item
     * @return float $total - total
     */
    function calculateItemTotalHelper($item)
    {
        $total = $item['quantity'] * $item['price'];
        if (isset($item['tax'])) {
            $total = calculateTaxHelper($total, $item['tax']);
        }
        if (isset($item['discount'])) {
            $total = calculateDiscountHelper($total, $item['discount']);
        }
        return $total;
    }
}

if (!function_exists('calculateTotalHelper')) {
    /**
     * Function for calculate total
     * @param array $items - items
     * @param float $discount - discount
     * @param string $discount_type - discount type
     * @return float $total - total
     */
    function calculateTotalHelper(
        $items,
        $discount = null,
        $discount_type = 'percentage',
        $currency_rate = null,
        $tax = null,
        $tax_type = 'percentage'
    ) {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['total'];
        }
        if ($discount !== null) {
            $total = calculateDiscountHelper($total, $discount, $discount_type);
        }
        if ($tax !== null) {
            $total = calculateTaxHelper($total, $tax, $tax_type);
        }
        if ($currency_rate !== null) {
            $total = $total * $currency_rate;
        }
        return $total;
    }
}
