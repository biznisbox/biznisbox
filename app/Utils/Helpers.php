<?php
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Utils\SerialNumberFormatter;

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
