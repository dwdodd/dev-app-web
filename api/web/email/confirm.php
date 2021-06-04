<?php

define('PATH_TO', '../../../');

require_once PATH_TO . 'resources/Encrypt.php';

$decrypt_data = Encrypt::datum('decrypt',str_replace(' ','+',$_GET['follow_link']));

$data = explode('III', $decrypt_data);

$datum = (object)[
    'id'    => $data[0],
    'time'  => $data[1],
    'user'  => $data[2],
    'email' => $data[3]
];

if( $datum->id && $datum->time ){

    require_once PATH_TO . 'src/user/RepositoryVerifyUserAccess.php';
    $status = RepositoryVerifyUserAccess::status($datum->id);

    if($status == 0 || $status == 2){

        if( time() > $datum->time ){

            $link = Encrypt::datum('encrypt', $datum->id .'III' . (time()+1800) . 'III' . $datum->user . 'III' . $datum->email);

            $content = str_replace('{{ get-link }}', $link, file_get_contents('../view/expired.php'));
            exit($content);

        }
    }

    require_once PATH_TO . 'src/email/ServiceEmailConfirm.php';
    require_once PATH_TO . 'src/email/RepositoryEmailConfirm.php';

    $put = new ServiceEmailConfirm( new RepositoryEmailConfirm );

    if( $put( $datum->id ) == 1 ){
        $content = file_get_contents('../view/confirmed.php');
        exit( $content );
    }

    if( $put( $datum->id ) == 2 ){
        $content = file_get_contents('../view/already-confirmed.php');
        exit( $content );
    }

}

$content = file_get_contents('../view/not-allowed.php');
exit( $content );