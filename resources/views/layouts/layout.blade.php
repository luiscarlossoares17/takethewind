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
      <nav id="sidebar-main-page" class="mt-2">
          <div id="login-div" class="h-25">
              @if(Auth::check())
                <div class="form-row mt-5 pl-4">
                    <div id="profile" class=" d-flex icon-profile sidebar-font-icon"><p class="ml-3 sidebar-font-icon-text">{{ Auth::user()->name }}</p></div>
                  </div>
                <div class="form-row pl-4" id="navbarTogglerDemo03">                  
                  <form method="POST" action="{{ route('logout') }}" class="form-inline d-flex justify-content-start">
                  @csrf
                    <div id="logout-button" class=" d-flex icon-exit sidebar-font-icon ml-4 mt-4"><p class="ml-3 sidebar-font-icon-text d-flex align-items-center">Logout</p></div>
                  </form>
                </div>                
              @else
              <div class="form-row pl-4" id="">
                    <div id="login-button" class=" d-flex icon-enter sidebar-font-icon"><p class="ml-3 sidebar-font-icon-text d-flex align-items-center">Login</p></div>
                </div>                
              @endif
          </div>
          @if(Auth::check())
            <ul id="sidebar" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                  with font-awesome or any other icon font library -->
              <li class="nav-item menu-open">
                <a href="{{ route('manager') }}" class="nav-link pl-5" id="main-page">
                    <div class="icon-home sidebar-font-icon"><p class="ml-3 sidebar-font-icon-text">Home</p></div>
                </a>
                <a href="{{ route('companyusers.index') }}" class="nav-link pl-5" id="user-page">
                  <div class="icon-user sidebar-font-icon"><p class="ml-3 sidebar-font-icon-text">Users</p></div>
                </a>
                <a href="{{ route('teams.index') }}" class="nav-link pl-5" id="team-page">
                  <div class="icon-users sidebar-font-icon"><p class="ml-3 sidebar-font-icon-text">Teams</p></div>              
                </a>
              </li>
          
            </ul>
          @endif
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

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
@if(!Auth::check())
    @component('components.modal',['id' => 'login-modal', 'name' => 'login-modal', 'size' => 'small', 'title' => "Authentication", 'hasHeader' => false])
    @slot('content')
            <div class="tabpanel" role="tabpanel">
                <div class="form-group">
                    <ul  class="nav nav-tabs topnav">
                        @if(isset($errors) && $errors->has('mode') && $errors->first('mode') == 'register')
                            <li class="nav-item">
                                <a class="show" href=".login" data-toggle="tab">Login</a>
                            </li>
                            <li  class="nav-item">
                                <a class="active show" href=".register" data-toggle="tab">Register</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="active show" href=".login" data-toggle="tab">Login</a>
                            </li>
                            <li  class="nav-item">
                                <a class="show" href=".register" data-toggle="tab">Register</a>
                            </li>
                        @endif
                    </ul>
                </div>
                
                <div class="tab-content">
                    @if(isset($errors) && $errors->has('mode') && $errors->first('mode') == 'register')
                        <div class="tab-pane topnav-content login">
                            @else
                                <div class="tab-pane active topnav-content login">
                                    @endif
                                    <form action="{{ route('login') }}" method="POST" role="form" class="forms">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" name="email" id="email" class="form-control simple-input" placeholder="Email" value="" required>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group topnav-input-margin">
                                            <label>Password</label>
                                            <input type="password" name="password" id="password" class="form-control simple-input" value="" required>
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                        @if($errors->any() && $errors->has('login-error'))
                                            <div class="text-danger">{{ $errors->first('login-error') }}</div>
                                        @endif
                                    
                                        @component('components.buttons',[
                                            'element' => 'modal',
                                            'buttons' => [
                                                [
                                                    'buttonClass'   => 'w-100',
                                                    'category'      => 'cancel',
                                                    'type'          => 'submit',
                                                    'text'          => 'Login'
                                                ],
                                            ],
                                        ])
                                        @endcomponent
                                    </form>
                                </div>
                                @if(isset($errors) && $errors->has('mode') && $errors->first('mode') == 'register')
                                    <div class="tab-pane active topnav-content register">
                                        @else
                                            <div class="tab-pane topnav-content register">
                                                @endif
                                              <form action="{{ route('register') }}" method="POST" role="form" class="forms">
                                                {{ csrf_field() }}
                                                <div class="forms">                                                    
                                                    <div class="form-group topnav-input-margin">
                                                        <label>Name</label>
                                                        <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="" required placeholder="Name">
                                                        @if($errors->has('name'))
                                                            <span class="invalid-feedback">
                                                                {{ $errors->first('name') }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group topnav-input-margin">
                                                        <div class="form-group topnav-input-margin">
                                                            <label>Email</label>
                                                            <input type="text" name="email" id="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" value="" required>
                                                            @if($errors->has('email'))
                                                                <span class="invalid-feedback">
                                                                    {{ $errors->first('email') }}
                                                                </span>
                                                            @endif
                                                    </div>
                                                    <div class="form-group topnav-input-margin">
                                                        <label>Password</label>
                                                        <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" value="" required placeholder="Password">
                                                        @if($errors->has('password'))
                                                            <span class="invalid-feedback">
                                                                {{ $errors->first('password') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group topnav-input-margin">
                                                        <label>Confirm Password</label>                                                        
                                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                                                        @if($errors->has('password'))
                                                            <span class="invalid-feedback">
                                                                {{ $errors->first('password') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @if($errors->has('errors'))
                                                        <div class="text-danger">{{ $errors->first('errors') }}</div>
                                                    @endif
                                                    
                                            
                                                    @component('components.buttons',[
                                                        'element' => 'modal',
                                                        'buttons' => [
                                                            [
                                                                'id'            => 'register-user',
                                                                'buttonClass'   => 'w-100',
                                                                'category'      => 'cancel',
                                                                'type'          => 'submit',
                                                                'text'          => 'Register'
                                                            ],
                                                        ],
                                                    ])
                                                    @endcomponent
                                                    </form>
                                                </div>
                                            </div>
                                            </div>
                                </div>
                        </div>

                    </div>
            @endslot
            @slot('footer')

            @endslot
        @endcomponent
    @endif
<!-- REQUIRED SCRIPTS -->
@include('javascript.app')
@include('javascript.teammanager')
@yield('scripts')

</body>
</html>
