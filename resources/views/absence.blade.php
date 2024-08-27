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
                <div class="card card-dark">
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
                        </div>
                        <div class="card-footer">
                            <button id="submit" type="button" class="btn btn-dark">Valider</button>
                        </div>
                    </form>
                </div>

                <div class="card mt-5">
                    <div class="card-header bg-primary">
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
        $('#loader2').hide();
        $('#update_loader').fadeOut();
        $('#add_loader').fadeOut();

        moment.locale('fr');
        $('.date').datetimepicker({
            format: 'DD/MM/YYYY',
            locale: 'fr'
        });

        var classId = $('#classId').val();
        var date1 = $('#date1').val();
        var date2 = $('#date2').val();

        var absence_list = $('#absence_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('showListClassroom')}}",
            ajax: {
                url: "{{ route('showListAbsence') }}",
                data: function(d) {
                    d.classId = classId,
                    d.date1 = date1,
                    d.date2 = date2
                }
            },
            columns: [
                {data: 'id',name: 'id'},
                {data: 'classrooms_id',name: 'classrooms_id'},
                {data: 'students_id',name: 'students_id'},
                {data: 'created_at',name: 'created_at'},
                // {data: 'action', name: 'action', orderable: false, searchable: false},
            ],

            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                $('#class_list').css('width','100%');
            },
        });

        $('#monthClient').click(function(e) {
                    if ($(this).children().attr('class') == "card-body info-box info-box-cursor selected") {
                        $('.selected').removeClass('selected');
                        $(this).children().attr('id', 'card_change_color');
                        month_client = 0;
                        all_client = 1;
                        year_client = 0;
                        permission_table.draw();
                    } else {
                        $('.selected').attr('id', 'card_change_color');
                        $('.selected').removeClass('selected');
                        $(this).children().addClass('selected');
                        $(this).children().removeAttr("id");
                        month_client = 1;
                        year_client = 0;
                        all_client = 0;
                        permission_table.draw();
                    }
                });

        //Search absent by class and different date
        $('#submit').click(function(e) {
            $('#add_loader').fadeIn();
            var classId = $('#classId').val();
            var date1 = $('#date1').val();
            var date2 = $('#date2').val();
            absence_list.draw();
            $('#add_loader').fadeOut();
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