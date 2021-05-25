<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\TestMail;
use Hamcrest\Description;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class MailController extends Controller
{
    public function sendEmail(Request $request){
        $fields = $request->validate([
            'email' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user) return response([
                'message' => 'Wrong email'
            ]);

        $pass = Str::random();

        $data = [
            'title' => 'Hi, you forgot your password.',
            'body' => 'Your new password has been ',
            'password' => $pass,
            'description' => 'You can change this when login.'
        ];

        Mail::to($user->email)->send(new TestMail($data));

        $pass = bcrypt($pass);
        $request['password'] = $pass;
        $user->update($request->all());
        return response($user, 201);
    }
}
