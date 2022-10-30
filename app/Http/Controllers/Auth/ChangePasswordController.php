<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ChangePasswordController extends Controller
{
     /**
     * Change password
     *
     * @param  [string] old_password
     * @param  [string] new_password
     * @param  [string] new_password_confirmation
     * @return [string] message
     * @return [json] user object
     */
    public function change(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            $response = ['message' => 'old password mismatch'];
            return response($response, 422);
        }

        #Update the new Password
        $user = auth()->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json($user);
    }
}