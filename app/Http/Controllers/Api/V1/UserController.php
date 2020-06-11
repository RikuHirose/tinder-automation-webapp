<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    // public function storeToken(Request $request)
    // {
    //     logger($request->input('x_auth_token'));

    //     $user->fill([
    //       'x_auth_token' => $request->input('x_auth_token')
    //     ])->save();

    //     return response()->json(['success' => true])
    // }

    public function integrate(Request $request)
    {
        $token = exec('node '.public_path('js/puppet.js'));
        $user  = User::where('id', $request->input('user_id'))->first();
        \Log::info($token);
        logger($user);

        $user->fill([
          'x_auth_token' => $token
        ])->save();

        return response()->json(['success' => true]);
    }
}
