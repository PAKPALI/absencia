@extends('layouts.layout')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>ABSENCE</h1>
            </div>
            <div class="col-sm-6">
                <!-- <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">depot</li>
                </ol> -->
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div id="card" class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title"><small>Historique des absences</small></h3>
                    </div>
                    <form id="searchForm">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Classe</label>
                                    <select id="classId" name="manager" class="form-control">
                                        <option value="">Sélectionnez la classe</option>
                                        @foreach ($Classroom as $class)
                                        <option value="{{$class->id}}">{{$class->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Date de début:</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input id="date1" type="text" class="form-control datetimepicker-input" data-target="#reservationdate" />
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Date de fin:</label>
                                    <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                                        <input id="date2" type="text" class="form-control datetimepicker-input" data-target="#reservationdate1"/>
                                        <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- loader -->
                            <div id="add_loader" class="text-center">
                                <img class="animation__shake" src="{{asset('img/trimax.gif')}}" alt="TRIMAX_Logo"
                                    height="70" width="70">
                            </div>
                            <div style="font-size: 20px;" class="text-danger text-center" id="error_message"></div>
                        </div>
                        <div class="card-footer">
                            <button id="submit" type="button" class="btn btn-dark">Valider</button>
                        </div>
                    </form>
                </div>

                <div class="card mt-5">
                    <div id="searchCard" class="card-header bg-primary">
                        <h2 class="card-title">LISTE DES ABSENCES RECHERCHEES</h2>
                    </div>
                    <div class="card-body">
                        <table id="absence_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Classe</th>
                                    <th>Elève</th>
                                    <th>Date d'absence</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody> 
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </div>
</section>

<script>
    $(function() {
        $('#loader').hide();
        $('#error_message').hide();
        $('#update_loader').fadeOut();
        $('#add_loader').fadeOut();

        moment.locale('fr');
        $('.date').datetimepicker({
            format: 'DD/MM/YYYY',
            locale: 'fr'
        });

        var absence_list = $('#absence_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('showListAbsence') }}",
                data: function(d) {
                    d.classId = $('#classId').val();
                    d.date1 = $('#date1').val();
                    d.date2 = $('#date2').val();
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'classrooms_id', name: 'classrooms_id'},
                {data: 'students_id', name: 'students_id'},
                {data: 'created_at', name: 'created_at'},
            ],
            dom: 'Bfrtip', // Place les boutons en haut du tableau
            buttons: [
                {
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
                // {
                //     text: 'Afficher/Masquer Colonnes',
                //     action: function(e, dt, node, config) {
                //         var columnDropdown = $('<div class="dropdown-menu"></div>');
                        
                //         dt.columns().every(function() {
                //             var column = this;
                //             var columnIndex = column.index();

                //             var columnItem = $('<a class="dropdown-item"></a>')
                //                 .text(column.header().innerText)
                //                 .on('click', function(e) {
                //                     e.preventDefault();
                //                     column.visible(!column.visible());
                //                 });

                //             // Ajouter une classe active si la colonne est visible
                //             if (column.visible()) {
                //                 columnItem.addClass('active');
                //             }

                //             columnDropdown.append(columnItem);
                //         });

                //         // Affiche le dropdown à l'endroit du clic
                //         columnDropdown.css({
                //             position: 'absolute',
                //             top: e.pageY,
                //             left: e.pageX,
                //             display: 'block',
                //             'z-index': 1000
                //         }).appendTo('body').on('mouseleave', function() {
                //             $(this).remove(); // Retire le dropdown après utilisation
                //         });
                //     }
                // }
            ],
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                $('#class_list').css('width','100%');
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

        function deleteClass(){
            // delete different class
            $('#card').removeClass('card-dark');
            $('#submit').removeClass('btn-dark');
            $('#searchCard').removeClass('bg-primary');
            $('#card').removeClass('card-danger');
            $('#submit').removeClass('btn-danger');
            $('#searchCard').removeClass('bg-danger');
            $('#card').removeClass('card-success');
            $('#submit').removeClass('btn-success');
            $('#searchCard').removeClass('bg-success');
        }

        function addClassError(){
            // add different class
            $('#card').addClass('card-danger');
            $('#submit').addClass('btn-danger');
            $('#searchCard').addClass('bg-danger');
        }

        function addClassSuccess(){
            // add different class
            $('#card').addClass('card-success');
            $('#submit').addClass('btn-success');
            $('#searchCard').addClass('bg-success');
        }

        function visualError(){
            deleteClass()
            addClassError()
        }

        function visualSuccess(){
            deleteClass()
            addClassSuccess()
        }

        //Search absent by class and different date
        $('#submit').click(function(e) {
            $('#add_loader').fadeIn();
            var classId = $('#classId').val();
            var date1 = $('#date1').val();
            var date2 = $('#date2').val();
            if(classId){
                if(date1>date2){
                    visualError()
                    // // show  error message 
                    $('#add_loader').fadeOut();
                    $('#error_message').text('La date de début doit etre inférieure a la date de fin');
                    $('#error_message').show();
                    $('#error_message').fadeOut(10000);
                }
                visualSuccess()
                absence_list.draw();
                $('#add_loader').fadeOut();
            }else{
                visualError()
                $('#add_loader').fadeOut();
                $('#error_message').text('Veuillez choisir une classe');
                $('#error_message').show();
                $('#error_message').fadeOut(10000);
            }
        });

        $('body').on('click', '.viewUser', function (e) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var id = $(this).data('id');
            $('#view_response').empty();
            $.ajax({
                url:'classroom/view/'+id,
                dataType: 'html',
                success:function(result)
                {
                    $('#view_response').html(result);
                }
            });
            $('#modal-view').modal('show');
        });
    });
</script>

</div>
@endsection