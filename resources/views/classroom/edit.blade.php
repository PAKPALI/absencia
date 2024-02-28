<form id="update">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="form-group col-6">
                <label for="exampleInputText0">Nom</label>
                <input type="hidden" name="id" value="{{$Classroom->id}}" class="form-control" id="exampleInputText0">
                <input type="text" name="name" value="{{$Classroom->name}}" class="form-control" id="exampleInputText0" placeholder="Nom">
            </div>
            <div class="form-group col-6">
                <label>Responsable</label>
                <select name="manager" class="form-control">
                    <option value="">Sélectionnez le responsable</option>
                    <option selected value="{{$Classroom->user->id}}">{{strtoupper($Classroom->user->last_name)}} {{strtoupper($Classroom->user->first_name)}}</option>
                    @foreach ($Professor->where('id', '!=', $Classroom->user->id) as $p)
                    <option value="{{$p->id}}">
                        {{strtoupper($p->last_name)}} {{strtoupper($p->first_name)}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12">
                <label>Professeurs</label>
                <select name="professor[]" class="duallistbox" multiple="multiple">
                    @if($professor_selected_array)
                        @foreach ($professor_selected_array as $professor)
                        <option selected value="{{$professor->id}}">
                            {{strtoupper($professor->last_name)}} {{strtoupper($professor->first_name)}}
                        </option>
                        @endforeach
                    @endif

                    @php
                    $availableProfessors = $Professor->diff($professor_selected_array);
                    @endphp

                    @foreach ($availableProfessors as $p)
                    <option value="{{$p->id}}">
                        {{strtoupper($p->last_name)}} {{strtoupper($p->first_name)}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- loader -->
        <div id="update_loader" class="text-center">
            <img class="animation__shake" src="{{asset('img/trimax.gif')}}" alt="TRIMAX_Logo" height="70" width="70">
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-warning">Valider</button>
    </div>
</form>
<!-- script -->
<script>
    $(function() {
        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()
        $('#loader').hide();
        $('#loader2').hide();
        $('#update_loader').fadeOut();

        $('#update').submit(function() {
            event.preventDefault();
            $('#update_loader').fadeIn();
            $.ajax({
                type: 'POST',
                url: 'classroom/update',
                //enctype: 'multipart/form-data',
                data: $('#update').serialize(),
                datatype: 'json',
                success: function(data) {
                    console.log(data)
                    if (data.status) {
                        Swal.fire({
                            icon: "success",
                            title: data.title,
                            text: data.msg,
                        }).then(() => {
                            $('#modal-update').modal('hide');
                            $('#class_list').DataTable().ajax.reload(null, true);
                        })
                    } else {
                        $('#update_loader').fadeOut();
                        Swal.fire({
                            title: data.title,
                            text: data.msg,
                            icon: 'error',
                            confirmButtonText: "Ok",
                            confirmButtonColor: 'blue',
                        })
                    }
                },
                error: function(data) {
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
    });
</script>