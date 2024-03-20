@extends('layouts.layout')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>ECOLE</h1>
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
                                <h4 class="modal-title">MODIFIER ECOLE</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="updateSchool">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="id" class="form-control" id="school_id">
                                    <div class="row">
                                        <div class="form-group col-4">
                                            <label for="name">Nom</label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                placeholder="Nom">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Email">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="numero">Numéro</label>
                                            <input type="number" name="num1" class="form-control" id="numero"
                                                placeholder="Numéro">
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

                @if(!Auth::user()->school_id)
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><small>Ajouter une école</small></h3>
                        </div>

                        <form id="add">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="exampleInputText0">Nom</label>
                                        <input type="text" name="name" class="form-control" id="exampleInputText0"
                                            placeholder="Nom">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="exampleInputText2">Email</label>
                                        <input type="email" name="email" class="form-control" id="exampleInputText2"
                                        placeholder="Email">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="exampleInputText3">Numéro</label>
                                        <input type="number" name="num1" class="form-control" id="exampleInputText3"
                                            placeholder="Numéro">
                                    </div>
                                </div>
                                <!-- loader -->
                                <div id="add_loader" class="text-center">
                                    <img class="animation__shake" src="{{asset('img/trimax.gif')}}" alt="TRIMAX_Logo"
                                        height="70" width="70">
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </div>
                        </form>
                    </div>
                @endif

                <div class="card mt-5">
                    <div class="card-header bg-primary">
                        <h2 class="card-title">GESTION DE L'ECOLE</h2>
                    </div>

                    <div class="card-body">
                        <table id="school_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Pays</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Numéro</th>
                                    <th>Creer par</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
    $('#loader').hide();
    $('#update_loader').fadeOut();
    $('#add_loader').fadeOut();
    $(function() {
        $('#loader').hide();
        $('#loader2').hide();
        
        $('body').on('click', '#disabled_button', function () {
            $('#text').html('Vous avez déjà une école a votre actif');
        })

        var userType = {{ $userType }};
        var school_list = $('#school_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('showListSchool')}}",
            columns: [
                {data: 'id',name: 'id'},
                {data: 'pays_id', name: 'pays_id'},
                {data: 'name',name: 'name'},
                {data: 'email',name: 'email'},
                {data: 'numero',name: 'numero'},
                {data: 'users_id',name: 'users_id'},
                {data: 'connected',name: 'connected'},
                // {data: 'created_at',name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                $('#school_list').css('width','100%');
            },
            
            rowCallback: function(row, data, iDisplayIndex) {
                var status ='';
                if (data.connected) {
                    status +=`<span class='badge bg-success'>Actif</span>`;
                    if(userType == 1){
                        status +=`<div data-id="${data.id}" class="custom-control checkbox custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="checkbox_'${data.id}'" checked>
                                <label class="custom-control-label" for="checkbox_'${data.id}'"></label>
                            </div>`;
                    }
                }else{
                    status +=`<span class='badge bg-danger'>Inactif</span>`;
                    if(userType==1){
                        status +=`<div data-id="${data.id}" class="custom-control checkbox custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="checkbox_'${data.id}'">
                                <label class="custom-control-label" for="checkbox_'${data.id}'"></label>
                            </div>`;
                    }
                }
                $('td:eq(6)', row).html(status);
            },
        });

        //Add user
        $('#add').submit(function() {
            event.preventDefault();
            $('#add_loader').fadeIn();
            $.ajax({
                type: 'POST',
                url: 'school/add',
                //enctype: 'multipart/form-data',
                data: $('#add').serialize(),
                datatype: 'json',
                success: function(data) {
                    $('#add_loader').hide();
                    console.log(data)
                    if (data.status) {
                        Swal.fire({
                            icon: "success",
                            title: data.title,
                            text: data.msg,
                        }).then(() => {
                            school_list.draw();
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

        $('body').on('click', '.editSchool', function () {
            $('#update_loader').fadeOut();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var id = $(this).data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                type: 'POST',
                url: 'school/getSchoolInfoById',
                data: { id: id},
                datatype: 'json',
                success: function (data){
                    console.log(data)
                    if (data.status)
                    {
                        $('#school_id').val(id);
                        $('#name').val(data.name);
                        $('#email').val(data.email);
                        $('#numero').val(data.numero);
                    }
                },
            });
        });

        $('#updateSchool').submit(function(){
            event.preventDefault();
            $('#update_loader').fadeIn();
            $.ajax({
                type: 'POST',
                url: 'school/update',
                //enctype: 'multipart/form-data',
                data: $('#updateSchool').serialize(),
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
                            school_list.draw();
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
                    url: 'school/connected',
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
                            school_list.draw();
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
                    url: 'school/connected',
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
                            school_list.draw();
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

        $('body').on('click', '.deleteUser', function () {
				var csrfToken = $('meta[name="csrf-token"]').attr('content');
				var id = $(this).data("id");
				
				Swal.fire({
					icon: "question",
					title: "Etes vous sur de vouloir supprimer cet utilisateur?",
					// text: " Les éléments liés a la ville seront supprimés ; la confirmation est irréversible",
					confirmButtonText: "Oui",
					confirmButtonColor: 'red',
					showCancelButton: true,
					cancelButtonText: "Non",
					cancelButtonColor: 'blue',
				}).then((result) => {
					if (result.isConfirmed){
						$.ajax({
							headers: {
								'X-CSRF-TOKEN': csrfToken
							},
							type: "post",
							url: "utilisateurs/delete_user",
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
					}
				})
			});
    });
</script>

</div>
@endsection