<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="{{asset('assets/dist/img/favicon.png')}}?{{ time() }}" type="image/x-icon" />
    <title>{{ config('app.name', 'Laravel') }} | {{ $menu }}</title>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content = "28800; url={{ route('login') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/iCheck/flat/blue.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/iCheck/all.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/custom.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/ladda/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/comboTree/comboTreeStyle.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.min.css">
    <link href="https://cdn.syncfusion.com/ej2/material.css" rel="stylesheet">

    <link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <style>
        .label-info{background-color:#5bc0de;padding:2px}
        .bootstrap-tagsinput{width:100%;display:block;width:100%;height:calc(2.25rem + 2px);padding:.375rem .75rem;font-size:1rem;font-weight:400;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;box-shadow:inset 0 0 0 transparent;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out}
        .candidate,.job-title{cursor:pointer}
        a.disabled{pointer-events:none;cursor:default}
        .disabled{color:#c5c5c5!important}
        [type="radio"]:checked,[type="radio"]:not(:checked){position:absolute;left:-9999px}
        [type="radio"]:checked + label,[type="radio"]:not(:checked) + label{position:relative;padding-left:28px;cursor:pointer;line-height:20px;display:inline-block}
        [type="radio"]:checked + label:before{content:'';position:absolute;left:0;top:0;width:20px;height:20px;border:4px solid #1ABC9C;border-radius:100%;background:#fff}
        [type="radio"]:not(:checked) + label:before{content:'';position:absolute;left:0;top:0;width:20px;height:20px;border:4px solid #ddd;border-radius:100%;background:#fff}
        [type="radio"]:checked + label:after,[type="radio"]:not(:checked) + label:after{content:'';width:6px;height:6px;background:#1ABC9C;position:absolute;top:7px;left:7px;border-radius:100%;-webkit-transition:all .2s ease;transition:all .2s ease}
        [type="radio"]:not(:checked) + label:after{opacity:0;-webkit-transform:scale(0);transform:scale(0)}
        [type="radio"]:checked + label:after{opacity:1;-webkit-transform:scale(1);transform:scale(1)}
        .border-warning-10{border:10px solid #ffc107!important}
        .border-width-5{border:5px solid!important}
        .border-color-info{color:#B266B3!important}
        .border-color-warning{color:#ffc107!important}
        .border-top{border-top:1px solid #050505!important}
        .border-right{border-right:1px solid #050505!important}
        .border-bottom{border-bottom:1px solid #050505!important}
        .border-left{border-left:1px solid #050505!important}
        .color-group{background-color:#E7FFF9}
        #overlay{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);display:flex;justify-content:center;align-items:center;z-index:1000}
        #spinner{border:10px solid #f3f3f3;border-top:10px solid #0b0b0c;border-radius:50%;width:100px;height:100px;animation:spin 1s linear infinite}
        @keyframes spin {
        0%{transform:rotate(0deg)}
        100%{transform:rotate(360deg)}
        }
    </style>
</head>
<body class="hold-transition sidebar-mini sidebar-collapse" id="bodyid">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('admin/dashboard') }}" class="nav-link">Home</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span><i class="fa fa-user mr-2"></i>{{ ucfirst(Auth::guard('admin')->user()->name) }} ({{ucfirst(Auth::guard('admin')->user()->role)}})</span>
            </li>
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4" id="left-menubar" style="height: 100%; min-height:0!important; overflow-x: hidden;">
        <a href="{{url('/admin')}}" class="brand-link" style="text-align: center">
            <span class="brand-text font-weight-light"><b>{{ config('app.name', 'Laravel') }} Admin</b></span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview @if(isset($menu) && $menu=='User') menu-open  @endif" style="border-bottom: 1px solid #4f5962; margin-bottom: 4.5%;">

                        <a href="#" class="nav-link @if(isset($menu) && $menu=='User') active  @endif">
                            <img src=" {{url('assets/dist/img/AdminLTELogo.png')}}" class="img-circle elevation-2" alt="User Image" style="width: 2.1rem; margin-right: 1.5%;">
                            <p style="padding-right: 6.5%;">
                                {{ ucfirst(Auth::guard('admin')->user()->name) }}
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <?php $eid = \Illuminate\Support\Facades\Auth::guard('admin')->user()->id; ?>
                                <a href="{{ route('profile_update.edit',['profile_update'=>$eid]) }}" class="nav-link @if(isset($menu) && $menu=='User') active @endif">
                                    <i class="nav-icon fa fa-pencil-alt"></i> <p class="text-warning">Edit Profile</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link">
                                    <i class="nav-icon fa fa-sign-out-alt"></i> <p class="text-danger">Log out</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link @if($menu=='Dashboard') active @endif">
                            <i class="nav-icon fa fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link @if($menu=='Admin User') active @endif">
                            <i class="nav-icon fa fa-users"></i>
                            <p>Manage Admin Users</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('category.index') }}" class="nav-link @if($menu=='Category') active @endif">
                            <i class="nav-icon fa fa-sitemap"></i>
                            <p>Manage Category</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('sub_category.index') }}" class="nav-link @if($menu=='Sub Category') active @endif">
                            <i class="nav-icon fa fa-sitemap"></i>
                            <p>Manage Sub Category</p>
                        </a>
                    </li>

                    @php
                        $menuCondition = isset($menu) && in_array($menu, ['Listings', 'Listings Import']);
                        $mainMenuClasses = $menuCondition ? 'menu-is-opening menu-open' : '';
                        $subMenuClasses = $menuCondition ? 'active' : '';
                        $displayStyle = $menuCondition ? 'block' : 'none';
                    @endphp

                    <li class="nav-item {{$mainMenuClasses}}">
                        <a href="#" class="nav-link {{$subMenuClasses}}">
                            <i class="nav-icon fas fa-th-list"></i>
                            <p>
                                Manage Listings
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: {{$displayStyle}}">

                            <li class="nav-item">
                                <a href="{{ route('listings.index') }}" class="nav-link @if(isset($menu) && $menu=='Listings') active @endif">
                                    <i class="nav-icon fa fa-list"></i>
                                    <p>Listings</p>
                                </a>
                            </li>

                            <!-- <li class="nav-item">
                                <a href="{{ route('listings.import.listing') }}" class="nav-link @if(isset($menu) && $menu=='Listings Import') active @endif">
                                    <i class="fa fa-upload nav-icon"></i>
                                    <p>Import</p>
                                </a>
                            </li> -->

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('contactus.index') }}" class="nav-link @if(isset($menu) && $menu=='Contact Us') active @endif">
                            <i class="nav-icon fa fa-envelope"></i>
                            <p>Contact Us</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('list-your-business.index') }}" class="nav-link @if(isset($menu) && $menu=='List Your Business') active @endif">
                            <i class="nav-icon fa fa-building"></i>
                            <p>List Your Business</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('emergencies-update.edit',['emergencies_update'=>1]) }}" class="nav-link @if(isset($menu) && $menu=='Emergencies') active @endif">
                            <i class="nav-icon fa fa-exclamation-circle"></i>
                            <p>Emergencies</p>
                        </a>
                    </li>                    
                </ul>
            </nav>
        </div>
    </aside>

    @yield('content')

    <footer class="main-footer">
        <strong>{{ config('app.name', 'Laravel') }} Admin</strong>
    </footer>
</div>
<script src="{{ URL('assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ URL('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{ URL('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ URL('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ URL('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ URL('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ URL('assets/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{ URL('assets/plugins/sparklines/sparkline.js')}}"></script>
<script src="{{ URL('assets/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<script src="{{ URL('assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{ URL('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{ URL('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{ URL('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="{{ URL('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<script src="{{ URL('assets/dist/js/adminlte.js')}}"></script>
<script src="{{ URL('assets/dist/js/demo.js')}}"></script>
<!-- <script src="{{ URL('assets/dist/js/pages/dashboard.js')}}"></script> -->
<script src="{{ URL('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ URL('assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ URL('assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/iCheck/icheck.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="{{ URL::asset('assets/plugins/ladda/spin.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/ladda/ladda.min.js')}}"></script>
<script src="{{ URL('assets/dist/js/jquery.validate.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/jSignature/libs/jSignature.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/jSignature/libs/modernizr.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/comboTree/comboTreePlugin.js')}}"></script>
<script src="{{ URL::asset('assets/dist/admin/js/table-actions.js?time='.time())}}"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

<script>Ladda.bind( 'input[type=submit]' );</script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        $('.select2').select2();
        $('#example2').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "dom": '<"top"i>rt<"bottom"flp><"clear">'
        });

        /*Datepicker*/
        $('.datepicker').datepicker({
            format: 'yyyy-m-d',
            autoclose: true,
        });

        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        });
    });
</script>

<script src="{{ URL::asset('assets/plugins/summernote/summernote.js') }}"></script>

<script type="text/javascript">
    /*DISPLAY IMAGE*/
    function AjaxUploadImage(obj,id){
        var file = obj.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))
        {
            $('#previewing'+URL).attr('src', 'noimage.png');
            alert("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
            return false;
        } else{
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(obj.files[0]);
        }

        function imageIsLoaded(e){
            $('#DisplayImage').css("display", "block");
            $('#DisplayImage').css("margin-top", "1.5%");
            $('#DisplayImage').attr('src', e.target.result);
            $('#DisplayImage').attr('width', '150');
        }
    }

    /*REORDER CODE*/
    function slideout() {
        setTimeout(function() {
            $("#responce").slideUp("slow", function() {});
        }, 3000);
    }
    $("#responce").hide();

    $( function() {
        $('#filterDiv').hide();
        $( "#sortable" ).sortable({opacity: 0.9, cursor: 'move', update: function() {
                var order = $(this).sortable("serialize") + '&update=update';
                var reorder_url = $(this).attr("url");
                $.get(reorder_url, order, function(theResponse) {
                    $("#responce").html(theResponse);
                    $("#responce").slideDown('slow');
                    slideout();
                });
            }});
        $( "#sortable" ).disableSelection();

        /*SUMMER NOTE CODE*/
        $(".description").each(function() {
            var textarea = $(this);
            textarea.summernote({
                height: 250,
                placeholder: textarea.attr('placeholder'),
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize', 'height']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table','picture','link','map','minidiag']],
                    ['misc', ['codeview']],
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        for (var i = 0; i < files.length; i++)
                            upload_image(files[i], this);
                    }
                },
                onInit: function() {
                    var placeholderText = textarea.attr('placeholder');
                    placeholderText = placeholderText.replace(/\n/g, "<br>");
                    textarea.summernote('option', 'placeholder', placeholderText);
                },
                onChange: function(contents) {
                    if (contents.trim() === '') {
                        var placeholderText = textarea.attr('placeholder');
                        placeholderText = placeholderText.replace(/\n/g, "<br>");
                        textarea.summernote('option', 'placeholder', placeholderText);
                    }
                }
            });
        });

        function upload_image(file, el) {
            var form_data = new FormData();
            form_data.append('image', file);
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                data: form_data,
                url: '{{url('admin/image/upload')}}',
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
                success: function(img){
                    $(el).summernote('editor.insertImage', img);
                }
            });
        }
    });
</script>
@yield('jquery')
</body>
</html>
