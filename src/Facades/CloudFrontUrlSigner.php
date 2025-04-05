<?php

namespace Dreamonkey\CloudFrontUrlSigner\Facades;

use DateTimeInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method string sign(string $url, ?DateTimeInterface $expiration = null)
 */
class CloudFrontUrlSigner extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'cloudfront-url-signer';
    }
}
