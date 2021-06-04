<?php

function require_multi($files) {
    $files = func_get_args();
    foreach($files as $file) require_once($file);
}