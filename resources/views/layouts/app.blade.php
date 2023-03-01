
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>

    <meta charset="utf-8" />
    <title>{{$menu}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{url_plug()}}/img/icon.png">

    <!-- One of the following themes -->
    <link rel="stylesheet" href="{{url_plug()}}/assets/libs/@simonwep/pickr/themes/classic.min.css" /> <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{url_plug()}}/assets/libs/@simonwep/pickr/themes/monolith.min.css" /> <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{url_plug()}}/assets/libs/@simonwep/pickr/themes/nano.min.css" /> <!-- 'nano' theme -->
    <link rel="stylesheet" href="{{url_plug()}}/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="{{url_plug()}}/css/responsive.bootstrap.min.css" />
    <link href="{{url_plug()}}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{url_plug()}}/css/buttons.dataTables.min.css">
    <!-- Layout config Js -->
    <script src="{{url_plug()}}/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="{{url_plug()}}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{url_plug()}}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{url_plug()}}/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{url_plug()}}/assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    @stack('style')
    <style>
        [data-layout=vertical][data-sidebar=dark] .navbar-nav .nav-link {
            color: #fff;
        }
        .loadnya {
			height: 100%;
			width: 0;
			position: fixed;
			z-index: 1070;
			top: 0;
			left: 0;
			background-color: rgb(0,0,0);
			background-color: rgb(243 230 230 / 81%);
			overflow-x: hidden;
			transition: transform .9s;
		}
		.loadnya-content {
			position: relative;
			top: 25%;
			width: 100%;
			text-align: center;
			margin-top: 30px;
			color:#fff;
			font-size:20px;
		}
        .not:hover{
            color: lightblue;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <div id="loadnya" class="loadnya">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="loadnya-content">
			<button class="btn btn-light" type="button" disabled>
  				<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
  				Loading...
			</button>
        </div>
	</div>
    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{url_plug()}}/assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{url_plug()}}/assets/images/logo-dark.png" alt="" height="17">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{url_plug()}}/assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{url_plug()}}/assets/images/logo-light.png" alt="" height="17">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                {{-- <form class="app-search d-none d-md-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search-options" value="">
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                        <div data-simplebar style="max-height: 320px;">
                            <!-- item-->
                            <div class="dropdown-header">
                                <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                            </div>

                            <div class="dropdown-item bg-transparent text-wrap">
                                <a href="index.html" class="btn btn-soft-secondary btn-sm btn-rounded">how to setup <i class="mdi mdi-magnify ms-1"></i></a>
                                <a href="index.html" class="btn btn-soft-secondary btn-sm btn-rounded">buttons <i class="mdi mdi-magnify ms-1"></i></a>
                            </div>
                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                <span>Analytics Dashboard</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                <span>Help Center</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                <span>My account settings</span>
                            </a>

                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>
                            </div>

                            <div class="notification-list">
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{url_plug()}}/assets/images/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">Angela Bernier</h6>
                                            <span class="fs-11 mb-0 text-muted">Manager</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{url_plug()}}/assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">David Grasso</h6>
                                            <span class="fs-11 mb-0 text-muted">Web Designer</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{url_plug()}}/assets/images/users/avatar-5.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">Mike Bunch</h6>
                                            <span class="fs-11 mb-0 text-muted">React Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="text-center pt-3 pb-1">
                            <a href="pages-search-results.html" class="btn btn-primary btn-sm">View All Results <i class="ri-arrow-right-line ms-1"></i></a>
                        </div>
                    </div>
                </form> --}}
            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown topbar-head-dropdown ms-1 header-item">

                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        @if (notification()>0)
                            <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ notification() }}<span class="visually-hidden">unread messages</span></span>
                        @endif
                    </button>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge badge-soft-light fs-13"> New</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Pesan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; ?>
                                        @foreach (ProgramKerja() as $p)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td onclick="location.assign('{{ url('perencanaan/program-kerja-pengawasan') }}')" class="not">Program Kerja Pengawasan - <span>{{ $p->pesan }}</span></td>
                                            </tr>
                                        @endforeach
                                        @foreach (kkp() as $kkp)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td onclick="location.assign('{{ url('perencanaan/program-kerja-pengawasan') }}')" class="not">Kertas Kerja Pemeriksaan - <span>{{ $kkp->pesan_kkp }}</span></td>
                                            </tr>
                                        @endforeach
                                        @foreach (lhp() as $lhp)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td onclick="location.assign('{{ url('perencanaan/program-kerja-pengawasan') }}')" class="not">Kertas Kerja Pemeriksaan - <span>{{ $kkp->pesan_lhp }}</span></td>
                                            </tr>
                                        @endforeach
                                        @foreach (tl() as $t)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td onclick="location.assign('{{ url('perencanaan/program-kerja-pengawasan') }}')" class="not">Kertas Kerja Pemeriksaan - <span>{{ $t->pesan }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>                                   
                        </div>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">

                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{url_plug()}}/img/icon.png" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{Auth::user()->name}}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{Auth::user()->Roles->nama}}</span>
                            </span>
                        </span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{Auth::user()->name}}!</h6>
                        <a class="dropdown-item" onclick="logout()"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                    </div>
                    <form id="logout-form" action="{{ url('logout')}}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>

            </div>

        </div>
    </div>
</header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu" style="background: linear-gradient(to right, #215f00, #1e1e0f);">
            <!-- LOGO -->
            <div class="navbar-brand-box" style="background: #321d07;">
                <!-- Dark Logo-->
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{url_plug()}}/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{url_plug()}}/assets/images/logo-dark.png" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{url_plug()}}/img/icon.png" style="width:50%">
                    </span>
                    <span class="logo-lg">
                        <div class="row py-2">
                            <img src="{{url_plug()}}/img/logo5.png" style="width:80%">
                        </div>
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            @include('layouts.side')

            <div class="sidebar-background" style="background-image: url(https://cdn.pixabay.com/photo/2013/05/05/19/26/leaves-108969__340.jpg);"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            @yield('content')
            <!-- End Page-content -->


            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                             2022 © Inspektorat.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Inspektorat Kota Cilegon
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->





    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->
    <!-- Theme Settings -->
    <div id="modal-notifikasi" class="modal fade" tabindex="-1"  aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5" >
                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f7b84b,secondary:#405189" style="width:130px;height:130px;">
                    </lord-icon>
                    <div class="mt-4 pt-4" style="padding-top: 0rem !important;margin-top:0px !important">
                        <h4>Warning !</h4>

                            <div id="notifikasi" style="background:#ffe1d3;padding:1%;margin-bottom:3%">ssss</div>

                        <!-- Toogle to second dialog -->
                        <button class="btn btn-danger" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{url_plug()}}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{url_plug()}}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{url_plug()}}/assets/libs/node-waves/waves.min.js"></script>
    <script src="{{url_plug()}}/assets/libs/feather-icons/feather.min.js"></script>
    <script src="{{url_plug()}}/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>


    <!-- Modern colorpicker bundle -->
    <script src="{{url_plug()}}/assets/libs/@simonwep/pickr/pickr.min.js"></script>
    <script src="{{url_plug()}}/assets/libs/prismjs/prism.js"></script>
    <script src="{{url_plug()}}/js/jquery-3.6.0.min.js"></script>

    <!--datatable js-->
    <script src="{{url_plug()}}/js/jquery.dataTables.min.js"></script>
    <script src="{{url_plug()}}/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{url_plug()}}/js/dataTables.responsive.min.js"></script>
    <script src="{{url_plug()}}/js/dataTables.buttons.min.js"></script>
    <script src="{{url_plug()}}/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="{{url_plug()}}/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
    <script src="{{url_plug()}}/assets/js/pages/form-pickers.init.js"></script>
    @stack('ajax')

    <!--app js-->
    <script src="{{url_plug()}}/assets/js/app.js"></script>
    <script src="{{url_plug()}}/assets/libs/apexcharts/apexcharts.min.js"></script>

    <script>
        function logout(){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#logout-form').submit()
                }})
             }
    </script>

</body>

</html>
