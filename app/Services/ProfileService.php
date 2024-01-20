<?php

namespace App\Services;

use App\Models\User;
use App\Models\Sessions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function getUserProfile()
    {
        $user = User::find(user_data()->data->id);
        $user->initials = $user->getInitials();
        $user->sessions = Sessions::where('user_id', $user->id)
            ->latest()
            ->get();
        activity_log(user_data()->data->id, 'get own profile', $user->id, 'App\Services\ProfileService', 'getUserProfile', 'User');
        if ($user) {
            return api_response($user);
        }
        return api_response(null, __('response.user.not_found'), 404);
    }

    public function updateProfile($request)
    {
        $user = User::find(user_data()->data->id);

        $user = $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'timezone' => $request->timezone,
            'language' => $request->language,
        ]);
        if ($user) {
            return api_response($user, __('response.user.update_success'));
        }
        return api_response(null, __('response.user.not_found'), 404);
    }

    public function updatePassword($request)
    {
        $user = User::find(user_data()->data->id);
        if ($user) {
            if ($request->password != '' && $request->confirm_password != '') {
                if ($request->password == $request->confirm_password) {
                    $user->password = Hash::make($request->password);
                    $user->save();
                    return api_response($user, __('response.user.password_updated'));
                }
                return api_response(null, __('response.user.password_not_match'), 400);
            }
            return api_response(null, __('response.user.password_empty'), 400);
        }
        return api_response(null, __('response.user.not_found'), 404);
    }

    public function changeAvatar($request)
    {
        if ($request->hasFile('picture')) {
            $user = User::find(user_data()->data->id);

            $user_avatar = Str::after($user->picture, 'avatars/');
            if ($user->picture != null) {
                Storage::disk('local')->delete('public/avatars/' . $user_avatar);
            }

            $file = $request->file('picture');
            $filename = $file->hashName();
            $file->storeAs('public/avatars', $filename, 'local');

            $user->picture = $filename;
            $user->save();

            return api_response(null, __('response.user.avatar_updated'));
        }
        return api_response(null, __('response.user.avatar_not_found'), 404);
    }

    public function removeAvatar()
    {
        $user = User::find(user_data()->data->id);
        if ($user->picture != null) {
            $user_avatar = Str::after($user->picture, 'avatars/');
            Storage::disk('local')->delete('public/avatars/' . $user_avatar);
            $user->picture = null;
            $user->save();
            return api_response(null, __('response.user.avatar_deleted'));
        }
        return api_response(null, __('response.user.avatar_not_found'), 404);
    }
}
