<?php

namespace Dreamonkey\CloudFrontUrlSigner;

use Aws\CloudFront\UrlSigner;
use DateTimeImmutable;
use DateTimeInterface;
use Dreamonkey\CloudFrontUrlSigner\Exceptions\InvalidExpiration;

class CloudFrontUrlSigner implements Signer
{
    public function __construct(
        private readonly UrlSigner $urlSigner,
        private readonly DateTimeInterface $defaultExpirationTimeInDays,
    ) {}

    /**
     * Get a secure URL to a controller action.
     *
     * @throws InvalidExpiration
     */
    public function sign(string $url, ?DateTimeInterface $expiration = null): string
    {
        $expiration = $this->getExpirationTimestamp($expiration ??
            $this->defaultExpirationTimeInDays);

        return $this->urlSigner->getSignedUrl($url, $expiration);
    }

    /**
     * Check if a timestamp is in the future.
     */
    private function isFuture(DateTimeInterface $timestamp): bool
    {
        return $timestamp >= (new DateTimeImmutable);
    }

    /**
     * Retrieve the expiration timestamp for a link based on an absolute DateTime or a relative number of days.
     *
     * @throws InvalidExpiration
     */
    private function getExpirationTimestamp(DateTimeInterface $expiration): int
    {
        if (! $this->isFuture($expiration)) {
            throw new InvalidExpiration('Expiration date must be in the future');
        }

        return $expiration->getTimestamp();
    }
}
