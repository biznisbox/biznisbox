<?php

namespace App\Resolvers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserResolver implements \OwenIt\Auditing\Contracts\UserResolver
{
    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public static function resolve()
    {
        if (
            request()->header('Authorization') &&
            request()->header('Authorization') != 'Bearer null' &&
            request()->header('Authorization') != '' &&
            !request()->header('X-CLIENT-ROUTE')
        ) {
            return User::find(user_data()->data->id);
        }
        return null;
    }
}
