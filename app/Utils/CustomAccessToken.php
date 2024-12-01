<?php

namespace App\Utils;

use Laravel\Passport\Bridge\AccessToken;
use App\Helpers\CustomClaimsAccessTokenTrait;

class CustomAccessToken extends AccessToken
{
    use CustomClaimsAccessTokenTrait;
}
