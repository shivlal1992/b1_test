@inject('User_notifications', 'App\Models\User_notifications')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>B-1 Test</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Favicons -->
  <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="{{asset('assets/css/style.css')}}?v=<?php echo time(); ?>" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <style>
    /* body {
      background: url('public/uploads/bg-img-1.jpg') no-repeat center center fixed;
      background-size: cover;
  } */
  /* .sidebar{
    background-color: #011b35; 
  } */

  
.icons-container {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .icon {
            position: absolute;
            font-size: 40px;
            opacity: 0.3;
        }
  </style>
  @yield('style')
</head>
<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="{{route('admin.dashboard')}}" class="logo d-flex align-items-center">
        <img src="{{asset('assets/img/logo.png')}}" alt="">
        <span class="d-none d-lg-block">B-1 Test</span>
      </a>
      <i class="bi bi-list-nested toggle-sidebar-btn"></i>
    </div><!-- End Logo -->
  <?php 
    $user_notification_data = $User_notifications->where("user_id",auth()->user()->id)->where("status","0")->orderBy("created_at","desc")->get();
  ?>
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
      <li class="nav-item dropdown">
      @if(auth()->user()->is_terminate == 1)
              <a class="nav-link nav-icon" href="javascript:void(0);" >
            @else
          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            @endif
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">{{!empty($user_notification_data[0]) ? count($user_notification_data) : 0}}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" style="width: 340px;    border-radius: 10px;">
            @if(!empty($user_notification_data[0]))
            @foreach($user_notification_data as $key => $item)
            <li class="notification-item">
              <div>
                <h4>{{$item->title}}</h4>
                <p>{{$item->description}}</p>
                <p><a class="btn btn-sm btn-primary" href="{{url('update-read-status/')}}/{{$item->id}}">Mark as read</a></p>
              </div>
            </li>
            @if(($key+1) != count($user_notification_data))
              <li>
                <hr class="dropdown-divider">
              </li>
            @endif
            @endforeach
            @else
            <li class="notification-item">
              <div>
                <h4>Data not available.</h4>
              </div>
            </li>
            @endif
          </ul>
        </li>
        <li class="nav-item dropdown pe-3">
        @if(auth()->user()->is_terminate == 1)
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="javascript:void(0);" >
            @else
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            @endif
            @if(auth()->user()->is_kyc_done == 1)
            <span style="inset: -2px auto auto 23px !important;    padding: 4px 4px;" class="badge bg-primary badge-number"><i class="bi bi-patch-check"></i></span>
            @endif
            <img src="{{asset(Auth::user()->profile_image)}}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::user()->name}}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{route('my-profile')}}">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{route('change-password')}}">
                <i class="bi bi-lock"></i>
                <span>Change Password</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
              <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                       {{ csrf_field() }}
                              </form>
            </li>
          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
      </ul>
    </nav><!-- End Icons Navigation -->
  </header><!-- End Header -->
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? '' : 'collapsed' }}" href="{{route('admin.dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
  

       @if(auth()->user()->hasAnyRole(['Super Admin']))
      <!-- <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('roles.index') ? '' : 'collapsed' }} " href="{{route('roles.index')}}">
          <i class="bi bi-person-badge"></i>
          <span>Roles</span>
        </a>
      </li> -->
      @endif

      
      @if(auth()->user()->hasAnyRole(['Super Admin']))
      <!-- <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('permissions.index') ? '' : 'collapsed' }}" href="{{route('permissions.index')}}">
          <i class="bi bi-check-all"></i>
          <span>Permissions</span>
        </a>
      </li> -->
      @endif

      @if(auth()->user()->hasAnyRole(['Super Admin']) )
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('districts') ? '' : 'collapsed' }}" href="{{route('districts')}}">
          <i class="bi bi-buildings"></i>
          <span>Districts</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->hasAnyRole(['Super Admin']))
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('users') ? '' : 'collapsed' }}" href="{{route('users')}}">
          <i class="bi bi-person-arms-up"></i>
          <span>District-Level Admins</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->hasAnyRole(['District Admin']))
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('registrars') ? '' : 'collapsed' }}" href="{{route('registrars')}}">
          <i class="bi bi-person-check"></i>
          <span>Registrars</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->hasAnyRole(['Registrar']))
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('suprintendent') ? '' : 'collapsed' }}" href="{{route('suprintendent')}}">
          <i class="bi bi-check-all"></i>
          <span>Suprintendent</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->hasAnyRole(['Super Admin']) || auth()->user()->hasAnyRole(['District Admin']) || auth()->user()->hasAnyRole(['Registrar']) )
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('registered-users') ? '' : 'collapsed' }}" href="{{route('registered-users')}}">
          <i class="bi bi-person-video2"></i>
          <span>Registered Users</span>
        </a>
      </li>
      @endif
      @if(auth()->user()->hasAnyRole(['Super Admin']) || auth()->user()->hasAnyRole(['District Admin']) || auth()->user()->hasAnyRole(['Registrar']))
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('exam-centers') ? '' : 'collapsed' }}" href="{{route('exam-centers')}}">
          <i class="bi bi-building-fill-gear"></i>
          <span>Exam Centers</span>
        </a>
      </li>
      @endif

      @if(auth()->user()->hasAnyRole(['Super Admin']))
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('questions') ? '' : 'collapsed' }}" href="{{route('questions')}}">
          <i class="bi bi-basket3"></i>
          <span>Questions</span>
        </a>
      </li>
      @endif
      @if(auth()->user()->hasAnyRole(['Super Admin']) || auth()->user()->hasAnyRole(['District Admin']) || auth()->user()->hasAnyRole(['Registrar'])|| auth()->user()->hasAnyRole(['Suprintendent']) )
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('exams') ? '' : 'collapsed' }}" href="{{route('exams')}}">
          <i class="bi bi-clipboard-fill"></i>
          <span>Exams</span>
        </a>
      </li>
      @endif
      @if(auth()->user()->hasAnyRole(['Super Admin']))
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('mocktests') ? '' : 'collapsed' }}" href="{{route('mocktests')}}">
          <i class="bi bi-clipboard-fill"></i>
          <span>Mock Test</span>
        </a>
      </li>
      @endif


     <li class="nav-item">
        <a style="cursor:pointer;" class="nav-link collapsed" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="bi bi-box-arrow-right"></i>
          <span>Sign Out</span>
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                       {{ csrf_field() }}
                              </form>
      </li>
    </ul>
  </aside><!-- End Sidebar-->
  <main id="main" class="main">
  <div class="icons-container"></div>
  @yield('content')
  </main><!-- End #main -->
  <!-- ======= Footer ======= -->
  <!-- <footer id="footer" class="footer" >
    <div class="copyright" style="color:white;">
      &copy; Copyright <strong><span>2025</span></strong>. All Rights Reserved
      <p>United Kingdom</p>
    </div>
  </footer> -->
  <!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <!-- Vendor JS Files -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/quill/quill.js')}}"></script>
  <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>
  <!-- Template Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>
  <script src="{{asset('assets/js/threejs.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function () {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
        };

        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @elseif(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @elseif(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @elseif(Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif
    });
</script>
<script>
       document.addEventListener("DOMContentLoaded", function () {
            const container = document.querySelector(".icons-container");
            const icons = ["📖", "✏️", "📜", "📝", "🏆", "🎓"];

            for (let i = 0; i < 30; i++) { 
                const icon = document.createElement("div");
                icon.classList.add("icon");
                icon.textContent = icons[Math.floor(Math.random() * icons.length)];

                // Random position
                icon.style.left = `${Math.random() * 90}vw`;
                icon.style.top = `${Math.random() * 90}vh`;

                // Random size
                icon.style.fontSize = `${Math.random() * 30 + 20}px`; // Between 20px - 50px

                container.appendChild(icon);
            }
        });
    </script>
  @yield('script')
</body>
</html>