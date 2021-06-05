<?php

class Template
{
    public static function html($title, $content)
    {
        if(!isset($_SESSION)) session_start();
        if(!isset($_SESSION['id-session'])){
            self::header_location();
        }

        session_regenerate_id(true);

        require_once PATH_TO . 'config/system/BaseUrl.php';

        $top = str_replace(
            ['{{ title }}', '{{ host }}'],
            [$title, BaseUrl::url()],
            file_get_contents(PATH_TO . 'config/layout/html-content/html-top.php')
        );

        $con = str_replace(
            '{{ host }}',
            BaseUrl::url(),
            $content
        );

        $footer = str_replace(
            '{{ year }}',
            date('Y'),
            file_get_contents(PATH_TO . 'config/layout/html-content/footer.php')
        );

        $end = str_replace(
            '{{ host }}',
            BaseUrl::url(),
            file_get_contents(PATH_TO . 'config/layout/html-content/html-end.php')
        );

        exit($top.$con.$footer.$end);
    }

    public static function login()
    {
        if(!isset($_SESSION)) session_start();

        require_once 'config/system/BaseUrl.php';

        $content = str_replace(
            [
                '{{ host }}',
                '{{ token }}',
                '{{ description }}',
                '{{ keyword }}'
            ],
            [
                BaseUrl::url(),
                self::token(),
                'Solución técnológica',
                'solución, solucion, técnológica'
            ],
            file_get_contents('config/layout/html-content/login.php')
        );
        exit($content);
    }
    
    private static function token()
    {
        $_SESSION['token'] = password_hash(sha1((uniqid())), PASSWORD_DEFAULT);
        return $_SESSION['token'];
    }

    public static function header_location()
    {
        require_once PATH_TO . 'config/system/BaseUrl.php';
        return BaseUrl::header_location();
    }
}