<?php

namespace Hire\Support\Concerns\Presenters;

use Hire\Support\Concerns\Storages\HasCloudFilesystem;
use Illuminate\Support\Carbon;

/**
 * Trait HasCloudFiles.
 */
trait HasCloudFiles
{
    use HasCloudFilesystem;

    /**
     * Generate a URL for a given cloud object.
     *
     * @param string $path
     * @param Carbon|null $expiration
     * @return string|null
     */
    protected function generateCloudUrl(string $path, Carbon $expiration = null): ?string
    {
        // if no expiration was provided, return non-expiring, maybe private URL.
        if (! $expiration) {
            return $this->getCloudFileUrl($path);
        }

        // return expiring URL otherwise.
        return $this->getCloudTemporaryUrl($path, $expiration);
    }
}
