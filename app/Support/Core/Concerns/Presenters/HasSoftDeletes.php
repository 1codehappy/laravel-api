<?php

namespace App\Support\Core\Concerns\Presenters;

use Illuminate\Support\Carbon;

trait HasSoftDeletes
{
    /**
     * Get the right timezone for timestamp
     *
     * @return string|null
     */
    public function deletedAt(): ?string
    {
        return $this->deleted_at ?
            Carbon::create($this->deleted_at)->toDateTimeString() :
            null;
    }
}
