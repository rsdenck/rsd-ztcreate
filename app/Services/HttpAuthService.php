<?php

namespace App\Services;

class HttpAuthService
{
    public const AUTH_NONE = 0;
    public const AUTH_BASIC = 1;
    public const AUTH_NTLM = 2;
    public const AUTH_KERBEROS = 3;
    public const AUTH_DIGEST = 4;
    public const AUTH_BEARER = 5;

    public function getAuthMethods(): array
    {
        return [
            self::AUTH_NONE => 'None',
            self::AUTH_BASIC => 'Basic Auth',
            self::AUTH_NTLM => 'NTLM',
            self::AUTH_KERBEROS => 'Kerberos',
            self::AUTH_DIGEST => 'Digest',
            self::AUTH_BEARER => 'Bearer Token',
        ];
    }
}
