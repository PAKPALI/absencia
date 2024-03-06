 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
   <!-- Brand Logo -->
   <a href="#" class="brand-link">
     <img src="{{asset('img/trimax.gif')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8" height="100" width="100">
     <span class="brand-text font-weight-light">
       <h3>ABSENCIA</h3>
     </span>
   </a>

   <!-- Sidebar -->
   <div class="sidebar">
     <!-- Sidebar user panel (optional) -->
     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       <div class="image">
         <!-- <img src="{{asset('admin/man/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image"> -->
       </div>
       <div class="info">
         <a href="{{route('profil')}}" class="d-block">{{ strtoupper(Auth::user()->last_name)}} {{strtoupper(Auth::user()->first_name)}}</a>
       </div>
     </div>
     @php
      use App\Models\Classroom;
      $userId = Auth::user()->id;

      $classroomManager = Classroom::where('manager', $userId)->get();
      $classroomProfessor = Classroom::whereRaw("FIND_IN_SET($userId, professor)")->get();
     @endphp

     <!-- Sidebar Menu -->
     <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
         @if( Route::currentRouteName() == "tableau")
         <li class="nav-item menu">
           <a href="{{route('tableau')}}" class="nav-link active">
             <i class="nav-icon fas fa-tachometer-alt"></i>
             <p>
               Tableau de bord
             </p>
           </a>
         </li>
         @else
         <li class="nav-item menu">
           <a href="{{route('tableau')}}" class="nav-link">
             <i class="nav-icon fas fa-tachometer-alt"></i>
             <p>
               Tableau de bord
             </p>
           </a>
         </li>
         @endif
         <!-- Manage school -->
         <li class="nav-header">RESPONSABLE</li>
         @if( Route::currentRouteName() == "classroomManager")
         <li class="nav-item">
           <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-box"></i>
             <p>
               Responsable
               <i class="fas fa-angle-left right"></i>
             </p>
           </a>
           @foreach ($classroomManager as $cm)
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('classroomManager',encrypt(['id' => $cm->id]))}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{$cm->name}}</p>
                </a>
              </li>
            </ul>
           @endforeach
         </li>
         @else
         <li class="nav-item">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-box"></i>
             <p>
             Responsable
               <i class="fas fa-angle-left right"></i>
             </p>
           </a>
           @foreach ($classroomManager as $cm)
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('classroomManager',encrypt(['id' => $cm->id]))}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{$cm->name}}</p>
                </a>
              </li>
            </ul>
           @endforeach
         </li>
         @endif

         <!-- manage classroom -->
         <li class="nav-header"> INTERVENANT</li>
         @if( Route::currentRouteName() == "classroomProfessor")
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Intervenant
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            @foreach ($classroomProfessor as $cp)
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('classroomProfessor',encrypt(['id' => $cp->id]))}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{$cp->name}}</p>
                </a>
              </li>
            </ul>
           @endforeach
          </li>
         @else
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Intervenant
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            @foreach ($classroomProfessor as $cp)
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('classroomProfessor',encrypt(['id' => $cp->id]))}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{$cp->name}}</p>
                </a>
              </li>
            </ul>
           @endforeach
          </li>
         @endif
       </ul>
     </nav>
     <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
 </aside>