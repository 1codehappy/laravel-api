<?php

namespace App\Domain\User\Presenters;

use App\Support\Concerns\Presenters\HasTimestamps;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    use HasTimestamps;
}
