@extends('layouts.layout')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>CLASSE</h1>
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

            <div class="modal fade" id="modal-view">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h4 class="modal-title">DETAIL CLASSE</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div id="view_response">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal-update">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header bg-warning">
                                <h4 class="modal-title">MODIFIER CLASSE</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div id="edit_response">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><small>Ajouter les classes</small></h3>
                    </div>

                    <form id="add">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="exampleInputText0">Nom</label>
                                    <input type="text" name="name" class="form-control" id="exampleInputText0"
                                        placeholder="Nom">
                                </div>
                                <div class="form-group col-6">
                                    <label>Responsable</label>
                                    <select name="manager" class="form-control">
                                        <option value="">Sélectionnez le responsable</option>
                                        @foreach ($Professor as $p)
                                            <option value="{{$p->id}}">{{strtoupper($p->last_name)}} {{strtoupper($p->first_name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <label>Professeurs</label>
                                    <select name="professor[]" class="duallistbox" multiple="multiple">
                                        @foreach ($Professor as $p)
                                            <option value="{{$p->id}}">{{strtoupper($p->last_name)}} {{strtoupper($p->first_name)}}</option>
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
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </div>
                    </form>
                </div>

                <div class="card mt-5">
                    <div class="card-header bg-primary">
                        <h2 class="card-title">LISTE DES CLASSES</h2>
                    </div>

                    <div class="card-body">
                        <table id="class_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nom</th>
                                    <th>Responsable</th>
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
    $(function() {
        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()
        $('#loader').hide();
        $('#loader2').hide();
        $('#update_loader').fadeOut();
        $('#add_loader').fadeOut();

        var class_list = $('#class_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('showListClassroom')}}",
            columns: [
                {data: 'id',name: 'id'},
                {data: 'name',name: 'name'},
                {data: 'manager',name: 'manager'},
                // {data: 'created_at',name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],

            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                $('#class_list').css('width','100%');
            },
        });

        //Add user
        $('#add').submit(function() {
            event.preventDefault();
            $('#add_loader').fadeIn();
            $.ajax({
                type: 'POST',
                url: 'classroom/add',
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
                            class_list.draw();
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

        $('body').on('click', '.editUser', function (e) {
            $('#update_loader').fadeOut();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var id = $(this).data('id');
            $('#edit_response').empty();
            $.ajax({
                url:'classroom/edit/'+id,
                dataType: 'html',
                success:function(result)
                {
                    $('#edit_response').html(result);
                }
            });
            $('#modal-update').modal('show');
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

        $(document).on('click','.editUser',function(e){
        var modalHeader = $("#modal-header-edit");
        modalHeader.attr("class", "modal-header bg-success text-light");

        e.preventDefault();
        
    });

        $('#updateUser').submit(function(){
            event.preventDefault();
            $('#update_loader').fadeIn();
            $.ajax({
                type: 'POST',
                url: 'professor/update',
                //enctype: 'multipart/form-data',
                data: $('#updateUser').serialize(),
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