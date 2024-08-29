<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OAuthService;

class OAuthController extends Controller
{
    protected $oauthService;

    public function __construct(OAuthService $oauthService)
    {
        $this->oauthService = $oauthService;
    }

    public function redirect()
    {
        $authorizationUrl = $this->oauthService->getAuthorizationUrl();
        return redirect($authorizationUrl);
    }

    public function callback(Request $request)
    {
        if ($request->has('code')) {
            $tokens = $this->oauthService->exchangeCodeForTokens($request->code);

            $authToken = $tokens['authorization'];
            $xManagerToken = $tokens['access_token'];
            $refreshToken = $tokens['refresh_token'];

            $user = $request->user();
            $user->update([
                'auth_token' => $authToken,
                'x_manager_token' => $xManagerToken,
                'refresh_token' => $refreshToken,
            ]);

            return redirect()->route('dashboard')->with('success', 'Tokens updated successfully.');
        }

        return redirect()->route('dashboard')->with('error', 'Authorization code not found.');
    }
}
