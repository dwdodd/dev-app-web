<?php

class JsonFormat
{
    public function __construct($data)
    {
        exit(json_encode( $data ));
    }
}