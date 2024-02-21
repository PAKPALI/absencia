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
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">MODIFIER UTILISATEUR</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="update">
                                @csrf
                                <div class="card-body">
                                    <input type="text" name="id" class="form-control" id="userId">
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
                                        <div class="form-group col-4">
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
                                <div id="loader" class="text-center">
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
                            <div id="loader2" class="text-center">
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

    //Ajax pour ajouter user
    $('#add').submit(function() {
        event.preventDefault();
        $('#loader').fadeIn();
        $.ajax({
            type: 'POST',
            url: 'utilisateurs/add_user',
            //enctype: 'multipart/form-data',
            data: $('#add').serialize(),
            datatype: 'json',
            success: function(data) {
                $('#loader').hide();
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
                    $('#loader').hide();
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
                $('#loader').hide();
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
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var id = $(this).data('id');
        alert(csrfToken)
        $('#Modal_update').modal('show');
        $('#userId').val(id);
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
                    $('#Modal_update').modal('show');
                }
            },
        });
    });

    //Selectionner le pays a modifier
    document.querySelectorAll('.parametrer').forEach(_formNode => {
        //console.log(this);
        _formNode.addEventListener('submit', _event => {
            _event.preventDefault();

            var data1 = new FormData(_formNode);
            console.log(data1.get('id'));
            // console.log(data1.get('nom'));
            // console.log(data1.get('email'));

            var FormId = data1.get('id');
            // var FormNom = data1.get('nom');
            // var FormEmail = data1.get('email');

            document.getElementById("Id_p").value = FormId;
            // document.getElementById("Nom").value = FormNom;
            // document.getElementById("Email").value = FormEmail;

            //envoyez le formulaire au serveur par AJAX
            $('#param').submit(function() {
                event.preventDefault();
                $('#update_loader').fadeIn();
                $.ajax({
                    type: 'POST',
                    url: 'utilisateurs/parametre',
                    //enctype: 'multipart/form-data',
                    data: $('#param').serialize(),
                    datatype: 'json',
                    success: function(data) {
                        //var object = JSON.parse(data);
                        console.log(data)
                        if (data.status) {
                            Swal.fire({
                                icon: "success",
                                title: data.title,
                                text: data.msg,
                            }).then(() => {
                                if (data.redirect_to != null) {
                                    window.location.assign(data
                                        .redirect_to)
                                } else {
                                    window.location.reload()
                                }
                                //window.location.reload();
                            })
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
            });
        });
        return false;
    });

    //Selectionner le user a modifier
    document.querySelectorAll('.update').forEach(_formNode => {
        //console.log(this);
        _formNode.addEventListener('submit', _event => {
            _event.preventDefault();

            var data1 = new FormData(_formNode);
            console.log(data1.get('id'));
            console.log(data1.get('nom'));
            console.log(data1.get('email'));

            var FormId = data1.get('id');
            var FormNom = data1.get('nom');
            var FormEmail = data1.get('email');

            document.getElementById("Id").value = FormId;
            document.getElementById("Nom").value = FormNom;
            document.getElementById("Email").value = FormEmail;

            //envoyez le formulaire au serveur par AJAX
            $('#mp').submit(function() {
                event.preventDefault();
                $('#update_loader').fadeIn();
                $.ajax({
                    type: 'POST',
                    url: 'utilisateurs/update',
                    //enctype: 'multipart/form-data',
                    data: $('#mp').serialize(),
                    datatype: 'json',
                    success: function(data) {
                        //var object = JSON.parse(data);
                        console.log(data)
                        if (data.status) {
                            Swal.fire({
                                icon: "success",
                                title: data.title,
                                text: data.msg,
                            }).then(() => {
                                if (data.redirect_to != null) {
                                    window.location.assign(data
                                        .redirect_to)
                                } else {
                                    window.location.reload()
                                }
                                //window.location.reload();
                            })
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
            });
        });
        return false;
    });

    //Selectionner le user a supprimer
    document.querySelectorAll('.delete').forEach(_formNode => {
        _formNode.addEventListener('submit', _event => {
            event.preventDefault();

            Swal.fire({
                icon: "question",
                title: "Etes vous sur de vouloir supprimer cet utilisateur?",
                text: "Cela pourrait entrainer la suppression automatique des donnés lié a cet utilisateur",
                showCancelButton: true,
                cancelButtonText: 'NON',
                confirmButtonText:  'OUI',
                confirmButtonColor: '#d33',
                cancelButtonColor:  '#3085d6',
            }).then((result) => {
                if (result.isConfirmed){
                    $.ajax({
                        type: 'POST',
                        url: 'utilisateurs/delete',
                        //enctype: 'multipart/form-data',
                        data: $(_formNode).serialize(),
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
                                    if(data.redirect_to != null) {
                                        window.location.assign(data.redirect_to)
                                    }else{
                                        window.location.reload()
                                    }
                                })
                            }else{
                                Swal.fire({
                                    title: data.title,
                                    text:data.msg,
                                    icon: 'error',
                                    confirmButtonText: "D'accord",
                                    confirmButtonColor: '#A40000',
                                })
                            }
                        },
                        error: function (data){
                            console.log(data)
                            Swal.fire({
                                icon: "error",
                                title: "erreur",
                                text: "Impossible de communiquer avec le serveur.",
                                timer: 3600,
                            })
                        }
                    });
                }
            })
            return false;
        });
    });

    $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch();
    })

    // Selectionner le user a modifier
    document.querySelectorAll('.connected').forEach(_formNode => {
        var data1 = new FormData(_formNode);
        var checkbox = $(_formNode).find("input[type='checkbox']");

        var Id = data1.get('id');

        checkbox.on("switchChange.bootstrapSwitch", function(event, state) {
            //envoyez le formulaire au serveur par AJAX
            var switchState = $(_formNode).find("input[type='checkbox']").bootstrapSwitch('state');
            if(switchState){
                var dataToSend = {
                    connected: 1,
                    id: Id
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Récupère automatiquement le token CSRF depuis la balise meta
                    },
                    type: 'POST',
                    url: 'utilisateurs/connected',
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
                    url: 'utilisateurs/connected',
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
            return false;
        });
        return false;
    });

    document.querySelectorAll('.status_client').forEach(_formNode => {
        var data1 = new FormData(_formNode);
        var checkbox = $(_formNode).find("input[type='checkbox']");

        var Id = data1.get('id');

        checkbox.on("switchChange.bootstrapSwitch", function(event, state) {
            //envoyez le formulaire au serveur par AJAX
            var switchState = $(_formNode).find("input[type='checkbox']").bootstrapSwitch('state');
            if(switchState){
                var dataToSend = {
                    connected: 1,
                    id: Id
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Récupère automatiquement le token CSRF depuis la balise meta
                    },
                    type: 'POST',
                    url: 'utilisateurs/status',
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
                    url: 'utilisateurs/status',
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
            return false;
        });
        return false;
    });

});
</script>

</div>
@endsection