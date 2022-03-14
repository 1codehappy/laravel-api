<?php

namespace App\Support\Core\Concerns\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasSelfRelationship
{
    /**
     * Get parent
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(get_called_class(), 'parent_id');
    }

    /**
     * Get children
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(get_called_class(), 'parent_id');
    }
}
