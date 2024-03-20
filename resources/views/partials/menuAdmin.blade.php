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

     <!-- Sidebar Menu -->
     <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
         @if( Route::currentRouteName() == "tableau")
         <li class="nav-item menu">
           <a href="{{route('dashboardAdmin')}}" class="nav-link active">
             <i class="nav-icon fas fa-tachometer-alt"></i>
             <p>
               Tableau de bord
             </p>
           </a>
         </li>
         @else
         <li class="nav-item menu">
           <a href="{{route('dashboardAdmin')}}" class="nav-link">
             <i class="nav-icon fas fa-tachometer-alt"></i>
             <p>
               Tableau de bord
             </p>
           </a>
         </li>
         @endif
         <!-- Manage school -->
         <li class="nav-header"> GESTION ECOLE</li>
         @if( Route::currentRouteName() == "school")
         <li class="nav-item">
           <a href="#" class="nav-link active">
             <i class="nav-icon fas fa-box"></i>
             <p>
               Ecole
               <i class="fas fa-angle-left right"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="{{route('school')}}" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Ajouter</p>
               </a>
             </li>
           </ul>
         </li>
         @else
         <li class="nav-item">
           <a href="#" class="nav-link">
             <i class="nav-icon fas fa-box"></i>
             <p>
               Ecole
               <i class="fas fa-angle-left right"></i>
             </p>
           </a>
           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="{{route('school')}}" class="nav-link">
                 <i class="far fa-circle nav-icon"></i>
                 <p>Ajouter</p>
               </a>
             </li>
           </ul>
         </li>
         @endif

         <!-- manage professor -->
         <li class="nav-header"> GESTION PROFESSEUR</li>
         @if( Route::currentRouteName() == "professor")
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Professeur
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('professor')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ajouter</p>
                </a>
              </li>
            </ul>
          </li>
         @else
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Professeur
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('professor')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ajouter</p>
                </a>
              </li>
            </ul>
          </li>
         @endif

         <!-- manage classroom -->
         <li class="nav-header"> GESTION CLASSE</li>
         @if( Route::currentRouteName() == "classroom")
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Classe
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('classroom')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ajouter</p>
                </a>
              </li>
            </ul>
          </li>
         @else
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Classe
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('classroom')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ajouter</p>
                </a>
              </li>
            </ul>
          </li>
         @endif
       </ul>
     </nav>
     <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
 </aside>