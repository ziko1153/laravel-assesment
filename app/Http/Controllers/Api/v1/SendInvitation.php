<?php

namespace App\Http\Controllers\Api\v1;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\SendPin;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendInvitaitonMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SendInvitation extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.role:admin')->except(['register']);
    }


    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $invitation =  Invitation::create([
            'user_id' => Auth::user()->id,
            'email' => $request->email,
            'token' => Str::random()
        ]);

        Mail::to($request->email)->queue(new SendInvitaitonMail($invitation));

        return response()->json(['success' => true, 'message' => "Successfully send invitation to {$invitation->email}"]);
    }

    public function register(Request $request, $token)
    {

        $invitation = Invitation::where('token', $request->token)
            ->whereRaw("created_at > NOW() - INTERVAL 15 MINUTE")
            ->first();

        if (!$invitation) {
            return response()->json(['success' => false, 'message' => 'Sorry Token expired or Invalid Token'], 422);
        }

        // $user = User::where('email', $invitation->email)->first();

        // if ($user)   return response()->json(['success' => false, 'message' => 'This Email Already taken'], 422);

        $request = new Request(array_merge($request->all(), ['email' => $invitation->email]));


        $this->validateRegisterData($request);


        $user = User::create([
            'user_name' => $request->user_name,
            'email' => $invitation->email,
            'password' => Hash::make($request->password),
            'user_role' => 'user',
            'registered_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'pin' => random_int(100000, 999999)
        ]);

        $invitation->delete();

        Mail::to($user->email)->queue(new SendPin($user));

        return response()->json(['success' => true, 'user' => $user, 'message' => 'we have sent 6 digit pin to your email address, please verify this pin']);
    }

    public function verifyPin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'pin' => 'required|numeric|min:6'
        ]);

        $user = User::where('email', $request->email)->where('pin', $request->pin)->first();


        if (!$user || $user->email_verified == 1) return response()->json(['success' => false, 'message' => 'Already verified or incorrect pin and email'], 422);

        $user->email_verified = 1;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Successfully Email Verified and Registered']);
    }


    protected function validateRegisterData($request)
    {
        Validator::extend('without_spaces', function ($attr, $value) {

            return preg_match('/^\S*$/u', $value);
        });

        $request->validate([
            'user_name' => 'required|without_spaces|between:4,20|unique:users',
            'password' => 'required|confirmed|min:6',
            'email' => 'required|email|unique:users'

        ], [
            'user_name.without_spaces' => 'White Space Not Allowed'
        ]);
    }
}
