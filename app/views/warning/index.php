<?php
error_reporting(0);
define('PATH_TO', '../../../');

require_once PATH_TO . 'config/system/Path.php';

$info = Path::_path($_SERVER['REQUEST_URI']);

require_once PATH_TO . 'config/layout/Template.php';

$content = str_replace(
    '{{ page }}',
    !$info->info[2] ? '???' : $info->info[2],
    file_get_contents('elements/404.php')
);

Template::html('Error 404', $content);