<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">

            @guest
                <a class="navbar-brand" href="{{ url('/') }}">
                    Search
                </a>
            @else
                <a class="navbar-brand" href="{{ url('/') }}">
                    Search
                </a>
                @if(\Illuminate\Support\Facades\Auth::user()->is_admin == 1)
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        Dashboard
                    </a>
                <a class="navbar-brand" href="{{ url('/users') }}">
                    Users List
                </a>
                @endif
                <a class="navbar-brand" href="{{ url('/medicines') }}">
                    Medicines List
                </a>
            @endguest
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto" style="float: right;">
                    <!-- Authentication Links -->
                    @guest
                        <a class="navbar-brand" href="{{ route('login') }}">
                            {{ __('Login') }}
                        </a>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link navbar-brand dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item " href="{{ route('usershow') }}">
                                    {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        <br />
                        <span id="form_output"></span>
                        <table id="medicament_table" class="table table-bordered table-hover" style="width:100%;text-align: center;">
                            <thead >
                            <tr>
                                <th>commercial name</th>
                                <th>active substance</th>
                                <th>price (dh)</th>
                                <th>barre code</th>
                                <th>prescription</th>
                                <th>rss (%)</th>
                                <th>laboratory (desg)</th>

                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#medicament_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax" : "{{ route('getMedicines') }}",
            "columns" : [
                {"data": 'commercial_name'},
                {"data": 'active_substance'},
                {"data": 'price'},
                {"data": 'barre_code'},
                {"data": 'prescription'},
                {"data": 'rss'},
                {"data": 'laboratory'},

            ],
            "createdRow": function( row, data, dataIndex){
                if( data.rss > 0)
                   $(row).attr("class", "table-success");
                else  $(row).attr("class", "table-danger");
        }});

    });
</script>


</body>
</html>
