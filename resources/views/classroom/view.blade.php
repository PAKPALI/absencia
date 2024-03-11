<!-- <table class="table table-bordered"> -->
<table class="table table-striped table-bordered">
    <!-- <thead>
        <tr>
            <th style="width: 10px">Intervenants</th>
            <th>Task</th>
        </tr>
    </thead> -->
    <tbody>
        <tr>
            <td><strong>Nom :</strong></td>
            <td>{{$Classroom->name}}</td>
        </tr>
        <tr>
            <td><strong>Responsable :</strong></td>
            <td>{{$Classroom->user->fullName()}}</td>
        </tr>
        <tr>
            <td><strong>Intervenant :</strong></td>
            <td>
                @foreach ($professor_selected_array as $prof)
                    -{{$prof->fullName()}} <br>
                @endforeach
            </td>
        </tr>
    </tbody>
</table>