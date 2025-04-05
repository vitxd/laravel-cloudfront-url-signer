<?php

namespace Dreamonkey\CloudFrontUrlSigner;

use DateTimeInterface;

interface Signer
{
    /**
     * Get a secure URL to a controller action.
     */
    public function sign(string $url, ?DateTimeInterface $expiration): string;
}
