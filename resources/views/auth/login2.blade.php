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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        .background-image {
            position: absolute; /* Position absolue pour que l'image se superpose à la div parente */
            top: 0; /* Positionnement en haut de la div parente */
            left: 0; /* Positionnement à gauche de la div parente */
            width: 100%; /* Largeur de la div parente */
            height: 100%; /* Hauteur de la div parente */
            background-image: url('https://th.bing.com/th/id/R.190707a8ce0086574452dca379ae4e5e?rik=18IS36Zr6DdiVw&pid=ImgRaw&r=0'); /* Chemin vers votre image */
            background-size: cover; /* Taille de l'image pour remplir la div parente */
            background-position: center; /* Positionnement de l'image au centre */
            opacity: 0.8; /* Opacité de l'image */
        }
    </style>
</head>
<body class="ackground-image">
    <div class="login-container d-flex">
        <!-- Section de l'image -->
        <div class="col-md-6 p-0 text-center">
            <!-- <img src="https://via.placeholder.com/450x500" alt="Login Image" class="img-fluid login-image"> -->
            <img class="img-fluid login-image" src="{{asset('img/trimax.gif')}}" alt="TRIMAX_Logo" height="450" width="500">
        </div>
        
        <!-- Section du formulaire -->
        <div class="col-md-6 d-flex align-items-center login-form">
            <form class="w-100" id="form-login">
                @csrf
                <h2 class="mb-4 text-center">Connexion</h2>
                <!-- Champ Email avec icône -->
                <label for="email" class="form-label">Email</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Entrez votre email">
                </div>

                <!-- Champ Mot de passe avec icône et option de visualisation -->
                <label for="password" class="form-label">Password</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Entrez votre mot de passe">
                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                    </span>
                </div>
                <!-- <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Se souvenir de moi</label>
                </div> -->
                <button type="submit" class="btn btn-primary w-100 mt-3">Se connecter</button>
                <!-- <p class="mt-3 text-center">
                    <a href="#">Mot de passe oublié?</a>
                </p> -->
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
                $('#loader').fadeIn();
                $.ajax({
                    type: 'POST',
                    url: 'login',
                    //enctype: 'multipart/form-data',
                    data: $('#form-login').serialize(),
                    datatype: 'json',
                    success: function (data){
                        console.log(data)
                        if (data.status)
                        {
                            Swal.fire({
                                icon: "success",
                                title: data.title,
                                text: "Connection reussie!",
                            }).then(() => {
                                if (data.redirect_to != null){
                                    window.location.assign(data.redirect_to)
                                } else{
                                }
                            })
                        }else{
                            $('#loader').hide();
                            Swal.fire({
                                title: data.title,
                                text:data.msg,
                                icon: 'error',
                                confirmButtonText: "D'accord",
                                confirmButtonColor: 'red',
                            })
                        }
                    },
                    error: function (data){
                        console.log(data)
                        $('#loader').hide();
                        Swal.fire({
                            icon: "error",
                            title: "erreur",
                            text: "Impossible de communiquer avec le serveur.",
                            timer: 3600,
                        })
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
