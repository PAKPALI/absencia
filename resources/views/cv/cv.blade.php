<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre CV</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        header {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        section {
            margin: 30px 0;
        }
        h2 {
            color: #343a40;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        .skill {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<header>
    <img src="votre-photo.jpg" alt="Votre Photo" class="profile-img">
    <h1>Votre Nom</h1>
    <p>Développeur Web Fullstack</p>
</header>

<section class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>À Propos de Moi</h2>
            <p>Je suis un développeur web passionné par la création d'applications innovantes. Fortes compétences en développement front-end et back-end, avec une expertise particulière dans les technologies telles que HTML, CSS, JavaScript, PHP et Laravel.</p>
        </div>
        <div class="col-md-6">
            <h2>Compétences</h2>
            <ul class="list-group">
                <li class="list-group-item skill">HTML5</li>
                <li class="list-group-item skill">CSS3</li>
                <li class="list-group-item skill">JavaScript</li>
                <li class="list-group-item skill">PHP</li>
                <li class="list-group-item skill">Laravel</li>
                <li class="list-group-item skill">React</li>
                <!-- Ajoutez d'autres compétences ici -->
            </ul>
        </div>
    </div>

    <!-- Section Travaux -->
    <div class="row">
        <div class="col-md-12">
            <h2>Mes Travaux</h2>
            <ul>
                <li><a href="lien-vers-travail-1" target="_blank">Travail 1</a></li>
                <li><a href="lien-vers-travail-2" target="_blank">Travail 2</a></li>
                <!-- Ajoutez d'autres travaux ici -->
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2>Expérience Professionnelle</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Développeur Web Fullstack - KPRMESOFT</h5>
                    <p class="card-text">Travaillez sur des projets de développement web complets, de la conception à la mise en œuvre.</p>
                </div>
            </div>
            <!-- Ajoutez d'autres expériences professionnelles ici -->
        </div>
    </div>

    <!-- Section Entreprises -->
    <div class="row">
        <div class="col-md-12">
            <h2>Entreprises</h2>
            <ul>
                <li>Entreprise A</li>
                <li>Entreprise B</li>
                <!-- Ajoutez d'autres entreprises ici -->
            </ul>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
