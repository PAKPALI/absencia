<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 900px;
            background-color: white;
            box-shadow: 5px 5px 5px 5px rgba(0, 0, 255, 0.1);
            border-radius: 10px;
        }
        .login-image {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
        .login-form {
            padding: 40px;
        }
        .form-control:focus {
            box-shadow: none;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-right: 0;
        }
        .form-control {
            border-left: 0;
        }
        @keyframes colorChange {
            0% {
                color: #ADD8E6; /* Bleu clair */
            }
            40% {
                color: #0000FF; /* Bleu standard */
            }
            80% {
                color: #00008B; /* Bleu foncé */
            }
            100% {
                color: #ADD8E6; /* Bleu clair */
            }
        }

        @keyframes backgroundColorChange {
            0% {
                background-color: #ADD8E6; /* Bleu clair */
            }
            40% {
                background-color: #0000FF; /* Bleu simple */
            }
            80% {
                background-color: #00008B; /* Bleu foncé */
            }
            100% {
                background-color: #ADD8E6; /* Bleu clair */
            }
        }
        .text-animated {
            animation: colorChange 10s infinite;
        }
        .bg-animated {
            animation: backgroundColorChange 10s infinite;
        }
    </style>
</head>
<body class="ackground-image">
    <div class="login-container d-flex">
        <!-- Section de l'image (cachée sur les petits écrans) -->
        <div class="col-md-6 p-0 text-center d-none d-md-block">
            <img class="img-fluid login-image" src="{{asset('img/trimax.gif')}}" alt="TRIMAX_Logo" height="450" width="500">
        </div>
        
        <!-- Section du formulaire -->
        <div class="col-md-6 d-flex align-items-center login-form text-center">
            <form class="w-100" id="form-login">
                @csrf
                <h1 class="mb-3 text-center text-animated">ABSENCIA</h1>
                <h5 class="mb-4 text-center">Connexion</h5>
                <!-- Champ Email avec icône -->
                <label for="email" class="form-label">Email</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Entrez votre email">
                </div>

                <!-- Champ Mot de passe avec icône et option de visualisation -->
                <label for="password" class="form-label">Mot de passe</label>
                <div class="input-group mb-1">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Entrez votre mot de passe">
                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                    </span>
                </div>
                <!-- loader -->
                <div id="loader" class="spinner-border text-primary text-center mt-5 mb-2" role="status">
                    <span class="sr-only">ABSENCIA</span>
                </div>
                <button id="submit" type="submit" class="btn bg-animated w-100 mt-3 text-light">Se connecter</button>
            </form>
        </div>
    </div>

    <!-- Lien vers Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function() {
            $('#loader').hide();
            //ajax pour se connecter
            $('#form-login').submit(function(){
                event.preventDefault();
                $('#submit').hide();
                $('#loader').fadeIn();
                $.ajax({
                    type: 'POST',
                    url: 'login',
                    data: $('#form-login').serialize(),
                    datatype: 'json',
                    success: function (data){
                        console.log(data)
                        if (data.status) {
                            Swal.fire({
                                icon: "success",
                                title: data.title,
                                text: "Connexion réussie!",
                            }).then(() => {
                                if (data.redirect_to != null){
                                    window.location.assign(data.redirect_to);
                                }
                            });
                        } else {
                            $('#loader').hide();
                            $('#submit').show();
                            Swal.fire({
                                title: data.title,
                                text:data.msg,
                                icon: 'error',
                                confirmButtonText: "D'accord",
                                confirmButtonColor: 'red',
                            });
                        }
                    },
                    error: function (data){
                        $('#loader').hide();
                        $('#submit').show();
                        Swal.fire({
                            icon: "error",
                            title: "Erreur",
                            text: "Impossible de communiquer avec le serveur.",
                            timer: 3600,
                        });
                    }
                });
                return false;
            });

            $('#togglePassword').on('click', function() {
                const passwordField = document.getElementById("password");
                const toggleIcon = document.getElementById("togglePasswordIcon");

                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    toggleIcon.classList.remove("bi-eye");
                    toggleIcon.classList.add("bi-eye-slash");
                } else {
                    passwordField.type = "password";
                    toggleIcon.classList.remove("bi-eye-slash");
                    toggleIcon.classList.add("bi-eye");
                }
            });
        });
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>
</html>
