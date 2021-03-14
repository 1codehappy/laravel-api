<?php

namespace App\Support\Exceptions;

use Illuminate\Support\Facades\Lang;

class InvalidDataTransferObject extends Exception
{
    /**
     * Constructor
     *
     * @param string $message
     */
    public function __construct(string $message = null)
    {
        parent::__construct($message ?? Lang::get('invalid_data_transfer_object'));
    }
}
