<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Admin & Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <meta name="csrf-token" content="{{csrf_token()}}" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('public') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public') }}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('public') }}/assets/libs/toastr/build/toastr.min.css">
            <script src="{{ asset('public') }}/assets/libs/toastr/build/toastr.min.js"></script>
            <script src="{{ asset('public') }}/assets/js/pages/toastr.init.js"></script>
    <link href="{{ asset('public') }}/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public') }}/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public') }}/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('public') }}/assets/libs/%40chenfengyuan/datepicker/datepicker.min.css">
</head>
<style>
    .navbar-brand-box {
    background-color: #474747!important;
    padding-top: .8rem;
    font-size: 1.3rem;
    font-weight: bold;
    color: #fff; /* or any other color you want */
  text-decoration: none;
}
.hover-color{
    background: #fff;
}

.navbar-brand-box.navbar-brand {
  font-family: Arial, sans-serif; /* or any other font family you want */
  letter-spacing: 1px; /* adjust the letter spacing to your liking */
}
</style>
<script>
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": 300,
      "hideDuration": 1000,
      "timeOut": 5000,
      "extendedTimeOut": 1000,
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
</script>
@yield('css')
    <body data-sidebar="dark" data-layout-mode="light">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <div id="layout-wrapper">
                <header id="page-topbar">
                    <div class="navbar-header">
                        <div class="d-flex">
                            <!-- LOGO -->
                            <div class="navbar-brand-box">
                                <a class="navbar-brand" href="#">Healthy Mind</a>
                            </div>


                            <div class="dropdown dropdown-mega d-none d-lg-block ms-2">
                                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                    {{-- <span key="t-megamenu">Mega Menu</span> --}}
                                    {{-- <i class="mdi mdi-chevron-down"></i> --}}
                                </button>
                            </div>
                        </div>

                        <div class="d-flex">

                            <div class="dropdown d-inline-block d-lg-none ms-2">
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                    aria-labelledby="page-header-search-dropdown">

                                    <form class="p-3">
                                        <div class="form-group m-0">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="dropdown d-none d-lg-inline-block ms-1">
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                                    <div class="px-lg-2">
                                        <div class="row g-0">
                                            <div class="col">
                                                <a class="dropdown-icon-item" href="#">
                                                    <img src="{{ asset('public') }}/assets/images/brands/github.png" alt="Github">
                                                    <span>GitHub</span>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a class="dropdown-icon-item" href="#">
                                                    <img src="{{ asset('public') }}/assets/images/brands/bitbucket.png" alt="bitbucket">
                                                    <span>Bitbucket</span>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a class="dropdown-icon-item" href="#">
                                                    <img src="{{ asset('public') }}/assets/images/brands/dribbble.png" alt="dribbble">
                                                    <span>Dribbble</span>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row g-0">
                                            <div class="col">
                                                <a class="dropdown-icon-item" href="#">
                                                    <img src="{{ asset('public') }}/assets/images/brands/dropbox.png" alt="dropbox">
                                                    <span>Dropbox</span>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a class="dropdown-icon-item" href="#">
                                                    <img src="{{ asset('public') }}/assets/images/brands/mail_chimp.png" alt="mail_chimp">
                                                    <span>Mail Chimp</span>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a class="dropdown-icon-item" href="#">
                                                    <img src="{{ asset('public') }}/assets/images/brands/slack.png" alt="slack">
                                                    <span>Slack</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown d-none d-lg-inline-block ms-1">
                                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                                    <i class="bx bx-fullscreen"></i>
                                </button>
                            </div>

                            {{-- <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-bell bx-tada"></i>
                                    <span class="badge bg-danger rounded-pill">3</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                    aria-labelledby="page-header-notifications-dropdown">
                                    <div class="p-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0" key="t-notifications"> Notifications </h6>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#!" class="small" key="t-view-all"> View All</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-simplebar style="max-height: 230px;">
                                        <a href="javascript: void(0);" class="text-reset notification-item">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3">
                                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                        <i class="bx bx-cart"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1" key="t-your-order">Your order is placed</h6>
                                                    <div class="font-size-12 text-muted">
                                                        <p class="mb-1" key="t-grammer">If several languages coalesce the grammar</p>
                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript: void(0);" class="text-reset notification-item">
                                            <div class="d-flex">
                                                <img src="{{ asset('public') }}/assets/images/users/avatar-3.jpg"
                                                    class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">James Lemire</h6>
                                                    <div class="font-size-12 text-muted">
                                                        <p class="mb-1" key="t-simplified">It will seem like simplified English.</p>
                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago">1 hours ago</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript: void(0);" class="text-reset notification-item">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3">
                                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                                        <i class="bx bx-badge-check"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1" key="t-shipped">Your item is shipped</h6>
                                                    <div class="font-size-12 text-muted">
                                                        <p class="mb-1" key="t-grammer">If several languages coalesce the grammar</p>
                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">3 min ago</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <a href="javascript: void(0);" class="text-reset notification-item">
                                            <div class="d-flex">
                                                <img src="{{ asset('public') }}/assets/images/users/avatar-4.jpg"
                                                    class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">Salena Layfield</h6>
                                                    <div class="font-size-12 text-muted">
                                                        <p class="mb-1" key="t-occidental">As a skeptical Cambridge friend of mine occidental.</p>
                                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago">1 hours ago</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="p-2 border-top d-grid">
                                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More..</span>
                                        </a>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="rounded-circle header-profile-user" src="{{ asset('public') }}/assets/images/users/avatar-1.jpg"
                                        alt="Header Avatar">
                                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">Henry</span>
                                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                                    <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i> <span key="t-my-wallet">My Wallet</span></a>
                                    <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">Settings</span></a>
                                    <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i> <span key="t-lock-screen">Lock screen</span></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="#"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                                </div>
                            </div>

                            {{-- <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                                    <i class="bx bx-cog bx-spin"></i>
                                </button>
                            </div> --}}

                        </div>
                    </div>
                </header>
                @if(session('success'))
                <script>
                  toastr["success"]("{{ session('success') }}");
                </script>
              @endif
                <!-- ========== Left Sidebar Start ========== -->
                <div class="vertical-menu">

                    <div data-simplebar class="h-100">

                        <!--- Sidemenu -->
                        <div id="sidebar-menu">
                            <!-- Left Menu Start -->
                            <ul class="metismenu list-unstyled" id="side-menu">
                                <li class="menu-title" key="t-menu">Menu</li>

                                <li>
                                    <a href="javascript: void(0);" class="">
                                        <i class="bx bx-home-circle"></i>
                                        <span key="t-dashboards">Dashboards</span>
                                    </a>
                                </li>

                                <li  class="{{ Request::is('patients') || Request::is('patients/create') || Request::is('patients/*') ? 'mm-active' : '' }}">
                                    <a href="{{url('patients')}}">
                                        <i class="bx bx-layout"></i>
                                        <span key="t-layouts">Patients</span>
                                    </a>

                                </li>

                                {{-- <li class="menu-title" key="t-apps">Apps</li> --}}


                                <li class="{{ Request::is('medicines') || Request::is('medicines/create') || Request::is('medicines/*') ? 'mm-active' : '' }}">
                                    <a href="{{url('medicines')}}" >
                                        <i class="bx bx-layout"></i>
                                        <span key="t-dashboards">Medicine</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="javascript: void(0);">
                                        <i class="bx bx-layout"></i>
                                        <span key="t-layouts">Dispense</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="chat.html" class="waves-effect">
                                        <i class="bx bx-layout"></i>
                                        <span key="t-chat">Bill Book</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="chat.html" class="waves-effect">
                                        <i class="bx bx-layout"></i>
                                        <span key="t-chat">Stock Book</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Sidebar -->
                    </div>
                </div>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <!-- Left Sidebar End -->
                @yield('main')
                {{-- <footer class="footer">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-sm-6">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> © Healthy Mind.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by Healthy Mind
                                </div>
                            </div>
                        </div>
                    </div>
                </footer> --}}
            </div>
            </div>
            <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center px-3 py-4">

                    <h5 class="m-0 me-2">Settings</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h6 class="text-center mb-0">Choose Layouts</h6>

                <div class="p-4">
                    <div class="mb-2">
                        <img src="{{ asset('public') }}/assets/images/layouts/layout-1.jpg" class="img-thumbnail" alt="layout images">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="{{ asset('public') }}/assets/images/layouts/layout-2.jpg" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch">
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="{{ asset('public') }}/assets/images/layouts/layout-3.jpg" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch">
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="{{ asset('public') }}/assets/images/layouts/layout-4.jpg" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-5">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">
                        <label class="form-check-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
                    </div>


                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <script src="{{ asset('public') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('public') }}/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="{{ asset('public') }}/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="{{ asset('public') }}/assets/libs/node-waves/waves.min.js"></script>
        <script src="{{ asset('public') }}/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="{{ asset('public') }}/assets/libs/spectrum-colorpicker2/spectrum.min.js"></script>
        <script src="{{ asset('public') }}/assets/libs/apexcharts/apexcharts.min.js"></script>
        <script src="{{ asset('public') }}/assets/js/pages/dashboard-job.init.js"></script>
                <script src="{{ asset('public') }}/assets/libs/dropzone/min/dropzone.min.js"></script>
                <script src="{{ asset('public') }}/assets/libs/toastr/build/toastr.min.js"></script>
                <script src="{{ asset('public') }}/assets/js/pages/toastr.init.js"></script>
                <script src="{{ asset('public') }}/assets/js/app.js"></script>
                <script src="{{ asset('public') }}/assets/js/app.js"></script>
                    <!-- form repeater js -->
                <script src="{{ asset('public') }}/assets/libs/jquery.repeater/jquery.repeater.min.js"></script>
                 <script src="{{ asset('public') }}/assets/js/pages/form-repeater.int.js"></script>
         <!-- Sweet Alerts js -->
        <script src="{{ asset('public') }}/assets/libs/sweetalert2/sweetalert2.min.js"></script>
        <script src="{{ asset('public') }}/assets/js/pages/sweet-alerts.init.js"></script>
        <script>
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        </script>
        @yield('customJs')

</body>

<!-- Mirrored from themesbrand.com/skote/layouts/dashboard-job.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 07 Aug 2023 16:08:27 GMT -->
</html>
    {{-- @include('layout/header'); --}}
    {{-- @include('layout/footer') --}}
