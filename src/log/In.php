<?php

require_once '../../../connections/Conn.php';
require_once '../../../resources/Encrypt.php';

class In
{
    public function __construct($email, $password)
    {
        @$result = QueryManager::openquery("
            select * from app_usuarios
            inner join app_usuarios_tipo
            on app_usuarios.idtipousuario = app_usuarios_tipo.idtipousuario
            where app_usuarios.correo = '$email'
            and app_usuarios.clave = '".md5($password)."'
            and app_usuarios.idestatus = 1", new Conn
        )[0];

        if(!$result) $this->warning();

        //if(password_verify($password, $result->clave)){

            //session_start();

            $_SESSION['idusuario']       = $result->idusuario;
            $_SESSION['idtipousuario']   = $result->idtipousuario;
            $_SESSION['tipousuario']     = $result->tipousuario;
            $_SESSION['nombre']          = $result->nombre;
            $_SESSION['imagen']          = $result->imagen;
            $_SESSION['idsexo']          = $result->idsexo;
            $_SESSION['idmodalidad']     = $result->idmodalidad;
            $_SESSION['nombrecomercial'] = $result->nombrecomercial;
            $_SESSION['idfarmaceutica']  = $result->idfarmaceutica;
            $_SESSION['user-time']       = (time()+24*60*60);
            $_SESSION['json-web-token']  = Encrypt::datum('encrypt',$result->idusuario.'III'.$result->idtipousuario.'III'.$_SESSION['user-time']);
            $_SESSION['id-session']      = session_id();
            $_SESSION['user-token']      = Encrypt::datum('encrypt',$_SESSION['json-web-token']);
    
            exit(json_encode([
                'code' => 1,
                'codeuser' => $_SESSION['idtipousuario'],
                'username' => $_SESSION['nombre'],
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