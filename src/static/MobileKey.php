<?php

class MobileKey
{
    public function __construct()
    {
        if(!in_array(@$_GET['key'], ['AndroidVyJ8oMeR'])){
            exit(json_encode([
                'code' => 3,
                'status' => 'error',
                'error' => 'No estas autenticado.'
            ]));
        };
    }
}
new MobileKey;