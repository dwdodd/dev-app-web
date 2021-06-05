<?php

$files = [
    PATH_TO .'connections/Conn.php',
    PATH_TO .'resources/Encrypt.php'
];
foreach($files as $file) require_once($file);

class In
{
    public function __construct($email, $password)
    {
        // @$result = QueryManager::openquery("
        //     select * from app_usuarios
        //     inner join app_usuarios_tipo
        //     on app_usuarios.idtipousuario = app_usuarios_tipo.idtipousuario
        //     where app_usuarios.correo = '$email'
        //     and app_usuarios.clave = '".md5($password)."'
        //     and app_usuarios.idestatus = 1", new Conn
        // )[0];

        //if(!$result) $this->warning();

        //if(password_verify($password, $result->clave)){

            $_SESSION['user-time']       = (time()+24*60*60);
            $_SESSION['id-session']      = session_id();
            $_SESSION['user-token']      = Encrypt::datum('encrypt',$_SESSION['user-time']);
    
            exit(json_encode([
                'code' => 1,
                'userdata' => [
                    'username' => 'Usuario',
                    'timesession' => $_SESSION['user-time'],
                    'usertoken' => $_SESSION['user-token']
                ]
            ]));
        //}

        //unset($result);

        //$this->warning();
    }

    private function warning()
    {
        exit(json_encode([
            'code' => 2,
            'status' => 'Error',
            'error' => 'Correo o Clave incorrecta.'
        ]));
    }
}