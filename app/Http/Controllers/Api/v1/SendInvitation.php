<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendInvitaitonMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    public function register(Request $request)
    {

        return  $request;
    }
}
