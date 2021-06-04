<?php

class ErrorPublisher
{
    public function __construct($code, $status, $error)
    {
        session_destroy();
        exit(json_encode([
            'code' => $code,
            'status' => $status,
            'error' => $error
        ]));
    }
}