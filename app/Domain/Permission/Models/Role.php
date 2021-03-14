<?php

namespace App\Domain\Permission\Models;

use App\Domain\Permission\Presenters\RolePresenter;
use App\Support\Concerns\Models\HasUuid;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    use HasUuid;
    use PresentableTrait;

    /**
     * Presenter's class
     *
     * @var string
     */
    protected $presenter = RolePresenter::class;
}
