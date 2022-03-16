<?php

namespace App\Support\Core\Contracts\Events;

use Illuminate\Queue\SerializesModels;

abstract class Event
{
    use SerializesModels;
}
