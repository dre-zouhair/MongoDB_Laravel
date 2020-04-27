<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
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
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto" style="float: right;">
                    <!-- Authentication Links -->
                    @guest

                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="" style="
    font-size: 18px;
    color: black;
">
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('usershow') }}">
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Refunded medicines') }}</div>
                     <div class="card-body" id="pie">
                         <canvas id="myChart"></canvas>
                         <span id="form_output"></span>

                     </div>
                </div>
             </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Density of users by profession') }}</div>
                    <div class="card-body">
                        <canvas id="UsersChart"></canvas>
                        <span id="user_form_output"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>


        $.ajax({
            url:"{{route('chart')}}",
            method: 'get',
            data:{name:"iname"},
            dataType: 'json',
            success:function (response) {
                var ctx = document.getElementById('myChart');
                if(response.data.data.length > 0)
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: response.data.labels,
                            datasets: [{
                                data: response.data.data,

                                backgroundColor: [

                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(255, 99, 132, 0.2)',
                                ],
                                borderColor: [

                                    'rgba(75, 192, 192, 1)',
                                    'rgba(255, 99, 132, 1)',

                                ],
                                borderWidth: 1
                            }]
                        },

                    });
                else {
                    document.getElementById('myChart').remove();
                    document.getElementById('form_output').innerHTML = "<div class='alert alert-danger alert-dismissible show' role='alert'><strong>Ooops No data to display ! : </strong>Insert some medicines</div>";
                }
            },
            error:function (error) {
                console.log(error);
                document.getElementById('myChart').remove();
                document.getElementById('form_output').innerHTML = error.responseJSON.data;
            }
        });

        $.ajax({
            url:"{{route('chartuser')}}",
            method: 'get',
            dataType: 'json',
            success:function (response) {
                console.log(response.data.data);

                var ict_unit = [];
                var efficiency = [];
                var coloR = [];
                var items=   [ "rgba(74,78,77,0.5)" ,"rgba(0,233,170,0.74)" , "rgba(61,164,171,0.8)" ,
                    "rgba(254,138,113,0.94)" , "rgba(254,74,73,0.94)" , "rgba(42,183,202,0.93)" ,"rgba(15,237,118,0.94)" ,
                    "rgb(230,230,234)" , "rgb(208,225,249)" ,"rgba(4,214,72,0.93)" ,
                    "rgba(40,54,85,0.9)","rgba(255,51,119,0.9)" , "rgba(255,85,136,0.89)","rgba(168,230,207,0.91)" ,
                    "rgb(220,237,193)" , "rgba(255,211,182,0.95)" , "rgba(255,170,165,0.93)" , "rgba(255,139,148,0.97)",
                    "rgba(3,245,215,0.91)" , "rgba(39,155,97,0.93)" , "rgba(0,138,184,0.89)" , "rgba(153,51,51,0.8)" ,
                    "rgba(163,228,150,0.87)" , "rgba(149,202,228,0.95)" , "rgba(204,51,51,0.78)" ,"rgba(15,252,195,0.9)" ,
                    "rgba(255,255,122,0.88)" , "rgba(204,102,153,0.91)" ];
                var indice = 0;
                var dynamicColors = function() {


                    var item = items[indice];
                    indice++;
                    return item;
                };
                for (var i in response.data.data) {
                    ict_unit.push("ICT Unit " + response.data.data[i].ict_unit);
                    efficiency.push(response.data.data[i].efficiency);
                    coloR.push(dynamicColors());
                }
                var ctx = document.getElementById('UsersChart').getContext('2d');
                if(response.data.data.length > 0)
                    var UsersChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.data.labels,
                            datasets: [{
                                data: response.data.data,
                                backgroundColor: coloR
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            },legend: { display: false }
                        }
                    });
                else {
                    document.getElementById('UsersChart').remove();
                    document.getElementById('user_form_output').innerHTML = "<div class='alert alert-danger alert-dismissible show' role='alert'><strong>Ooops No data to display ! : </strong>Insert some users</div>";
                }
            },
            error:function (error) {
                console.log(error);
                document.getElementById('UsersChart').remove();
                document.getElementById('form_output').innerHTML = error.responseJSON.data;
            }
        });
    </script>
</body>
</html>
