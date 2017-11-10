<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <!-- Bootstrap Styles-->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
    
    <!-- FontAwesome Styles-->
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="{{ asset('css/custom-styles.css') }}" rel="stylesheet" />
    
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <!-- <div id="wrapper"> -->
    <!-- <div id="page-wrapper"> -->
            <div id="page-inner">
                @yield('content')
                <!-- /. ROW  -->
                
            </div>
            <!-- /. PAGE INNER  -->
        <!-- </div> -->
        <!-- /. PAGE WRAPPER  -->
    <!-- </div> -->
    <!-- /. WRAPPER  -->
</body>

</html>