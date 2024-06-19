<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ludo | Admin Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('admin/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('admin/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('admin/plugins/summernote/summernote-bs4.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  {{-- <script>
	function initFreshChat() {
	  window.fcWidget.init({
		token: "641b359e-c9de-4f9f-81c3-e928e5764f58",
		host: "https://wchat.in.freshchat.com"
	  });
	}
	function initialize(i,t){var e;i.getElementById(t)?initFreshChat():((e=i.createElement("script")).id=t,e.async=!0,e.src="https://wchat.in.freshchat.com/js/widget.js",e.onload=initFreshChat,i.head.appendChild(e))}function initiateCall(){initialize(document,"Freshdesk Messaging-js-sdk")}window.addEventListener?window.addEventListener("load",initiateCall,!1):window.attachEvent("load",initiateCall,!1);
  </script> --}}
</head>
<body class="hold-transition sidebar-mini layout-fixed " id="side">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top mb-5">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>


    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->

      <!-- <li class="nav-item mr-2">
        <a href="{{route('admin.binance')}}" class="btn btn-primary">Buy</a>
        <a href="{{route('admin.sellCoin')}}" class="btn btn-warning">Sell</a>
        <a href="{{route('binance.allCoins')}}" class="btn btn-info">Add Coin</a>
      </li> -->
      
      
      <li class="nav-item ">
        <a class="nav-link" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
          Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{asset('admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('admin/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item ">
            <a href="{{route('admin.home')}}" class="nav-link {{ request()->is('admin/home') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
            
          </li>
          <!-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                  Binance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{route('admin.binance')}}" class="nav-link {{ request()->is('admin/binance') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Coin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.sellCoin')}}" class="nav-link {{ request()->is('admin/sellCoin') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sell Coin</p>
                </a>
              <li class="nav-item">
                <a href="{{route('binance.details')}}" class="nav-link {{ request()->is('admin/binanceDetails') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Details</p>
                </a>
              </li>
            </ul>
          </li> -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                  Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{route('admin.users')}}" class="nav-link {{ request()->is('admin/incomeWallet') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.activeUsers')}}" class="nav-link {{ request()->is('admin/fuelWallet') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Users</p>
                </a>
              </li>
            </ul>
          <li class="nav-item">
            <a href="{{route('admin.sponsers')}}" class="nav-link {{ request()->is('admin/sponsers') ? 'active' : '' }}" class="nav-link ">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Downlines
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-wallet"></i>
              <p>
                Packages
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
          <li class="nav-item">
            <a href="{{route('admin.packages')}}" class="nav-link {{ request()->is('admin/packages') ? 'active' : '' }}" class="nav-link ">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Packages
              </p>
            </a>
          <li class="nav-item">
            <a href="{{route('admin.gamePackages')}}" class="nav-link {{ request()->is('admin/gamePackages') ? 'active' : '' }}" class="nav-link ">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Game Packages
              </p>
            </a>
          </li>
        </ul>
      </li>

          {{-- <li class="nav-item">
            <a href="{{route('admin.incomeWallet')}}" class="nav-link {{ request()->is('admin/incomeWallet') ? 'active' : '' }}" class="nav-link ">
              <i class="nav-icon fas fa-wallet"></i>
              <p>
                Income Wallet Details
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.fuelWallet')}}" class="nav-link {{ request()->is('admin/fuelWallet') ? 'active' : '' }}" class="nav-link ">
              <i class="nav-icon fas fa-wallet"></i>
              <p>
                Fuel Wallet Details
              </p>
            </a>
          </li> --}}
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-wallet"></i>
              <p>
                  Wallet Details
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              {{-- <li class="nav-item">
                <a href="{{route('admin.incomeWallet')}}" class="nav-link {{ request()->is('admin/incomeWallet') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Income Wallet</p>
                </a>
              </li> --}}
              <li class="nav-item">
                <a href="{{route('admin.fuelWallet')}}" class="nav-link {{ request()->is('admin/fuelWallet') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Chip Wallet</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.transactions')}}" class="nav-link {{ request()->is('admin/transactions') ? 'active' : '' }}" class="nav-link ">
              <i class="nav-icon fas fa-list"></i>
              <p>
                All Transactions
              </p>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a href="{{route('admin.withdraws')}}" class="nav-link {{ request()->is('admin/withdrawDetails') ? 'active' : '' }}" class="nav-link ">
              <i class="nav-icon fas fa-money-bill-alt"></i>
              <p>
                Withdraw Details
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.withdrawRequest')}}" class="nav-link {{ request()->is('admin/withdrawRequest') ? 'active' : '' }}" class="nav-link ">
              <i class="nav-icon fas fa-inbox"></i>
              <p>
                Withdraw Requests
              </p>
            </a>
          </li> --}}
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-bill-alt"></i>
              <p>
                  User Payments
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{route('admin.pendingPayments')}}" class="nav-link" >
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.completedPayments')}}" class="nav-link {{ request()->is('admin/completedPayments') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Completed</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.rejectedPayments')}}" class="nav-link {{ request()->is('admin/rejectedPayments') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rejected</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-bill-alt"></i>
              <p>
                  Withdraws
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{route('admin.withdraws')}}" class="nav-link" >
                  <i class="far fa-circle nav-icon"></i>
                  <p>Details</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.withdrawRequest')}}" class="nav-link {{ request()->is('admin/withdrawRequest') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Requests</p>
                </a>
              </li>
            </ul>
          </li>
         
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon ion-android-settings"></i>
              <p>
                  Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{route('admin.addApi')}}" class="nav-link {{ request()->is('admin/addApi') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Url's</p>
                </a>
                <a href="{{route('admin.changeProfile')}}" class="nav-link {{ request()->is('admin/changeProfile') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Profile</p>
                </a>
                {{-- <a href="{{route('binance.allCoins')}}" class="nav-link {{ request()->is('admin/allCoins') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Coins</p>
                </a> --}}

              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
        <main class="py-4 mt-5">
            @yield('content')
        </main>
    </div>
    <!-- jQuery -->
<script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('admin/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('admin/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('admin/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('admin/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('admin/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('admin/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('admin/dist/js/demo.js')}}"></script>

<script>



//watch window resize
$(window).on('resize', function() {
  if ($(this).width() > 950) {
    $('#side').addClass('sidebar-open').removeClass('sidebar-collapse');
  }
  else{
    $('#side').addClass('sidebar-collapse').removeClass('sidebar-open');
  }
});

$(window).on('load', function() {
  if ($(this).width() > 950) {
    $('#side').addClass('sidebar-open').removeClass('sidebar-collapse');
  }
  else{
    $('#side').addClass('sidebar-collapse').removeClass('sidebar-open');
  }
});
</script>
</body>
</html>
