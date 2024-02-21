
  @if (Auth::user()->user_type ==1)
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <img src="{{asset('img/trimax.gif')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8" height="100" width="100">
        <span class="brand-text font-weight-light"><h3>ABSENCIA</h3></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{asset('admin/man/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="{{route('profil')}}" class="d-block">{{ strtoupper(Auth::user()->last_name)}}</a>
          </div>
        </div>

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
            <!-- gerer les pays -->
            <li class="nav-header"> GESTION PAYS</li>
            @if( Route::currentRouteName() == "pays")
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="nav-icon fas fa-box"></i>
                  <p>
                    Pays
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('pays')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ajouter pays</p>
                    </a>
                  </li>
                </ul>
              </li>
            @else
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-box"></i>
                  <p>
                    Pays
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('pays')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ajouter pays</p>
                    </a>
                  </li>
                </ul>
              </li>
            @endif

            <!-- gerer les utilisateurs -->
            <li class="nav-header"> GESTION UTILISATEURS</li>
            @if( Route::currentRouteName() == "user")
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                  Administrateurs
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('user')}}" class="nav-link">
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
                    Administrateurs
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('user')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Ajouter</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Gérer des administrateurs</p>
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
  @else
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <img src="{{asset('img/trimax.gif')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8" height="100" width="100">
        <span class="brand-text font-weight-light"><h3>DRYMCOMPTE</h3></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{asset('admin/man/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="{{route('profil')}}" class="d-block">{{ strtoupper(Auth::user()->nom)}}</a>
          </div>
        </div>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
  @endif