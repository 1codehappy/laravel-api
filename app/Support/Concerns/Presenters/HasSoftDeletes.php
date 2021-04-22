<?php

namespace Hire\Support\Concerns\Presenters;

use Hire\Support\Facades\Timezone;

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
            Timezone::create($this->deleted_at)->toDateTimeString()
        :
            null;
    }
}
