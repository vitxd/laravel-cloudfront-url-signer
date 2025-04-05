<?php

use Dreamonkey\CloudFrontUrlSigner\Signer;

if (! function_exists('sign')) {
    function sign(string $url, ?DateTimeInterface $expiration = null): string
    {
        return app(Signer::class)->sign($url, $expiration);
    }
}
