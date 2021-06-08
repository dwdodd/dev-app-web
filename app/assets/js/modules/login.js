import url from './base_url.js';

document.addEventListener("DOMContentLoaded", () => {

    const ValidateEmail = mail  => {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
        return (true)
        }
        return (false)
    }

    $('#btn-login').click( e => {

        e.preventDefault();

        $('#btn-login').prop('disabled', true);
        $('#btn-login').html(`Accediendo... <span class="spinner-border spinner-border-sm text-light" role="status"></span>`);

        let email  = $('#email').val().trim();
        let passwd = $('#passwd').val().trim();
        let token  = $('#token').val().trim();

        if(!email){
            $('#email').focus();
            $('#btn-login').html(`Acceder`);
            $('#btn-login').prop('disabled', false);
            return toastr.error(`El email electrónico es obligatorio ¡Ingresa uno válido!`, 'Mensaje del sistema');
        }

        if(!ValidateEmail(email)){
            $('#email').focus();
            $('#btn-login').html(`Acceder`);
            $('#btn-login').prop('disabled', false);
            return toastr.warning(`El email electrónico es incorrecto. ¡Ingresa una dirección de email válida!`, 'Mensaje del sistema');
        }

        if(!passwd){
            $('#passwd').focus();
            $('#btn-login').html(`Acceder`);
            $('#btn-login').prop('disabled', false);
            return toastr.error(`La passwd es obligatoria ¡Ingresa tu passwd!`, 'Mensaje del sistema');
        }

        if(!token){
            return toastr.error(`Ups..! Lo siento no tienes permiso.`, 'Mensaje del sistema');
        }

        email   = CryptoJS.AES.encrypt(JSON.stringify(email),fdecoderto,{ format: CryptoJSAesJson }).toString();
        passwd  = CryptoJS.AES.encrypt(JSON.stringify(passwd),fdecoderto,{ format: CryptoJSAesJson }).toString();

        fetch(`${url}login`,{
            method:'post',
            body: JSON.stringify({ email, passwd, token }),
            headers:{ 'Content-Type': 'application/json' }
        })
        .then(req => req.json())
        .then(res => {

            if(res.code == 1){
                localStorage.setItem('_usrdt', JSON.stringify(res.userdata));

                setTimeout(() => {
                    $('#btn-login').html(`Acceder`);
                    toastr.success(`Bienvenido`, 'Mensaje del sistema');
                    setTimeout(() => window.location = `${url}inicio`, 1500);
                }, 1000);
                
            }
            if(res.code == 2){
                $('#btn-login').html(`Acceder`);
                $('#btn-login').prop(`disabled`, false);
                return toastr.error(`Lo sentimos. ${res.error}`, 'Mensaje del sistema');
            }

        })
        .catch(err => console.log(err));

    });

});