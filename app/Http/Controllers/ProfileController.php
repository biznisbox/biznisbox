<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfileService;
/**
 * @group User Profile
 *
 * APIs for managing current user profile
 */
class ProfileController extends Controller
{
    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Change the theme
     * 
     * @param  object  $request data from the form (theme)
     * @return array $response response
     */
    public function changeTheme(Request $request)
    {
        $theme = $request->validate([
            'theme' => 'required|string|in:light,dark',
        ]);
        $this->profileService->changeTheme($theme['theme'] ?? 'light');
        return api_response(null, __('responses.theme_changed_successfully'));
    }

    /**
     * Get the profile
     * 
     * @return array $profile profile
     */
    public function getProfile()
    {
        $profile = $this->profileService->getProfile();

        return api_response($profile, __('responses.data_retrieved_successfully'));
    }

    /**
     * Update the profile
     * 
     * @param  object  $request data from the form (first_name, last_name, email, language)
     * @return array $response response
     */
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

    /**
     * Update the password
     * 
     * @param  object  $request data from the form (current_password, password, password_confirmation)
     * @return array $response response
     */
    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|same:password',
        ]);

        $passwordChange = $this->profileService->updatePassword($data);

        if (!$passwordChange) {
            return api_response(null, __('responses.invalid_current_password'), 400);
        }

        return api_response(null, __('responses.password_updated_successfully'));
    }

    /**
     * Set the 2 factor auth
     * 
     * @return array $response response
     */
    public function set2FactorAuth(Request $request)
    {
        $url = $this->profileService->set2FactorAuth($request->all());

        return api_response($url, __('responses.two_factor_auth_enabled'));
    }

    /**
     * Enable 2 factor auth
     * 
     * @param  object  $request data from the form (code, secret)
     * @return array $response response
     */
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

    /**
     * Disable 2 factor auth
     * 
     * @return array $response response
     */
    public function disable2FactorAuth()
    {
        $this->profileService->disable2FactorAuth();

        return api_response(null, __('responses.two_factor_auth_disabled'));
    }

    /**
     * Set the profile picture
     * 
     * @return array $response response
     */
    public function setProfilePicture(Request $request)
    {
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $this->profileService->setProfilePicture($request);

        return api_response(null, __('responses.profile_updated_successfully'));
    }

    /**
     * Delete the profile picture
     * 
     * @return array $response response
     */
    public function deleteProfilePicture()
    {
        $this->profileService->deleteProfilePicture();

        return api_response(null, __('responses.profile_updated_successfully'));
    }

    /**
     * Get the current user notifications
     * 
     * @return array $notifications notifications
     */
    public function getCurrentUserNotifications()
    {
        $notifications = $this->profileService->getCurrentUserNotifications();
        return api_response($notifications, __('responses.data_retrieved_successfully'));
    }

    /**
     * Mark notification as read
     * 
     * @param  string  $id id of the notification
     * @return array $response response
     */
    public function markNotificationAsRead($id)
    {
        $this->profileService->markNotificationAsRead($id);

        return api_response(null, __('responses.notification_marked_as_read'));
    }

    /**
     * Delete notification
     * 
     * @return array $response response
     */
    public function deleteNotification($id)
    {
        $this->profileService->deleteNotification($id);

        return api_response(null, __('responses.data_deleted_successfully'));
    }
}
