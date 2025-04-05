<?php

use Dreamonkey\CloudFrontUrlSigner\Signer;

if (!function_exists('sign')) {
    /**
     * A helper method to sign an URL using a CloudFront canned policy.
     *
     * @param string $url
     * @param \DateTime|int|null $expiration
     *
     * @return string
     */
    function sign(string $url, $expiration = null): string
    {
        return app(Signer::class)->sign($url, $expiration);
    }
}
