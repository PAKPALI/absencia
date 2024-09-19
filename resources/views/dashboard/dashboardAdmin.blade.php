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

            <div class="col-lg-4 col-4">
                <div class="small-box bg-primary">
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

            <div class="col-lg-4 col-4">
                <div class="small-box bg-warning">
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

            <div class="col-lg-4 col-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Absences</h3>
                        <p><strong> total: {{$Absences->count()}}</strong></p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{route('absence')}}" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-12 col-12">
                <div class="small-box bg-info">
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

        <!-- third row -->
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="card mt-4">
                    <div id="searchCard" class="card-header bg-dark">
                        <h2 class="card-title">LISTE DES ABSENCES AUJOURD'HUI ({{$AbsencesToday->count()}})</h2>
                    </div>
                    <div class="card-body">
                        <table id="absence_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Classe</th>
                                    <th>Elève</th>
                                    <th>Matière</th>
                                    <th>Date d'absence</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</section>
<script>
    $(function() {
        // Chart Bar
        const ctx = document.getElementById('barChart').getContext('2d');
        const absenceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($classroom) !!}, // classroom names
                datasets: [{
                    label: 'Nombre d\'absences',
                    data: {!! json_encode($absenceCounts) !!}, // Number of absences
                    backgroundColor: {!! json_encode($colors) !!},  // Unique colors for each bar
                    borderColor: {!! json_encode($colors) !!},  // Matching border colors
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMin: 0,
                        ticks: {
                            precision: 0,
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Chart Pie
        const ctx1 = document.getElementById('pieChart').getContext('2d');
        const absenceChart1 = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: {!! json_encode($classroom) !!}, // classroom names
                datasets: [{
                    label: 'Nombre d\'absences',
                    data: {!! json_encode($absenceCounts) !!}, // Number of absences
                    backgroundColor: {!! json_encode($colors) !!},  // Use the same colors for pie chart
                    borderColor: '#ffffff',  // Optional: Set white border for better visibility
                    borderWidth: 2
                }]
            }
        });

        var absence_list = $('#absence_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('showListAbsenceToday') }}",
                data: function(d) {
                    d.classId = $('#classId').val();
                    d.date1 = $('#date1').val();
                    d.date2 = $('#date2').val();
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'classrooms_id',
                    name: 'classrooms_id'
                },
                {
                    data: 'students_id',
                    name: 'students_id'
                },
                {
                    data: 'professor_id',
                    name: 'professor_id'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
            ],
            dom: 'Bfrtip', // Place les boutons en haut du tableau
            buttons: [{
                    extend: 'copy',
                    text: 'Copier',
                    title: 'Liste des Absences',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    title: 'Liste des Absences',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    title: 'Liste des Absences',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimer',
                    title: 'Liste des Absences',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    text: 'Afficher/Masquer Colonnes',
                    action: function(e, dt, node, config) {
                        var columnDropdown = $('<div class="dropdown-menu"></div>');

                        dt.columns().every(function() {
                            var column = this;
                            var columnIndex = column.index();

                            var columnItem = $('<a class="dropdown-item"></a>')
                                .text(column.header().innerText)
                                .on('click', function(e) {
                                    e.preventDefault();
                                    column.visible(!column.visible());
                                });

                            // Ajouter une classe active si la colonne est visible
                            if (column.visible()) {
                                columnItem.addClass('active');
                            }

                            columnDropdown.append(columnItem);
                        });

                        // Affiche le dropdown à l'endroit du clic
                        columnDropdown.css({
                            position: 'absolute',
                            top: e.pageY,
                            left: e.pageX,
                            display: 'block',
                            'z-index': 1000
                        }).appendTo('body').on('mouseleave', function() {
                            $(this).remove(); // Retire le dropdown après utilisation
                        });
                    }
                }
            ],
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                $('#class_list').css('width', '100%');
            }
        });

        // Bouton pour basculer la visibilité de la colonne classrooms_id (index 1)
        $('#toggleClassroom').on('click', function() {
            var column = absence_list.column(1); // Index de la colonne
            column.visible(!column.visible()); // Bascule la visibilité
        });

        // Bouton pour basculer la visibilité de la colonne students_id (index 2)
        $('#toggleStudent').on('click', function() {
            var column = absence_list.column(2); // Index de la colonne
            column.visible(!column.visible()); // Bascule la visibilité
        });

    });
</script>
@endsection