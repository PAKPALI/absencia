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

                @foreach($Classroom as $classroom)
                    <div class="col-lg-6 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>Classe : {{ $classroom->name }}</h3>
                                <p><strong>Nombre d'étudiants actifs : {{ $classroom->students_count }}</strong></p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{route('classroom')}}" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- second row -->
            <div class="row">
                <div class="col-lg-12 mt-4">
                    <div class="card card collapsed-card" >
                        <div class="card-header" style="background-color: #59789F; color:aliceblue">
                            <h2 class="card-title"><strong> Statistiques d'absences par classe</strong> </h2>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool text-light" data-card-widget="collapse">
                                    <!-- <i class="fas fa-minus"></i> -->
                                    VOIR <i class="fas fa-plus text-light"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times text-light"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 border-right">
                                    <div class="chart">
                                        <canvas id="barChart" style=" max-width: 100%;"></canvas>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="chart">
                                        <canvas id="pieChart" style=" max-width: 100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(function() {
            const ctx = document.getElementById('barChart').getContext('2d');
            const absenceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($classroomChart) !!}, // classroom name
                    datasets: [{
                        label: 'Nombre d\'absences',
                        data: {!! json_encode($absenceCounts) !!}, // Number of absences
                        backgroundColor: '#59789F',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true, // Assure que l'axe commence à zéro
                            suggestedMin: 0,   // Propose un minimum de 0 (pour éviter les valeurs plus hautes)
                            ticks: {
                                precision: 0,  // Assure que seules des valeurs entières sont affichées
                                stepSize: 1    // Définit l'incrément des valeurs à 1 pour que chaque absence soit visible
                            }
                        }
                    }
                }
            });

            const ctx1 = document.getElementById('pieChart').getContext('2d');
            const absenceChart1 = new Chart(ctx1, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($classroomChart) !!}, // classroom name
                    datasets: [{
                        label: 'Nombre d\'absences',
                        data: {!! json_encode($absenceCounts) !!}, // Number of absences
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
            });
        });
    </script>
@endsection