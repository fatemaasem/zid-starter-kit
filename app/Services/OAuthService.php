<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\DTO\OAuthTokenDTO;

class OAuthService
{
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;

    public function __construct()
    {
        $this->clientId = config('services.zid.client_id');
        $this->clientSecret = config('services.zid.client_secret');
        $this->redirectUri = route('oauth.callback');
    }
    public function getAuthorizationUrl()
    {
        return 'https://oauth.zid.sa/oauth/authorize?' . http_build_query([
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
        ]);
    }
    public function exchangeCodeForTokens($code): OAuthTokenDTO
    {
        $response = Http::post('https://oauth.zid.sa/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'code' => $code,
        ]);

        $tokens = $response->json();
        return new OAuthTokenDTO($tokens);
    }

    public function refreshToken($refreshToken): OAuthTokenDTO
    {
        $response = Http::post('https://oauth.zid.sa/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
        ]);

        $tokens = $response->json();
        return new OAuthTokenDTO($tokens);
    }
}
