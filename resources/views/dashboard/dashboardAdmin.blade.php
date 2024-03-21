@extends('layouts.layout')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tableau de bord</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li> -->
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <!-- <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Ecole</h3>
                            <p>Nombre total:</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div> -->

                <div class="col-lg-6 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>Classe</h3>
                            <p><strong> total: {{$ClassroomCount}}</strong></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('classroom')}}" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-6 col-6">

                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>Eleve</h3>
                            <p><strong> total: {{$totalAvailableStudents}}</strong></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-12 col-12">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Professeurs</h3>
                            <p><strong> total: {{$ProfessorCount}}</strong></p>
                            <p><strong> total actif: {{$ProfessorActifCount}}</strong></p>
                            <p><strong> total inactif: {{$ProfessorInactifCount}}</strong></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('professor')}}" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection