<?php

namespace App\DTO;

class OAuthTokenDTO
{
    public string $authToken;
    public string $xManagerToken;
    public string $refreshToken;

  
    public function __construct(array $data)
    {
        $this->authToken = $data['authorization'];
        $this->xManagerToken = $data['access_token'];
        $this->refreshToken = $data['refresh_token'];
    }

}
