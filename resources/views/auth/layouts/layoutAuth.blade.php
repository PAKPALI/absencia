<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ABSENCIA | Log in</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('admin/man/css/adminlte.min.css')}}">

         <!--link j-query-->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </head>

    <style>
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

    <body class="hold-transition login-page background-image">

        @yield('content')

        <!-- jQuery -->
        <script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('admin/man/js/adminlte.min.js')}}"></script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    </body>
</html>