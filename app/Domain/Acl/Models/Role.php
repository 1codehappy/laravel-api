<?php

namespace App\Domain\Acl\Models;

use App\Domain\Acl\Database\Factories\RoleFactory;
use App\Domain\Acl\Presenters\RolePresenter;
use App\Support\Core\Concerns\Models\HasUuid;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    use HasFactory;
    use HasUuid;
    use PresentableTrait;

    /**
     * Presenter's class
     *
     * @var string
     */
    protected $presenter = RolePresenter::class;

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return RoleFactory::new();
    }
}
