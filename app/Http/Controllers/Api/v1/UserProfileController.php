<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\ImageHandleTraits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    use ImageHandleTraits;
    public function  update(Request $request)
    {
        $user = Auth::user();

        Validator::extend('without_spaces', function ($attr, $value) {

            return preg_match('/^\S*$/u', $value);
        });

        // Validation Data
        $request->validate([
            'name' => 'nullable|max:50|min:3',
            'user_name' => 'nullable|without_spaces|between:4,20|unique:users,user_name,' . $user->id,
            'avatar' => 'nullable|max:300|mimes:jpeg,jpg,png|dimensions:min_width=256,max_height=256',
        ]);

        if ($request->file('avatar')) {
            if (!empty($user->avatar)) {
                $this->deleteImage($user->avatar, 'users');
            }
            $user->avatar =    $this->uploadImage($request->file('avatar'), 'images/users');
        }

        $user->name = $request->name ?? $user->name;
        $user->user_name = $request->user_name ?? $user->user_name;

        if ($user->save()) return response()->json(['success' => true, 'message' => 'Successfully User Profile Updated']);

        return response()->json(['success' => false, 'message' => 'Sorry we could not  update']);
    }
}
