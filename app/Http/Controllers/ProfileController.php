<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function changeTheme(Request $request)
    {
        $theme = $request->validate([
            'theme' => 'required|string|in:light,dark',
        ]);
        $this->profileService->changeTheme($theme['theme'] ?? 'light');
        return api_response(null, __('responses.theme_changed_successfully'));
    }

    public function getProfile()
    {
        $profile = $this->profileService->getProfile();

        return api_response($profile, __('responses.data_retrieved_successfully'));
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'language' => 'string',
        ]);

        $this->profileService->updateProfile($data);

        return api_response(null, __('responses.profile_updated_successfully'));
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:password',
        ]);

        $this->profileService->updatePassword($data);

        return api_response(null, __('responses.password_updated_successfully'));
    }

    public function set2FactorAuth(Request $request)
    {
        $url = $this->profileService->set2FactorAuth($request->all());

        return api_response($url, __('responses.two_factor_auth_enabled'));
    }

    public function enable2FactorAuth(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string',
            'secret' => 'required|string',
        ]);

        $enabled = $this->profileService->enable2FactorAuth($data);

        if (!$enabled) {
            return api_response(null, __('responses.invalid_2fa_code'), 400);
        }

        return api_response(null, __('responses.two_factor_auth_enabled'));
    }

    public function disable2FactorAuth()
    {
        $this->profileService->disable2FactorAuth();

        return api_response(null, __('responses.two_factor_auth_disabled'));
    }

    public function setProfilePicture(Request $request)
    {
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $this->profileService->setProfilePicture($request);

        return api_response(null, __('responses.profile_updated_successfully'));
    }

    public function deleteProfilePicture()
    {
        $this->profileService->deleteProfilePicture();

        return api_response(null, __('responses.profile_updated_successfully'));
    }

    public function getCurrentUserNotifications()
    {
        $notifications = $this->profileService->getCurrentUserNotifications();
        return api_response($notifications, __('responses.data_retrieved_successfully'));
    }

    public function markNotificationAsRead($id)
    {
        $this->profileService->markNotificationAsRead($id);

        return api_response(null, __('responses.notification_marked_as_read'));
    }

    public function deleteNotification($id)
    {
        $this->profileService->deleteNotification($id);

        return api_response(null, __('responses.data_deleted_successfully'));
    }
}
