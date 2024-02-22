@extends('layouts.layout')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>ADMINISTRATEURS</h1>
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
                                <h4 class="modal-title">MODIFIER UTILISATEUR</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="updateUser">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="id" class="form-control" id="userId">
                                    <div class="row">
                                        <div class="form-group col-4">
                                            <label for="last_name">Nom</label>
                                            <input type="text" name="last_name" class="form-control" id="last_name"
                                                placeholder="Nom">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="first_name">Prénom</label>
                                            <input type="text" name="first_name" class="form-control" id="first_name"
                                                placeholder="Prénom">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Email">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="num1">Numéro 1</label>
                                            <input type="number" name="num1" class="form-control" id="num1"
                                                placeholder="Numéro 1">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="num2">Numéro 2</label>
                                            <input type="number" name="num2" class="form-control" id="num2"
                                                placeholder="Numéro 2">
                                        </div>
                                        <div class="form-group col-4">
                                            <label >Genre</label>
                                            <select id="gender" name="gender" class="form-control">
                                                <option value="">Sélectionnez le genre</option>
                                                <option value="M">Masculin</option>
                                                <option value="F">Feminin</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Pays</label>
                                            <select id="pays_id" name="pays_id" class="form-control">
                                                <option value="">Sélectionnez le pays</option>
                                                @foreach ($Country as $country)
                                                    <option value="{{$country->id}}">{{strtoupper($country->nom)}}</option>
                                                @endforeach
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

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><small></small></h3>
                    </div>

                    <form id="add">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="exampleInputText0">Nom</label>
                                    <input type="text" name="last_name" class="form-control" id="exampleInputText0"
                                        placeholder="Nom">
                                </div>
                                <div class="form-group col-4">
                                    <label for="exampleInputText1">Prénom</label>
                                    <input type="text" name="first_name" class="form-control" id="exampleInputText1"
                                        placeholder="Prénom">
                                </div>
                                <div class="form-group col-4">
                                    <label for="exampleInputText2">Email</label>
                                    <input type="email" name="email" class="form-control" id="exampleInputText2"
                                    placeholder="Email">
                                </div>
                                <div class="form-group col-4">
                                    <label for="exampleInputText3">Numéro 1</label>
                                    <input type="number" name="num1" class="form-control" id="exampleInputText3"
                                        placeholder="Numéro 1">
                                </div>
                                <div class="form-group col-4">
                                    <label for="exampleInputText4">Numéro 2</label>
                                    <input type="number" name="num2" class="form-control" id="exampleInputText4"
                                        placeholder="Numéro 2">
                                </div>
                                <div class="form-group col-4">
                                    <label >Genre</label>
                                    <select name="gender" class="form-control">
                                        <option value="">Sélectionnez le genre</option>
                                        <option value="M">Masculin</option>
                                        <option value="F">Feminin</option>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label>Pays</label>
                                    <select name="pays_id" class="form-control">
                                        <option value="">Sélectionnez le pays</option>
                                        @foreach ($Country as $country)
                                            <option value="{{$country->id}}">{{strtoupper($country->nom)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="exampleInputText5">Mot de passe</label>
                                    <input type="password" name="password" class="form-control" id="exampleInputText5"
                                        placeholder="mot de passe">
                                </div>
                                <div class="form-group col-4">
                                    <label for="exampleInputText6">Confirmer mot de passe</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="exampleInputText6"
                                        placeholder="Confirmez mot de passe">
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
                        <h2 class="card-title">LISTE DES UTILISATEURS</h2>
                    </div>

                    <div class="card-body">
                        <table id="user_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Pays</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Num1</th>
                                    <th>Num2</th>
                                    <th>Genre</th>
                                    <th>Ecole</th>
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
        var user_list = $('#user_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('showListUser')}}",
            columns: [
                {data: 'id',name: 'id'},
                {data: 'pays_id', name: 'pays_id'},
                {data: 'last_name',name: 'last_name'},
                {data: 'first_name',name: 'first_name'},
                {data: 'email',name: 'email'},
                {data: 'num1',name: 'num1'},
                {data: 'num2',name: 'num2'},
                {data: 'gender',name: 'gender'},
                {data: 'school_id',name: 'school_id'},
                // {data: 'created_at',name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });

        //Add user
        $('#add').submit(function() {
            event.preventDefault();
            $('#add_loader').fadeIn();
            $.ajax({
                type: 'POST',
                url: 'utilisateurs/add_user',
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

        $('body').on('click', '.editUser', function () {
            $('#update_loader').fadeOut();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var id = $(this).data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                type: 'POST',
                url: 'utilisateurs/getUserInfoById',
                data: { id: id},
                datatype: 'json',
                success: function (data){
                    console.log(data)
                    if (data.status)
                    {
                        // $('#townName').val(data.townName);
                        $('#userId').val(id);
                        $('#last_name').val(data.last_name);
                        $('#first_name').val(data.first_name);
                        $('#email').val(data.email);
                        $('#num1').val(data.num1);
                        $('#num2').val(data.num2);
                        $('#gender').val(data.gender);
                        $('#pays_id').val(data.pays_id);
                    }
                },
            });
        });

        $('#updateUser').submit(function(){
            event.preventDefault();
            $('#update_loader').fadeIn();
            $.ajax({
                type: 'POST',
                url: 'utilisateurs/update_user',
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