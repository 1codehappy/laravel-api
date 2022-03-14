<?php

namespace App\Domain\Acl\Models;

use App\Domain\Acl\Database\Factories\PermissionFactory;
use App\Domain\Acl\Presenters\PermissionPresenter;
use App\Support\Core\Concerns\Models\HasUuid;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    use HasFactory;
    use HasUuid;
    use PresentableTrait;

    /**
     * Presenter's class
     *
     * @var string
     */
    protected $presenter = PermissionPresenter::class;

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return PermissionFactory::new();
    }
}
