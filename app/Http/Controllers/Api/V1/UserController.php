<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

use packages\Infrastructure\ExternalApi\Tinder\TinderExternalApiInterface;

class UserController extends Controller
{
    protected $tinderExternalApi;

    public function __construct(
        TinderExternalApiInterface $tinderExternalApi
    )
    {
        $this->tinderExternalApi = $tinderExternalApi;
    }

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

    public function swipe(Request $request)
    {
        // FIXME loop in loop する

        $user          = User::where('id', $request->input('user_id'))->first();
        $tinderUsers   = $this->tinderExternalApi->fetchUserList($user->x_auth_token);

        foreach ($tinderUsers as $key => $tinderUser) {
            $response = $this->tinderExternalApi->swipe($user->x_auth_token, $tinderUser['user']['_id']);
            \Log::info($tinderUser['user']['_id']);
            logger($response);
        }
    }
}
