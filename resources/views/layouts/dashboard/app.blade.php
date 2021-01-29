<!DOCTYPE html>

<html lang="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> @yield('title', 'Mypos') </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <script src="{{ asset('dashboard/plugins/noty/noty.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('dashboard/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dashboard/bower_components/Ionicons/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dashboard/dist/css/skins/skin-blue.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dashboard/dist/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('dashboard/plugins/noty/noty.css') }}">

    <link rel="stylesheet" href="{{ asset('dashboard/plugins/noty/themes/metroui.css') }}">
    {{--morris--}}
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/morris/morris.css') }}">
    @if (app()->getLocale() == 'ar')

    <link rel="stylesheet" href="{{ asset('dashboard/bower_components/bootstrap/dist/css/bootstrap-rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/bower_components/font-awesome/css/font-awesome-rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/dist/css/AdminLTE-rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/dist/css/rtl.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo:400,700">

    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Cairo', sans-serif !important;
        }

    </style>

    
    @else
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="{{ asset('dashboard/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/dist/css/AdminLTE.min.css') }}">
    @endif


    {{-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries  --}}
    {{-- WARNING: Respond.js doesn't work if you view the page via file://  --}}
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->

    <!-- Google Font -->

<style>
.loader {
  border: 10px solid #f3f3f3;
  border-radius: 50%;
  border-top: 10px solid #3498db;
  width: 50px;
  height: 50px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
@notify_css
@notify_js
@notify_render
@include('sweetalert::alert')
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])


<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.19.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.18.0/firebase-messaging.js"></script>
<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->

<script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyAE8H8yuIaEkyXWtLkOX0lu8fHoKtmHtuc",
        authDomain: "mypos-e68ee.firebaseapp.com",
        databaseURL: "https://mypos-e68ee.firebaseio.com",
        projectId: "mypos-e68ee",
        storageBucket: "mypos-e68ee.appspot.com",
        messagingSenderId: "203411580144",
        appId: "1:203411580144:web:e5b51c423969d906288e35"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    
</script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>

<link rel="stylesheet" href="{{ asset('dashboard/plugins/bootstrap-iconpicker/dist/css/bootstrap-iconpicker.min.css') }}" />


</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>A</b>LT</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>My</b>POS</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- Messages: style can be found in dropdown.less-->
                        {{-- <li class="dropdown messages-menu">--}}
                        {{-- <!-- Menu toggle button -->--}}
                        {{-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                        {{-- <i class="fa fa-envelope-o"></i>--}}
                        {{-- <span class="label label-success">4</span>--}}
                        {{-- </a>--}}
                        {{-- <ul class="dropdown-menu">--}}
                        {{-- <li class="header">You have 4 messages</li>--}}
                        {{-- <li>--}}
                        {{-- <!-- inner menu: contains the messages -->--}}
                        {{-- <ul class="menu">--}}
                        {{-- <li><!-- start message -->--}}
                        {{-- <a href="#">--}}
                        {{-- <div class="pull-left">--}}
                        {{-- <!-- User Image -->--}}
                        {{-- <img src="{{ asset('dashboard/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">--}}
                        {{-- </div>--}}
                        {{-- <!-- Message title and timestamp -->--}}
                        {{-- <h4>--}}
                        {{-- Support Team--}}
                        {{-- <small><i class="fa fa-clock-o"></i> 5 mins</small>--}}
                        {{-- </h4>--}}
                        {{-- <!-- The message -->--}}
                        {{-- <p>Why not buy a new awesome theme?</p>--}}
                        {{-- </a>--}}
                        {{-- </li>--}}
                        {{-- <!-- end message -->--}}
                        {{-- </ul>--}}
                        {{-- <!-- /.menu -->--}}
                        {{-- </li>--}}
                        {{-- <li class="footer"><a href="#">See All Messages</a></li>--}}
                        {{-- </ul>--}}
                        {{-- </li>--}}
                        <!-- /.messages-menu -->

                        {{-- <!-- Notifications Menu -->--}}
                        {{-- <li class="dropdown notifications-menu">--}}
                        {{-- <!-- Menu toggle button -->--}}
                        {{-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
                        {{-- <i class="fa fa-bell-o"></i>--}}
                        {{-- <span class="label label-warning">10</span>--}}
                        {{-- </a>--}}
                        {{-- <ul class="dropdown-menu">--}}
                        {{-- <li class="header">You have 10 notifications</li>--}}
                        {{-- <li>--}}
                        {{-- <!-- Inner Menu: contains the notifications -->--}}
                        {{-- <ul class="menu">--}}
                        {{-- <li><!-- start notification -->--}}
                        {{-- <a href="#">--}}
                        {{-- <i class="fa fa-users text-aqua"></i> 5 new members joined today--}}
                        {{-- </a>--}}
                        {{-- </li>--}}
                        {{-- <!-- end notification -->--}}
                        {{-- </ul>--}}
                        {{-- </li>--}}
                        {{-- <li class="footer"><a href="#">View all</a></li>--}}
                        {{-- </ul>--}}
                        {{-- </li>--}}
                        <!-- Tasks Menu -->
                        <li class="dropdown tasks-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-language"></i>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <!-- Inner menu: contains the tasks -->
                                    <ul class="menu">
                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <li>
                                            <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                {{ $properties['native'] }}
                                            </a>
                                        </li>
                                        @endforeach
                                        <!-- end task item -->
                                    </ul>

                                </li>

                            </ul>
                        </li>
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{ auth()->user()->image_path }}" class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="{{ auth()->user()->image_path }}" class="img-circle" alt="User Image">

                                    <p>
                                        {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                                        <small>Member since {{ auth()->user()->created_at }}</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">

                                    <!-- /.row -->
                                </li>
                                <!-- Menu Footer-->

                                <li class="user-footer">
                                    {{-- <div class="pull-left">--}}
                                    {{-- <a href="#" class="btn btn-default btn-flat">Profile</a>--}}
                                    {{-- </div>--}}
                                    <div>

                                        <form action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <input onclick="new_logout()" class="form-control" type="submit" value="@lang('site.logout')">
                                        </form>
                                        {{-- <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>--}}
                                    </div>
                                </li>
                            </ul>
                        </li>
                        {{-- <!-- Control Sidebar Toggle Button -->--}}
                        {{-- <li>--}}
                        {{-- <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>--}}
                        {{-- </li>--}}
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->

        @include('layouts.dashboard._aside')

        <!-- Content Wrapper. Contains page content -->

        <!-- Main content page -->

        @yield('content')

        <!-- content of page -->

        @include('partials._session')
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        {{-- <footer class="main-footer">--}}
        {{-- <!-- To the right -->--}}
        {{-- <div class="pull-right hidden-xs">--}}
        {{-- Anything you want--}}
        {{-- </div>--}}
        {{-- <!-- Default to the left -->--}}
        {{-- <strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.--}}
        {{-- </footer>--}}

        <!-- Control Sidebar -->
        {{-- <aside class="control-sidebar control-sidebar-dark">--}}
        {{-- <!-- Create the tabs -->--}}
        {{-- <ul class="nav nav-tabs nav-justified control-sidebar-tabs">--}}
        {{-- <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>--}}
        {{-- <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>--}}
        {{-- </ul>--}}
        {{-- <!-- Tab panes -->--}}
        {{-- <div class="tab-content">--}}
        {{-- <!-- Home tab content -->--}}
        {{-- <div class="tab-pane active" id="control-sidebar-home-tab">--}}
        {{-- <h3 class="control-sidebar-heading">Recent Activity</h3>--}}
        {{-- <ul class="control-sidebar-menu">--}}
        {{-- <li>--}}
        {{-- <a href="javascript:;">--}}
        {{-- <i class="menu-icon fa fa-birthday-cake bg-red"></i>--}}

        {{-- <div class="menu-info">--}}
        {{-- <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>--}}

        {{-- <p>Will be 23 on April 24th</p>--}}
        {{-- </div>--}}
        {{-- </a>--}}
        {{-- </li>--}}
        {{-- </ul>--}}
        {{-- <!-- /.control-sidebar-menu -->--}}

        {{-- <h3 class="control-sidebar-heading">Tasks Progress</h3>--}}
        {{-- <ul class="control-sidebar-menu">--}}
        {{-- <li>--}}
        {{-- <a href="javascript:;">--}}
        {{-- <h4 class="control-sidebar-subheading">--}}
        {{-- Custom Template Design--}}
        {{-- <span class="pull-right-container">--}}
        {{-- <span class="label label-danger pull-right">70%</span>--}}
        {{-- </span>--}}
        {{-- </h4>--}}

        {{-- <div class="progress progress-xxs">--}}
        {{-- <div class="progress-bar progress-bar-danger" style="width: 70%"></div>--}}
        {{-- </div>--}}
        {{-- </a>--}}
        {{-- </li>--}}
        {{-- </ul>--}}
        {{-- <!-- /.control-sidebar-menu -->--}}

        {{-- </div>--}}
        {{-- <!-- /.tab-pane -->--}}
        {{-- <!-- Stats tab content -->--}}
        {{-- <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>--}}
        {{-- <!-- /.tab-pane -->--}}
        {{-- <!-- Settings tab content -->--}}
        {{-- <div class="tab-pane" id="control-sidebar-settings-tab">--}}
        {{-- <form method="post">--}}
        {{-- <h3 class="control-sidebar-heading">General Settings</h3>--}}

        {{-- <div class="form-group">--}}
        {{-- <label class="control-sidebar-subheading">--}}
        {{-- Report panel usage--}}
        {{-- <input type="checkbox" class="pull-right" checked>--}}
        {{-- </label>--}}

        {{-- <p>--}}
        {{-- Some information about this general settings option--}}
        {{-- </p>--}}
        {{-- </div>--}}
        {{-- <!-- /.form-group -->--}}
        {{-- </form>--}}
        {{-- </div>--}}
        {{-- <!-- /.tab-pane -->--}}
        {{-- </div>--}}
        {{-- </aside>--}}

        <!-- /.control-sidebar -->

        <!-- Add the sidebar's background. This div must be placed
          immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 3 -->
    <script src="{{ asset('dashboard/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('dashboard/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    {{-- accounting js --}}
    <script src="{{ asset('dashboard/dist/js/accounting.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('dashboard/dist/js/adminlte.min.js') }}"></script>

    {{-- ckeditor --}}
    <script src="{{ asset('dashboard/plugins/ckeditor/ckeditor.js') }}"></script>

    {{-- printThis plugin --}}
    <script src="{{ asset('dashboard/dist/js/printThis.js') }}"></script>
    {{--morris --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{ asset('dashboard/plugins/morris/morris.min.js') }}"></script>
    {{-- custom js --}}
    <script src="{{ asset('dashboard/dist/js/custom/order.js') }}"></script>
    <script src="{{ asset('dashboard/dist/js/custom/image_preview.js') }}"></script>
    {{-- jquery.number --}}
    <script src="{{ asset('dashboard/dist/js/jquery.number.min.js') }}"></script>

    <style>
        .btn-space {
            margin-right: 15px;
        }

    </style>

    <script>
        // Confirm delete
        $(".delete").click(function(e) {
            let that = $(this);
            e.preventDefault();
            let n = new Noty({
                theme: 'metroui'
                , text: "@lang('site.confirm_delete')"
                , layout: 'topCenter'
                , type: "warning"
                , killer: true
                , buttons: [
                    Noty.button("@lang('site.yes') ", 'btn btn-success btn-space m-2', function() {
                        that.closest('form').submit();
                    })

                    , Noty.button("@lang('site.no') ", 'btn btn-danger btn-space m-2', function() {
                        n.close();
                    })
                ]

                //End of button
            });
            n.show();

        }); //End of confirm delete

        // Image preview

        $('.image').change(function() {
            if (this.files && this.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    $('.image-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);
            }
        }); // End Image preview


        // Ckeditor

        // CKEDITOR.editorConfig = function( config ) {
        CKEDITOR.config.language = "{{ app()->getLocale() }}";
        // config.uiColor = '#AADC6E';
        // };

    </script>
    <!---->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">




<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>


<script src="https://cdn.datatables.net/buttons/1.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>



<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/i18n/{{ app()->getLocale() }}.js"></script>



<script type="text/javascript" src="{{  asset('dashboard/plugins/bootstrap-iconpicker/dist/js/bootstrap-iconpicker.bundle.min.js')}}"></script>
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<style>

</style>
<script>


    $(document).ready(function() {
       

        $('#example').DataTable( {
            scrollY:        300,
            scrollX:        true,
            scrollCollapse: true,
            paging:         false,
            fixedColumns:   true,

            dom: 'Bfrtip'
            
            , buttons: [

                {
                    extend: 'print'
                    ,text  : '<i class="fa fa-print" style="font-size:18px;color:blue"></i>'
                    , exportOptions: {
                        columns: ':visible'
                    },

                },
                {
                    extend: 'colvis'
                    ,'text':'<i class="fa fa-eye-slash" style="font-size:18px;color:red"></i>اخفاء عمود'
                    , footer: false
                },
                


            ],




            language: {
                
                url:  "//cdn.datatables.net/plug-ins/1.10.20/i18n/{{ LaravelLocalization::getCurrentLocaleName() }}.json"
            }
        } );


        $('.example').DataTable({
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50,100, -1 ],
                [ '10', '25', '50', '100' ,'عرض الكل' ]
            ]

            , buttons: [

                {
                    extend: 'print'
                    ,text  : '<i class="fa fa-print" style="font-size:18px;color:blue"></i>'
                    , exportOptions: {
                        columns: ':visible'
                    },

                },
                {
                    extend: 'colvis'
                    ,'text':'<i class="fa fa-eye-slash" style="font-size:18px;color:red"></i>{{__('site.ex_colvis')}}'
                    , footer: false
                }, {
                    extend: 'pageLength'
                    , footer: false
                },
                , /*{
                    extend: 'pdf'
                    ,'text' : '<i class="fa fa-file-pdf-o" style="font-size:18px;color:red"></i> {{trans('site.ex_pdf')}}'
                    , footer: true
                }
                , */{
                    extend: 'csv'
                    , 'text' : '<i class="fa fa-file" style="font-size:18px;color:#cc5200"></i> {{trans('site.ex_csv')}}'
                    , footer: false
                }
                , {
                    extend: 'excel'
                    ,'text' : '<i class="fa fa-file-excel-o" style="font-size:18px;color:green"></i> {{ trans('site.ex_excel')}}'
                    , footer: false
                }, {
                    extend: 'copy'
                    ,'text':'<i class="fa fa-copy" style="font-size:18px;color:blue"></i> {{trans('site.ex_copy')}}'
                    , footer: false
                }


            ],




            language: {
                buttons: {
                    pageLength: {
                        _: " عرض %d  صفوف",
                        '-1': "الكل"
                    }
                },
                url:  "//cdn.datatables.net/plug-ins/1.10.20/i18n/{{ LaravelLocalization::getCurrentLocaleName() }}.json"
            }
        });

        $(".js-example-basic-single").select2({
            language: "{{ app()->getLocale() }}",
            dir: ("{{ app()->getLocale() }}"=="ar")? "rtl" : "lte",
        });
        //$.fn.select2.defaults.set('language', 'ar');


        ////iconpicker/////

        // Default options
        $('.fa_icon').iconpicker();

        $('.fa_icon').on('change', function(e) {
            // alert(e.icon);
        });

        
    });


    window.onload = function () { 
       // $("#{{Route::currentRouteName()}}").data("id") ;
    }

</script>


@stack('scripts')
@stack('css')
</body>
</html>
