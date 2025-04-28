<?php

namespace App\Exceptions;

use Exception;

class ProductException extends Exception
{
    public function __construct(protected $message, protected $statusCode) {}

    public function render()
    {
        return response()->json([
            'status'  => 'error',
            'message' => $this->message
        ], $this->statusCode);
    }
}
