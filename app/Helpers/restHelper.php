<?php

namespace App\Helpers;

class User
{
    public $status,
        $status_code, $success, $message, $data;
    public static function success($another_data, $message)
    {
        $this->status = "OK";
        $this->status_code = 200;
        $this->success = true;
        $this->message = $message;
        $this->$data = $another_data;
    }
}
