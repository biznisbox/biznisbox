<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    protected $profileService;
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function getUserProfile()
    {
        $user = $this->profileService->getUserProfile();
        return $user;
    }

    public function updateUserProfile(Request $request)
    {
        $user = $this->profileService->updateProfile($request);
        return $user;
    }

    public function updateUserPassword(Request $request)
    {
        $user = $this->profileService->updatePassword($request);
        return $user;
    }

    public function changeAvatar(Request $request)
    {
        $user = $this->profileService->changeAvatar($request);
        return $user;
    }

    public function removeAvatar()
    {
        $user = $this->profileService->removeAvatar();
        return $user;
    }
}
