<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>{{$title}}</title>
        <!-- Bootstrap -->
        <link href="{{url('css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{url('css/main.css')}}" rel="stylesheet">
        @yield('css')
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{route('dashboard')}}">Pathology Lab</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a  href="{{route('dashboard')}}">Reports <span class="sr-only">(current)</span></a></li>
                        <li><a  href="{{route('patient.index')}}">Patients</a></li>
                    </ul>
                    <form class="navbar-form navbar-right" role="search" method="get" action="{{route('logout')}}">
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a>Welcome Operator</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        @yield('content')

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{url('js/jquery.min.js')}}"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="{{url('js/bootstrap.min.js')}}"></script>
        <script>
            $(document).ready(function(){
                $(".delete").click(function(e){
                    e.preventDefault();
                    response =  confirm("Are you sure you rreally want to delete");
                    console.log(response);
                    if(response == false){
                        return false;
                    }
                    else{
                        $(this).parent().submit();
                    }
                });
            })
        </script>
        @yield('javascript')
    </body>
</html>
