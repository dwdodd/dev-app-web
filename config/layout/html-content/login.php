<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ description }}" />
    <meta name="keywords" content="{{ keyword }}" />
    <link href="{{ host }}app/assets/img/favicon.png" rel="shortcut icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <title>Mi Web App</title>

    <style>
        div#form{
            margin: 10% auto;
            text-align: center;
        }
        input{
            margin-bottom: 5px;
        }
        p{
            font-size: 24px;
        }
    </style>
</head>
<body>

    <div id="form">
        <form autocomplete="off">
            <label for="email">Email</label>
            <input type="email" id="email" value="prueba@mail.com" />
            <br>
            <label for="passwd">Password</label>
            <input type="password" id="passwd" value="1234" />
            <input type="hidden" id="token" value="{{ token }}" />
            <br>
            <button class="btn btn-primary" id="btn-login">Acceder</button>
        </form>
        <br>
        <p>
            Estos datos los puedes modificar accediendo a <b>config/layout/html-content/login.php</b>
        </p>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ host }}app/assets/js/library/mycrypto-format.js" ></script>
    <script src="{{ host }}app/assets/js/library/mycrypto.js" ></script>
    <script src="{{ host }}app/assets/js/modules/login.js" type="module" ></script>
</body>
</html>