<?php

namespace App\Services;

use PragmaRX\Google2FA\Google2FA;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    /**
     * Change the theme
     *
     * @param $theme
     */
    public function changeTheme($theme)
    {
        $user = User::find(auth()->id());
        $user->theme = $theme;
        $user->save();
    }

    /**
     * Get the profile
     *
     * @return mixed
     */
    public function getProfile()
    {
        $user = User::with('sessions', 'roles', 'permissions')->find(auth()->id());
        return $user;
    }

    /**
     * Update the profile
     *
     * @param $data
     */
    public function updateProfile($data)
    {
        $user = User::find(auth()->id());

        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'language' => $data['language'],
        ]);
    }

    /**
     * Update the password
     *
     * @param $data
     */
    public function updatePassword($data)
    {
        $user = User::find(auth()->id());
        // Check if the current password is correct
        if (!Hash::check($data['current_password'], $user->password)) {
            return false;
        }

        // Update the password
        $user->update([
            'password' => $data['password'],
        ]);

        return true;
    }

    /**
     * Set 2 factor authentication
     *
     * @return array
     */
    public function set2FactorAuth()
    {
        $user = User::find(auth()->id());
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();

        DB::table('2fa')->insert([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'secret' => $secret,
        ]);

        $url = $google2fa->getQRCodeUrl(settings('company_name'), $user->email, $secret);

        return [
            'secret' => $secret,
            'url' => $url,
        ];
    }

    /**
     * Enable 2 factor authentication
     *
     * @param $data
     * @return bool
     */
    public function enable2FactorAuth($data)
    {
        $user = User::find(auth()->id());

        $google2fa = new Google2FA();
        $secret = DB::table('2fa')
            ->where([
                'user_id' => $user->id,
                'enabled' => false,
                'secret' => $data['secret'],
            ])
            ->first()->secret;
        $valid = $google2fa->verifyKey($secret, $data['code'], 2);

        if ($valid) {
            DB::table('2fa')
                ->where('user_id', $user->id)
                ->where('secret', $secret)
                ->update([
                    'enabled' => true,
                ]);

            DB::table('2fa')->where('user_id', $user->id)->where('secret', '!=', $secret)->delete();

            User::find(auth()->id())->update(['two_factor_auth' => true]);

            return true;
        }
        return false;
    }

    /**
     * Disable 2 factor authentication
     */
    public function disable2FactorAuth()
    {
        $user = User::find(auth()->id());

        DB::table('2fa')->where('user_id', $user->id)->delete();

        User::find(auth()->id())->update(['two_factor_auth' => false]);
    }

    /**
     * Set the profile picture
     *
     * @param Request $request
     */
    public function setProfilePicture($request)
    {
        if ($request->hasFile('picture')) {
            $user = User::find(auth()->id());
            if ($user->picture && $user->picture !== $user->id . '.png') {
                Storage::disk('public')->delete($user->picture);
            }
            $file = $request->file('picture');
            $filename = $file->hashName();
            Storage::disk('public')->put($filename, file_get_contents($file));
            $user->picture = $filename;
            $user->save();
        }
    }

    /**
     * Delete the profile picture
     */
    public function deleteProfilePicture()
    {
        $user = User::find(auth()->id());
        if ($user->picture && $user->picture !== $user->id . '.png') {
            Storage::disk('public')->delete($user->picture);
        }
        $user->picture = $user->id . '.png';
        $user->save();
    }

    /****************************************************
     *                     Notifications
     ****************************************************/

    /**
     * Get all notifications for the current user
     *
     * @return mixed
     */
    public function getCurrentUserNotifications()
    {
        return Notification::getUserNotifications(auth()->id());
    }

    /**
     * Mark a notification as read
     *
     * @param $notification_id
     */
    public function markNotificationAsRead($notification_id)
    {
        $notification = Notification::where('id', $notification_id)
            ->where('user_id', auth()->id())
            ->first();
        return $notification->markAsRead();
    }

    /**
     * Delete a notification
     *
     * @param $notification_id
     */
    public function deleteNotification($notification_id)
    {
        $notification = Notification::where('id', $notification_id)
            ->where('user_id', auth()->id())
            ->first();
        return $notification->delete();
    }
}
