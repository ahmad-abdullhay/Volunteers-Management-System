<?php


namespace App\Common;

class SharedMessage
{
    public $data;
    public $resultCode;
    public $status;
    public $message;
    public $exception;
    public $statusCode;

    public function __construct($message, $data, $status, $exception, $statusCode = null){
        $this->message = $message;
        $this->data = $data;
        $this->status = $status;
        $this->exception = $exception;
        $this->statusCode = $statusCode;
    }
}

