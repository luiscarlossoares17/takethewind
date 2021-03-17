<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  @include('stylesheet.adminlte')
  @include('stylesheet.backoffice')
  @include('stylesheet.teamsmanager')
  @yield('styles')
  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul id="sidebar" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{ route('manager') }}" class="nav-link" id="main-page">
                <i class="far fa-circle nav-icon"></i>
                <p>Main Page</p>
            </a>
            <a href="{{ route('companyusers.index') }}" class="nav-link" id="user-page">
                <i class="far fa-circle nav-icon"></i>
                <p>Users</p>
            </a>
            <a href="{{ route('teams.index') }}" class="nav-link" id="team-page">
                <i class="far fa-circle nav-icon"></i>
                <p>Teams</p>
            </a>
          </li>
      
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
          <form method="POST" action="{{ route('logout') }}" class="form-inline my-2 my-lg-0 w-100 d-flex justify-content-end">
          @csrf
            <a id="logout" class="float-right">Logout</a>
          </form>
        </div>
    </nav>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    
    <!-- Main content -->
    <div class="content">
    @component('components.modal', ['id' => 'operation-confirm-modal', 'name' => 'confirm-modal-procceed', 'title' => 'Operation', 'size' => 'medium', 'modalBodyId' => 'confirm-modal-procceed'])

        @slot('footer')
            @component('components.buttons', [
                'element' => 'modal',
                'buttons' => [
                    [
                        'id' => 'confirm-modal-cancel',
                        'category' => 'cancel',
                        'text' => 'Cancel'
                    ],
                    [
                        'id' => 'confirm-modal-button',
                        'category' => 'delete',
                        'text' => 'Delete'
                    ]
                ]
            ])

            @endcomponent
        @endslot
    @endcomponent

        @yield('content')  
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
      @yield('footer')    
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('javascript.app')
@include('javascript.teammanager')
@yield('scripts')

</body>
</html>
