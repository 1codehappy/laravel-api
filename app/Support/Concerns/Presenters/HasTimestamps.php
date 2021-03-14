<?php

namespace App\Support\Concerns\Presenters;

use Illuminate\Support\Carbon;

trait HasTimestamps
{
    /**
     * Get the right timezone for timestamp
     *
     * @return string|null
     */
    public function createdAt(): ?string
    {
        return $this->created_at ?
            Carbon::parse($this->created_at)->toDateTimeString()
        :
            null;
    }

    /**
     * Get the right timezone for timestamp
     *
     * @return string|null
     */
    public function updatedAt(): ?string
    {
        return $this->updated_at ?
            Carbon::parse($this->updated_at)->toDateTimeString()
        :
            null;
    }
}
