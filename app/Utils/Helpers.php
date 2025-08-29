<?php
use App\Helpers\SerialNumberFormatter;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;
use App\Events\WebhookEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

if (!function_exists('api_response')) {
    /**
     * Function generate API response (JSON) with data, message and status code
     * @param array|string|object $data - data
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
                'status_code' => $status_code,
                'response_time' => convertResponseTime(microtime(true) - LARAVEL_START),
                'status' => $status_code >= 200 && $status_code < 300 ? 'success' : 'error',
            ],
            $status_code,
        );
    }
}

if (!function_exists('convertResponseTime')) {
    /**
     * Function convert response time to milliseconds
     * @param float $response_time - response time
     * @return float $response_time - response time in milliseconds or seconds
     */
    function convertResponseTime($response_time)
    {
        if ($response_time < 1) {
            return round($response_time * 1000, 2) . 'ms';
        } elseif ($response_time < 60) {
            return round($response_time, 2) . 's';
        } else {
            return round($response_time / 60, 2) . 'm';
        }
    }
}

if (!function_exists('getPublicSettings')) {
    /**
     * Function get public settings
     * @return array $settings
     */
    function getPublicSettings()
    {
        $settings = new \App\Models\Setting();
        return $settings->getPublicSettings();
    }
}

if (!function_exists('incrementLastItemNumber')) {
    /**
     * Function for increment number
     * @param string $module - module name
     * @return void
     */
    function incrementLastItemNumber($module, $format = null)
    {
        $number = new SerialNumberFormatter();
        $number->incrementLastItemNumber($module, $format);
    }
}

if (!function_exists('getLastItemNumber')) {
    /**
     * Function for get last item number
     * @param string $module - module name
     * @return integer $last_item_number
     */
    function getLastItemNumber($module)
    {
        $number = new SerialNumberFormatter();
        return $number->getLastItemNumber($module);
    }
}

if (!function_exists('generateNextNumber')) {
    /**
     * Function for generate next number
     * @param string  $format - number format
     * @param integer $module - number
     */
    function generateNextNumber($format, $module)
    {
        $number = new SerialNumberFormatter();
        return $number->generateNumberFromFormat($format, $module);
    }
}

if (!function_exists('settings')) {
    /**
     * Function access to application settings in database
     * @param string $key - key of setting
     * @param string $method - method (get, set)
     * @param string $default - default value
     * @return object|string setting
     */
    function settings($key = null, $method = 'get', $default = null)
    {
        $setting = new \App\Models\Setting();

        if (is_null($key)) {
            return $setting;
        }

        if (is_array($key) && $method == 'set') {
            return $setting->set($key);
        }

        if (is_array($key) && $method == 'get') {
            return $setting->only($key);
        }

        return $setting->get($key, value($default));
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

if (!function_exists('calculateDiscountHelper')) {
    /**
     * Function for calculate discount
     * @param float $total - total
     * @param float $discount - discount
     * @param string $discount_type - discount type
     * @return float $total - total
     */
    function calculateDiscountHelper($total, $discount, $discount_type = 'percent')
    {
        if ($discount_type === 'percent') {
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
    function calculateTaxHelper($total, $tax, $tax_type = 'percent')
    {
        if ($tax_type === 'percent') {
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
            $total = calculateTaxHelper($total, $item['tax'], $item['tax_type'] ?? 'percent');
        }
        if (isset($item['discount'])) {
            $total = calculateDiscountHelper($total, $item['discount'], $item['discount_type'] ?? 'percent');
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
        $discount_type = 'percent',
        $currency_rate = null,
        $tax = null,
        $tax_type = 'percent',
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

if (!function_exists('generateExternalKey')) {
    /**
     * Function for generate external key
     * @param string $module - module name
     * @param string $module_item_id - module item id
     * @param string $creation_method - creation method (default: manual)
     * @param string $expiries_at - expiries date (default: null)
     * @param string $recipient - recipient (default: null) - email, phone number of recipient
     * @param string $recipient_type - recipient type (default: null) - email, phone_number
     * @return string $key
     */
    function generateExternalKey(
        $module,
        $module_item_id,
        $creation_method = 'manual',
        $expires_at = null,
        $recipient = null,
        $recipient_type = null,
    ) {
        $external_key = new \App\Models\ExternalKey();
        return $external_key->createExternalKey($module, $module_item_id, $creation_method, $expires_at, $recipient, $recipient_type);
    }
}

if (!function_exists('validateExternalKey')) {
    /**
     * Function for validate key
     * @param string $key - external key
     * @param string $module - module name
     * @return bool
     */
    function validateExternalKey($key, $module)
    {
        $external_key = new \App\Models\ExternalKey();
        return $external_key->validateKey($key, $module);
    }
}

if (!function_exists('setCustomerData')) {
    /**
     * Set customer data to the invoice/quote
     * @param array $data - invoice/quote data
     * @param UUID $customerId - customer id
     * @param UUID $customerAddressId - customer address id
     * @return array $data - updated data
     */
    function setCustomerData($data, $customerId, $customerAddressId)
    {
        if (!$customerId) {
            $data['customer_id'] = null;
            $data['address_id'] = null;
            $data['customer_name'] = null;
            $data['customer_address'] = null;
            $data['customer_city'] = null;
            $data['customer_zip_code'] = null;
            $data['customer_country'] = null;
            return $data;
        }
        $partner = \App\Models\Partner::find($customerId);
        if ($customerAddressId) {
            $address = \App\Models\PartnerAddress::where('partner_id', $customerId)->where('id', $customerAddressId)->first();
        }
        $data['customer_id'] = $partner->id;
        $data['customer_name'] = $partner->name;
        $data['customer_address_id'] = $address->id ?? null;
        $data['customer_address'] = $address->address ?? null;
        $data['customer_city'] = $address->city ?? null;
        $data['customer_zip_code'] = $address->zip_code ?? null;
        $data['customer_country'] = $address->country ?? null;
        return $data;
    }
}

if (!function_exists('setPayerData')) {
    /**
     * Set payer data to the invoice/quote
     *
     * @param array $data - invoice/quote data
     * @param UUID $payerId - payer id
     * @param UUID $payerAddressId - payer address id
     * @return array $data - updated data
     */
    function setPayerData($data, $payerId, $payerAddressId)
    {
        if (!$payerId) {
            $data['payer_id'] = null;
            $data['payer_address_id'] = null;
            $data['payer_name'] = null;
            $data['payer_address'] = null;
            $data['payer_city'] = null;
            $data['payer_zip_code'] = null;
            $data['payer_country'] = null;
            return $data;
        }
        $partner = \App\Models\Partner::find($payerId);
        if ($payerAddressId) {
            $address = \App\Models\PartnerAddress::where('partner_id', $payerId)->where('id', $payerAddressId)->first();
        }
        $data['payer_id'] = $partner->id;
        $data['payer_name'] = $partner->name;
        $data['payer_address_id'] = $address->id ?? null;
        $data['payer_address'] = $address->address ?? null;
        $data['payer_city'] = $address->city ?? null;
        $data['payer_zip_code'] = $address->zip_code ?? null;
        $data['payer_country'] = $address->country ?? null;
        return $data;
    }
}

if (!function_exists('setSupplierData')) {
    /**
     * Set supplier data to the bill
     *
     * @param array $data - invoice/quote data
     * @param UUID $payerId - payer id
     * @param UUID $payerAddressId - payer address id
     * @return array $data - updated data
     */
    function setSupplierData($data, $supplierId, $supplierAddressId)
    {
        if (!$supplierId) {
            $data['supplier_id'] = null;
            $data['supplier_address_id'] = null;
            $data['supplier_name'] = null;
            $data['supplier_address'] = null;
            $data['supplier_city'] = null;
            $data['supplier_zip_code'] = null;
            $data['supplier_country'] = null;
            return $data;
        }
        $partner = \App\Models\Partner::find($supplierId);
        if ($supplierAddressId) {
            $address = \App\Models\PartnerAddress::where('partner_id', $supplierId)->where('id', $supplierAddressId)->first();
        }
        $data['supplier_id'] = $partner->id;
        $data['supplier_name'] = $partner->name;
        $data['supplier_address_id'] = $address->id ?? null;
        $data['supplier_address'] = $address->address ?? null;
        $data['supplier_city'] = $address->city ?? null;
        $data['supplier_zip_code'] = $address->zip_code ?? null;
        $data['supplier_country'] = $address->country ?? null;
        return $data;
    }
}

if (!function_exists('createActivityLog')) {
    /**
     * Create activity log
     * @param string $event - event
     * @param string $auditable_id - auditable id
     * @param string $auditable_type - auditable type
     * @param array $tags - tags
     * @param string $user_id - user id
     * @param string $user_type - user type
     * @param string $type - type
     * @param string $external_key - external key
     * @return void $activity
     */
    function createActivityLog(
        $event,
        $auditable_id,
        $auditable_type,
        $tags = null,
        $user_id = null,
        $user_type = 'App\Models\User',
        $type = 'internal',
        $external_key = null,
    ) {
        $activity = new \App\Models\ActivityLog();
        $activity->createLog($event, $auditable_id, $auditable_type, $tags, $user_id, $user_type, $type, $external_key);
    }
}

if (!function_exists('formatPermissions')) {
    /**
     * Function for format permissions to array
     * @param array $permissions - permissions
     * @return array $formatted_permissions - formatted permissions
     */
    function formatPermissions($permissions)
    {
        $formatted_permissions = [];
        foreach ($permissions as $permission) {
            array_push($formatted_permissions, $permission->name);
        }
        return $formatted_permissions;
    }
}

if (!function_exists('getCurrencyRate')) {
    /**
     * Function for get currency rate
     * @param string $from - from currency
     * @param string $to - to currency
     * @return float $rate - currency rate
     */
    function getCurrencyRate($currencyFrom, $currencyTo)
    {
        $currency = new \App\Models\Currency();
        return $currency->getCurrencyRate($currencyFrom, $currencyTo);
    }
}

if (!function_exists('formatTimestamp')) {
    /**
     * Function for format dateformat from js to php
     * @param string $value - dateformat from js - saved in database
     * @return string $value - dateformat from php
     */
    function formatTimestamp($value)
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

if (!function_exists('formatDateTime')) {
    /**
     * Function for format js dateformat to php dateformat
     *
     * @param string $value - date for format
     * @param string $format - dateformat from js - saved in database
     * @return string formatted date
     */
    function formatDateTime($value, $format)
    {
        $format = formatTimestamp($format);
        return date($format, strtotime($value));
    }
}

if (!function_exists('formatMoney')) {
    /**
     * Function for format money
     * @param float $amount - amount
     * @param string $currency - currency
     * @return string $formatted_amount - formatted amount
     */
    function formatMoney($amount, $currency = null)
    {
        if (!$currency) {
            $currency = settings('default_currency');
        }
        return number_format($amount, 2) . ' ' . $currency;
    }
}

if (!function_exists('createNotification')) {
    /**
     * Function for create notification
     * @param string $user_id - user id (recipient)
     * @param string $title - title
     * @param string $content - content
     * @param string $type - type
     * @param string $action_text - action text
     * @param string $action_url - action url
     * @return void
     */
    function createNotification($user_id, $title, $content, $type, $action_text = null, $action_url = null)
    {
        if (!$user_id) {
            return;
        }
        $notification = new \App\Models\Notification();
        $notification->createNotification($user_id, $title, $content, $type, $action_text, $action_url);
    }
}

if (!function_exists('writeInEnvFile')) {
    /**
     * Write data in .env file
     * @param array $data Data to write in .env file (key => value array)
     * @return void
     */
    function writeInEnvFile($data)
    {
        $envFile = base_path('.env');

        if (file_exists($envFile)) {
            $env = file_get_contents($envFile);

            foreach ($data as $key => $value) {
                $env = preg_replace('/' . Str::upper($key) . '=(.*)/', Str::upper($key) . '=' . $value, $env);
            }

            file_put_contents($envFile, $env);
            return true;
        }
        return false;
    }
}

if (!function_exists('readFromEnvFile')) {
    /**
     * Read data from .env file
     * @return array|null Data from .env file (key => value array)
     */
    function readFromEnvFile()
    {
        $envFile = base_path('.env');

        if (file_exists($envFile)) {
            $env = file_get_contents($envFile);
            $env = explode("\n", $env);

            $data = [];

            foreach ($env as $key => $value) {
                $value = explode('=', $value);
                if (count($value) == 2) {
                    $data[$value[0]] = $value[1];
                }
            }
            return $data;
        }
        return null;
    }
}

if (!function_exists('getUserIdFromEmployeeId')) {
    /**
     * Get user id from employee id
     * @param string $employee_id - employee id
     * @return string $user_id - user id
     */
    function getUserIdFromEmployeeId($employee_id)
    {
        if (!$employee_id) {
            return null;
        }
        $employee = \App\Models\Employee::find($employee_id);
        return $employee->user_id;
    }
}

if (!function_exists('getEmployeeIdFromUserId')) {
    /**
     * Get employee id from user id
     * @param string $user_id - user id
     * @return string $employee_id - employee id
     */
    function getEmployeeIdFromUserId($user_id)
    {
        if (!$user_id) {
            return null;
        }
        $employee = \App\Models\Employee::where('user_id', $user_id)->first();
        return $employee->id;
    }
}

if (!function_exists('getUserIdFromPartnerContactId')) {
    /**
     * Get user id from partner contact id
     * @param string $contact_id - contact id
     * @return string $user_id - user id
     */
    function getUserIdFromPartnerContactId($contact_id)
    {
        if (!$contact_id) {
            return null;
        }
        $contact = \App\Models\PartnerContact::find($contact_id);
        if (!$contact) {
            return null;
        }
        return $contact->user_id;
    }
}

if (!function_exists('getPartnerIdFromUserId')) {
    /**
     * Get partner id from user id
     * @param string $user_id - user id
     * @return string $partner_id - partner id
     */
    function getPartnerIdFromUserId($user_id)
    {
        if (!$user_id) {
            return null;
        }
        $contact = \App\Models\PartnerContact::where('user_id', $user_id)->first();
        if (!$contact) {
            return null;
        }
        return $contact->partner_id;
    }
}

if (!function_exists('getPartnerContactIdFromUserId')) {
    /**
     * Get partner contact id from user id
     * @param string $user_id - user id
     * @return string $contact_id - contact id
     */
    function getPartnerContactIdFromUserId($user_id)
    {
        if (!$user_id) {
            return null;
        }
        $contact = \App\Models\PartnerContact::where('user_id', $user_id)->first();
        if (!$contact) {
            return null;
        }
        return $contact->id;
    }
}

if (!function_exists('sendWebhookForEvent')) {
    /**
     * Send webhook for event (event: partner:created, partner:updated, partner:deleted)
     * @param string $event - event
     * @param array $data - data
     * @return void
     */
    function sendWebhookForEvent($event, $data)
    {
        Event::dispatch(new WebhookEvent($event, $data));
    }
}

if (!function_exists('insertScheduleRun')) {
    /**
     * Insert schedule run to database
     * @param string $task - task name
     * @param string $status - status
     * @param string $output - output
     * @return void
     */
    function insertScheduleRun($task, $status, $output = null)
    {
        $task = DB::table('schedule_runs')->insert([
            'id' => Str::uuid(),
            'task' => $task,
            'status' => $status, // pending, running, success, failed
            'output' => $output,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return $task;
    }
}

if (!function_exists('updateScheduleRun')) {
    /**
     * Update schedule run in database
     * @param string $id - schedule run id
     * @param string $status - status
     * @param string $output - output
     * @return void
     */
    function updateScheduleRun($id, $status, $output = null)
    {
        $task = DB::table('schedule_runs')
            ->where('id', $id)
            ->update([
                'status' => $status, // pending, running, success, failed
                'output' => $output,
                'updated_at' => now(),
            ]);
        return $task;
    }
}

if (!function_exists('isAppInstalled')) {
    /**
     * Check if app is installed
     * @return bool
     */
    function isAppInstalled()
    {
        try {
            if (file_exists(base_path('/storage/install.lock'))) {
                return true;
            }

            if (settings('app_installed') == true) {
                if (!file_exists(base_path('/storage/install.lock'))) {
                    file_put_contents(base_path('/storage/install.lock'), 'installed');
                }
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }
}

if (!function_exists('getJwtPayloadData')) {
    /**
     * Get JWT payload data
     * @param string $token - JWT token
     * @return array $payload - payload data
     */
    function getJwtPayloadData($token)
    {
        $token = explode('.', $token);
        $payload = json_decode(base64_decode($token[1]), true);
        return $payload;
    }
}

if (!function_exists('generateRandomPassword')) {
    /**
     * Generate random password
     * @param int $length - length of password
     * @return string $password - generated password
     */
    function generateRandomPassword($length = 10)
    {
        return Str::random($length);
    }
}

if (!function_exists('dockerHealthResponse')) {
    /**
     * Get Docker health response
     * @return array
     */
    function dockerHealthResponse()
    {
        return [
            'status' => 'healthy',
            'id' => (string) Str::uuid(),
            'timestamp' => now(),
        ];
    }
}
