// Ajax post  
function login() {
    $("#formLogin").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formLogin').attr('action'),
                type: "POST",
                data: $('#formLogin').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitFormLogin").disabled = true;
                },
                success: function (response) {
                    if (response.status == true) {
                        $.toast({
                            heading: response.menssagem.heading,
                            text: response.menssagem.description,
                            icon: response.menssagem.status,
                            loader: true,        // Change it to false to disable loader
                            position: 'top-right',
                            showHideTransition: 'plain', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                            textAlign: 'left',  // Text alignment i.e. left, right or center
                            loader: true,  // Whether to show loader or not. True by default
                            loaderBg: '#9EC600',  // Background color of the toast loader
                            beforeShow: function () { }, // will be triggered before the toast is shown
                            afterShown: function () {
                                setTimeout(function () {
                                    window.location.reload(1);
                                }, 900);
                            }, // will be triggered after the toat has been shown
                            beforeHide: function () { }, // will be triggered before the toast gets hidden
                            afterHidden: function () { }  // will be triggered after the toast has been hidden
                        });

                    } else {
                        if (response.menssagem != null) {
                            $.toast({
                                heading: response.menssagem.heading,
                                text: response.menssagem.description,
                                icon: response.menssagem.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                        if (response.error != null) {
                            $.toast({
                                heading: response.error.heading,
                                text: response.error.description,
                                icon: response.error.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                        document.getElementById("submitFormLogin").disabled = false;
                    }
                },
                error: function () {
                    document.getElementById("submitFormLogin").disabled = false;
                }
            });
        }
    });

    $('#formLogin').validate({
        rules: {
            credencial: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 5
            },
            terms: {
                required: false
            },
        },
        messages: {
            credencial: {
                required: "O e-mail deve ser informado",
                email: "Por favor insira um endereço de e-mail válido"
            },
            password: {
                required: "O senha deve ser informado",
                minlength: "A senha deve conter no minimo 5 caracteres"
            },
            terms: "Please accept our terms"
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.input-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
}

function recuperarSenha() {
    $("#formEsqueciSenha").submit(function (e) {
        e.preventDefault();
    });


    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formEsqueciSenha').attr('action'),
                type: "POST",
                data: $('#formEsqueciSenha').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("btnRecuperaSenha").disabled = true;
                },
                success: function (response) {
                    console.log(response);
                    if (response.status == true) {
                        $.toast({
                            heading: response.menssagem.heading,
                            text: response.menssagem.description,
                            icon: response.menssagem.status,
                            loader: true,        // Change it to false to disable loader
                            position: 'top-right',
                            showHideTransition: 'plain', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 6000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                            textAlign: 'left',  // Text alignment i.e. left, right or center
                            loader: true,  // Whether to show loader or not. True by default
                            loaderBg: '#9EC600',  // Background color of the toast loader
                            beforeShow: function () { }, // will be triggered before the toast is shown
                            afterShown: function () {
                                setTimeout(function () {
                                    window.location.reload(1);
                                }, 5000);
                            }, // will be triggered after the toat has been shown
                            beforeHide: function () { }, // will be triggered before the toast gets hidden
                            afterHidden: function () { }  // will be triggered after the toast has been hidden
                        });

                    } else {
                        if (response.menssagem != null) {
                            $.toast({
                                heading: response.menssagem.heading,
                                text: response.menssagem.description,
                                icon: response.menssagem.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 9000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                        if (response.error != null) {
                            $.toast({
                                heading: response.error.heading,
                                text: response.error.description,
                                icon: response.error.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 9000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                    }
                },
                error: function () {
                    document.getElementById("btnRecuperaSenha").disabled = false;

                }
            });
        }
    });

    $('#formEsqueciSenha').validate({
        rules: {
            email: {
                required: true,
                email: true,
            }
        },
        messages: {
            email: {
                required: "O e-mail deve ser informado",
                email: "Por favor insira um endereço de e-mail válido"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.input-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
}

const passwordInput = document.getElementById("txtSenha");
const btnEyePassword = document.getElementById("btnEyePassword");

function mostrarPassword() {
    let inputTypeIsPassword = passwordInput.type == 'password';

    if (inputTypeIsPassword) {
        passwordInput.setAttribute('type', 'text');
        btnEyePassword.setAttribute('class', 'fa fa-eye');
    } else {
        passwordInput.setAttribute('type', 'password');
        btnEyePassword.setAttribute('class', 'fa fa-eye-slash');
    }
}