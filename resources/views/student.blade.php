@extends('layouts.layout')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$Classroom->name}}</h1>
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
                <div class="modal fade" id="modal-update">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header bg-warning">
                                <h4 class="modal-title">MODIFIER ETUDIANT</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="updateStudent">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="id" class="form-control" id="studentId">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="last_name">Nom</label>
                                            <input type="text" name="last_name" class="form-control" id="last_name"
                                                placeholder="Nom">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="first_name">Prénom</label>
                                            <input type="text" name="first_name" class="form-control" id="first_name"
                                                placeholder="Prénom">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="email">Email 1</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                placeholder="Email">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="email2">Email 2</label>
                                            <input type="email" name="email2" class="form-control" id="email2"
                                                placeholder="Email">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="num1">Numéro 1</label>
                                            <input type="number" name="num1" class="form-control" id="num1"
                                                placeholder="Numero 1">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="num2">Numéro 2</label>
                                            <input type="number" name="num2" class="form-control" id="num2"
                                                placeholder="Numero 2">
                                        </div>
                                        <div class="form-group col-6">
                                            <label >Genre</label>
                                            <select id="gender" name="gender" class="form-control">
                                                <option value="">Sélectionnez le genre</option>
                                                <option value="M">Masculin</option>
                                                <option value="F">Feminin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- loader -->
                                <div id="update_loader" class="text-center">
                                    <img class="animation__shake" src="{{asset('img/trimax.gif')}}" alt="TRIMAX_Logo"
                                        height="70" width="70">
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-warning">Modifier</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @if($Manager==1)
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><small>Ajouter les étudiants</small></h3>
                    </div>

                    <form id="add">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="classroom_id" value="{{$Classroom->id}}" class="form-control" id="classroom_id">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="last_name">Nom</label>
                                    <input type="text" name="last_name" class="form-control" id="last_name"
                                        placeholder="Nom">
                                </div>
                                <div class="form-group col-6">
                                    <label for="first_name">Prénom</label>
                                    <input type="text" name="first_name" class="form-control" id="first_name"
                                        placeholder="Prénom">
                                </div>
                                <div class="form-group col-6">
                                    <label for="email">Email 1</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        placeholder="Email 1">
                                </div>
                                <div class="form-group col-6">
                                    <label for="email2">Email 2</label>
                                    <input type="email" name="email2" class="form-control" id="email2"
                                        placeholder="Email 2">
                                </div>
                                <div class="form-group col-6">
                                    <label for="num1">Numero 1</label>
                                    <input type="number" name="num1" class="form-control" id="num1"
                                        placeholder="Numero 1">
                                </div>
                                <div class="form-group col-6">
                                    <label for="num2">Numero 2</label>
                                    <input type="number" name="num2" class="form-control" id="num2"
                                        placeholder="Numero 2">
                                </div>
                                <div class="form-group col-12">
                                    <label >Genre</label>
                                    <select id="gender" name="gender" class="form-control">
                                        <option value="">Sélectionnez le genre</option>
                                        <option value="M">Masculin</option>
                                        <option value="F">Feminin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </div>
                    </form>
                </div>
                @endif

                <div id="card-mail" class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">ENVOIE DE MAIL EN COURS...</h3>
                    </div>
                </div>

                <div class="card mt-5">
                    <div class="card-header bg-dark">
                        <h2 class="card-title">LISTE DES ETUDIANTS ACTIFS</h2>
                    </div>

                    <div class="card-body">
                        <table id="user_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Absence</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($Manager==1)
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><small>Déplacer les étudiants</small></h3>
                    </div>

                    <form id="moove">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Classe</label>
                                    <select name="classroom" class="form-control">
                                        <option value="">Sélectionnez la classe</option>
                                        @foreach ($AllClassroom as $classroom)
                                            <option value="{{$classroom->id}}">{{strtoupper($classroom->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <label>Etudiants</label>
                                    <select name="student[]" class="duallistbox" multiple="multiple">
                                        @foreach ($Student as $student)
                                            <option value="{{$student->id}}">{{strtoupper($student->fullName())}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <!-- loader -->
                            <div id="add_loader" class="text-center">
                                <img class="animation__shake" src="{{asset('img/trimax.gif')}}" alt="TRIMAX_Logo"
                                    height="70" width="70">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Déplacer</button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
</section>

<script>
    $('#loader').hide();
    $('#update_loader').fadeOut();
    $('#add_loader').fadeOut();
    $('#card-mail').hide();
    $(function() {
        $('#loader').hide();
        $('#loader2').hide();
        $('.duallistbox').bootstrapDualListbox()

        $('body').on('click', '#disabled_button', function () {
            $('#text').html('Veuillez enregistrer une école');
        })
        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch();
        })
        var classroomId = $('#classroom_id').val();
        var ajaxUrl = "{{ route('showListStudent', ['classroom_id' => ':classroom_id']) }}";
        ajaxUrl = ajaxUrl.replace(':classroom_id', classroomId);

        var user_list = $('#user_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: ajaxUrl,
            columns: [
                {data: 'id',name: 'id'},
                {data: 'last_name',name: 'last_name'},
                {data: 'first_name',name: 'first_name'},
                // {data: 'email',name: 'email'},
                {data: 'absence',name: 'absence'},
                // {data: 'school_id',name: 'school_id'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],

            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                $('#user_list').css('width','100%');
            },
            rowCallback: function(row, data, iDisplayIndex) {
            },
        });

        //Add user
        $('#add').submit(function() {
            event.preventDefault();
            $('#add_loader').fadeIn();
            $.ajax({
                type: 'POST',
                url: "{{route('addStudent')}}",
                //enctype: 'multipart/form-data',
                data: $('#add').serialize(),
                datatype: 'json',
                success: function(data){
                    $('#add_loader').hide();
                    console.log(data)
                    if (data.status) {
                        Swal.fire({
                            icon: "success",
                            title: data.title,
                            text: data.msg,
                        }).then(() => {
                            user_list.draw();
                        })
                    } else {
                        $('#add_loader').fadeOut();
                        Swal.fire({
                            title: data.title,
                            text: data.msg,
                            icon: 'error',
                            confirmButtonText: "D'accord",
                            confirmButtonColor: '#A40000',
                        })
                    }
                },
                error: function(data) {
                    console.log(data)
                    $('#add_loader').fadeOut();
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

        $('body').on('click', '.editStudent', function () {
            $('#update_loader').fadeOut();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var id = $(this).data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                type: 'POST',
                url: "{{route('getStudentInfoById')}}",
                data: { id: id},
                datatype: 'json',
                success: function (data){
                    console.log(data)
                    if (data.status)
                    {
                        // $('#townName').val(data.townName);
                        $('#studentId').val(id);
                        $('#last_name').val(data.last_name);
                        $('#first_name').val(data.first_name);
                        $('#email').val(data.email1);
                        $('#email2').val(data.email2);
                        $('#num1').val(data.num1);
                        $('#num2').val(data.num2);
                        $('#gender').val(data.gender);
                    }
                },
            });
        });

        $('body').on('change', '.custom-control-input', function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var Id = $(this).closest('.custom-control').data('id');
            var isChecked = $(this).prop('checked');
            // alert(isChecked)
            if(isChecked){
                var dataToSend = {
                    connected: 1,
                    id: Id
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Récupère automatiquement le token CSRF depuis la balise meta
                    },
                    type: 'POST',
                    url: 'professor/connected',
                    //enctype: 'multipart/form-data',
                    data: dataToSend,
                    datatype: 'json',
                    success: function(data) {
                        //var object = JSON.parse(data);
                        console.log(data)
                        if (data.status) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                icon: "success",
                                title: data.title,
                                text: data.msg,
                                timer: 3000
                            })
                            user_list.draw();
                        } else {
                            Swal.fire({
                                title: data.title,
                                text: data.msg,
                                icon: 'error',
                                confirmButtonText: "D'accord",
                                confirmButtonColor: '#A40000',
                            })
                        }
                    },
                    error: function(data) {
                        console.log(data)
                        Swal.fire({
                            icon: "error",
                            title: "erreur",
                            text: "Impossible de communiquer avec le serveur.",
                            timer: 3600,
                        })
                    }
                });
                return false;
            }else{
                var dataToSend = {
                    connected: 0,
                    id: Id
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Récupère automatiquement le token CSRF depuis la balise meta
                    },
                    type: 'POST',
                    url: 'professor/connected',
                    //enctype: 'multipart/form-data',
                    data: dataToSend,
                    datatype: 'json',
                    success: function(data) {
                        //var object = JSON.parse(data);
                        console.log(data)
                        if (data.status) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                icon: "success",
                                title: data.title,
                                text: data.msg,
                                timer: 3000
                            })
                            user_list.draw();
                        } else {
                            Swal.fire({
                                title: data.title,
                                text: data.msg,
                                icon: 'error',
                                confirmButtonText: "D'accord",
                                confirmButtonColor: '#A40000',
                            })
                        }
                    },
                    error: function(data) {
                        console.log(data)
                        Swal.fire({
                            icon: "error",
                            title: "erreur",
                            text: "Impossible de communiquer avec le serveur.",
                            timer: 3600,
                        })
                    }
                });
                return false;
            }
        });

        $('#updateStudent').submit(function(){
            event.preventDefault();
            $('#update_loader').fadeIn();
            $.ajax({
                type: 'POST',
                url: "{{route('updateStudent')}}",
                //enctype: 'multipart/form-data',
                data: $('#updateStudent').serialize(),
                datatype: 'json',
                success: function (data){
                    console.log(data)
                    if (data.status)
                    {
                        Swal.fire({
                            icon: "success",
                            title: data.title,
                            text: data.msg,
                        }).then(() => {
                            $('#modal-update').modal('hide');
                            user_list.draw();
                        })
                    }else{
                        $('#update_loader').fadeOut();
                        Swal.fire({
                            title: data.title,
                            text:data.msg,
                            icon: 'error',
                            confirmButtonText: "Ok",
                            confirmButtonColor: 'blue',
                        })
                    }
                },
                error: function (data){
                    console.log(data)
                    $('#update_loader').fadeOut();
                    Swal.fire({
                        icon: "error",
                        title: "error",
                        text: "server error",
                        timer: 3000,
                    })
                }
            });
            return false;
        });

        $('body').on('click', '.absent', function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var id = $(this).data("id");
            var name = $(this).data("name");
            
            Swal.fire({
                icon: "question",
                title: "L'élève "+name+" Est il absent?",
                // text: " Les éléments liés a la ville seront supprimés ; la confirmation est irréversible",
                confirmButtonText: "Oui",
                confirmButtonColor: 'black',
                showCancelButton: true,
                cancelButtonText: "Non",
                cancelButtonColor: 'blue',
            }).then((result) => {
                if (result.isConfirmed){
                    $('#card-mail').fadeIn();
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': csrfToken},
                        type: "post",
                        url: "{{route('Absent')}}",
                        data: {id: id},
                        datatype: 'json',
                        success: function (data) {
                            if(data.status){
                                Swal.fire({
                                    icon: "success",
                                    title: data.title,
                                    text: data.msg,
                                }).then(() => {
                                    user_list.draw();
                                })
                            }else{
                                Swal.fire({
                                    icon: "error",
                                    title: data.title,
                                    text: data.msg,
                                })
                            }
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                    $('#card-mail').fadeOut(5000);
                }
            })
        });

        $('#moove').submit(function() {
            event.preventDefault();
            $('#add_loader').fadeIn();
            $.ajax({
                type: 'POST',
                url: "{{route('moove')}}",
                //enctype: 'multipart/form-data',
                data: $('#moove').serialize(),
                datatype: 'json',
                success: function(data){
                    $('#add_loader').hide();
                    console.log(data)
                    if (data.status) {
                        Swal.fire({
                            icon: "success",
                            title: data.title,
                            text: data.msg,
                        }).then(() => {
                            user_list.draw();
                        })
                    } else {
                        $('#add_loader').fadeOut();
                        Swal.fire({
                            title: data.title,
                            text: data.msg,
                            icon: 'error',
                            confirmButtonText: "D'accord",
                            confirmButtonColor: '#A40000',
                        })
                    }
                },
                error: function(data) {
                    console.log(data)
                    $('#add_loader').fadeOut();
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
        
        $('#archive').submit(function() {
            event.preventDefault();
            $('#add_loader').fadeIn();
            $.ajax({
                type: 'POST',
                url: "{{route('archive')}}",
                //enctype: 'multipart/form-data',
                data: $('#archive').serialize(),
                datatype: 'json',
                success: function(data){
                    $('#add_loader').hide();
                    console.log(data)
                    if (data.status) {
                        Swal.fire({
                            icon: "success",
                            title: data.title,
                            text: data.msg,
                        }).then(() => {
                            user_list.draw();
                        })
                    } else {
                        $('#add_loader').fadeOut();
                        Swal.fire({
                            title: data.title,
                            text: data.msg,
                            icon: 'error',
                            confirmButtonText: "D'accord",
                            confirmButtonColor: '#A40000',
                        })
                    }
                },
                error: function(data) {
                    console.log(data)
                    $('#add_loader').fadeOut();
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
    });
</script>

</div>
@endsection