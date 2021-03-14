<?php

namespace App\Domain\Permission\Models;

use App\Domain\Permission\Presenters\PermissionPresenter;
use App\Support\Concerns\Models\HasUuid;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    use HasUuid;
    use PresentableTrait;

    /**
     * Presenter's class
     *
     * @var string
     */
    protected $presenter = PermissionPresenter::class;
}
