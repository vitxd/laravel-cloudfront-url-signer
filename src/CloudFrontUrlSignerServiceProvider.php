<?php

namespace Dreamonkey\CloudFrontUrlSigner;

use Aws\CloudFront\UrlSigner;
use DateTimeImmutable;
use Dreamonkey\CloudFrontUrlSigner\Exceptions\InvalidKeyPairId;
use Illuminate\Support\ServiceProvider;

class CloudFrontUrlSignerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes(
            [
                __DIR__.'/../config/cloudfront-url-signer.php' => config_path('cloudfront-url-signer.php'),
            ],
            'config',
        );
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/cloudfront-url-signer.php', 'cloudfront-url-signer');

        $this->app->singleton(Signer::class, function () {
            $config = config('cloudfront-url-signer');

            if ($config['key_pair_id'] === '') {
                throw new InvalidKeyPairId('Key pair id cannot be empty');
            }

            return new CloudFrontUrlSigner(
                new UrlSigner($config['key_pair_id'], $config['private_key_path']),
                (new DateTimeImmutable)->modify(sprintf('%d days', $config['default_expiration_time_in_days'])),
            );
        });

        $this->app->alias(Signer::class, 'cloudfront-url-signer');
    }
}
