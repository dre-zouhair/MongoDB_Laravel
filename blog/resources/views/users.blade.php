<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Users List</title>
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
            <a class="navbar-brand" href="{{ url('/home') }}">
                Dashboard
            </a>
            <a class="navbar-brand" href="{{ url('/users') }}">
                Users List
            </a>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Users list') }}
                            <button type="button" name="add" id="add_data" class="btn btn-outline-success btn-sm" style="float: right;font-size: 14px;width: 155px;">Add a user</button>
                    </div>
                    <div class="card-body">
                        <br />
                        <span id="form_output"></span>
                        <table id="User_table" class="table table-bordered" style="width:100%;text-align: center;">
        <thead>
        <tr>
            <th>Name</th>
            <th>cin</th>
            <th>Profession</th>
            <th>email</th>
            <th>Phone number</th>
            <th>Action</th>
        </tr>
        </thead>
    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div id="userModal" class="modal fade" style="  overflow-y:auto;" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="User_form">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>

                <div class="modal-body">
                    {{csrf_field()}}
                    <span id="form_output"></span>
                    <div class="form-group">
                        <label>Enter Name</label>
                        <input type="text" name="name" id="name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter CIN</label>
                        <input type="text" name="cin" id="cin" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter Profession</label>
                        <input type="text" name="profession" id="profession" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter email</label>
                        <input type="text" name="email" id="email" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter Phone number</label>
                        <input type="text" name="phone" id="phone" class="form-control" />
                    </div>
                    <div class="form-group">

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_admin" id="is_admin" value="1">
                            <label class="form-check-label" for="inlineRadio1">administrator</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_admin" id="is_admin" value="0">
                            <label class="form-check-label" for="inlineRadio1">normale user</label>
                        </div>
                        <br>
                        <span id="erroris_admin"  style="color: red" hidden>The prescription field is required.</span>
                    </div>
                    <div class="form-group">
                        <label>Enter Password</label>
                        <input type="password" name="password" id="password" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Confirm password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="id" value="" />
                    <input type="hidden" name="button_action" id="button_action" value="insert" />
                    <input type="submit" name="submit" id="action" value="Add" class="btn btn-outline-success" />
                    <button type="button" id="close" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <div id="deletemodal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>

            </div>
            <div class="modal-body">
                <p>Do you really want to delete this user</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" id="submitedelete">confirm delte</button>
                <button type="button" class="btn btn-outline-primary" id="colsedelete" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#User_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax" : "{{ route('user') }}",
            "columns" : [
                {"data": 'name'},
                {"data": 'cin'},
                {"data": 'profession'},
                {"data": 'email'},
                {"data": 'phone'},
                { "data": "action", orderable:false, searchable: false}
            ]
        });
        $('#add_data').click(function(){
            $('#userModal').removeAttr('class');
            $('#userModal').attr('class','modal show');
            $('#User_form')[0].reset();
            $('#form_output').html('');
            $('#button_action').val('insert');
            $('#action').val('Add');
            $('.modal-title').text('Adding a user');
        });
        $('#User_form').on('submit', function(event){
            event.preventDefault();
            var form_data = $(this).serialize();
            console.log(form_data);
            $.ajax({
                url:"{{ route('userstore') }}",
                method:"POST",
                data:form_data,
                dataType:"json",
                success:function(data)
                {

                        $('#form_output').html(data.success);


                            $('#User_form')[0].reset();
                            $('#action').val('Add');
                            $('.modal-title').text('Adding a user');
                            $('#button_action').val('insert');
                            $('#User_table').DataTable().ajax.reload();
                        $('#userModal').removeAttr('class');
                        $('#userModal').attr('class','modal fade');

                        $('.error').hide();
                         $('#erroris_admin').attr("hidden","hidden");
                },
                error: function (err) { // error callback
                    if(err.status == 500 ){
                        console.log(err);
                    }
                    if (err.status == 422){
                        $.each(err.responseJSON.errors, function (i, error) {

                            if( $('.error').length )$('.error').hide();
                            $('#erroris_admin').attr("hidden","hidden");
                        });
                        $.each(err.responseJSON.errors, function (i, error) {

                            if( $('.error').length )         // use this if you are using id to check
                            {
                                $('.error').hide();

                            }
                        });
                        $.each(err.responseJSON.errors, function (i, error) {
                            if(i === "is_admin" )
                                $('#erroris_admin').removeAttr("hidden");
                            else {
                                var el = $(document).find('[name="' + i + '"]');
                                el.after($('<span class="error" style="color: red;">' + error[0] + '</span>'));
                            }
                        });
                    }

                }
            })
        });
        $(document).on('click', '.delete', function(){
            var id = $(this).attr("id");
            $('#form_output').html('');
            $('#deletemodal').removeAttr('class');
            $('#deletemodal').attr('class','modal show');
            $('.modal-title').text('Deleting a user');
            $(document).on('click', '#submitedelete', function(){
                $('#deletemodal').removeAttr('class');
                $('#deletemodal').attr('class','modal fade');
                $.ajax({
                    url:"{{route('userdestroy')}}",
                    method:'get',
                    data:{id:id},
                    dataType:'json',
                    success:function(data)
                    {
                        $('#User_table').DataTable().ajax.reload();
                        $('#form_output').html(data.success);

                    },
                    error:function (data) {
                        $('#form_output').html(data.error);
                    }
                }); $.ajax({
                    url:"{{route('userdestroy')}}",
                    method:'get',
                    data:{id:id},
                    dataType:'json',
                    success:function(data)
                    {
                        $('#User_table').DataTable().ajax.reload();
                        $('#form_output').html(data.success);

                    },
                    error:function (data) {
                        $('#form_output').html(data.error);
                    }
                });
            });
        });
        $(document).on('click', '#colsedelete', function(){
            $('#deletemodal').removeAttr('class');
            $('#deletemodal').attr('class','modal fade');

        });
        $(document).on('click', '#close', function(){
            $('#User_form')[0].reset();
            $('.error').hide();
            $('#action').val('Add');
            $('.modal-title').text('Add User');
            $('#button_action').val('insert');
            $('#User_table').DataTable().ajax.reload();
            $('#userModal').removeAttr('class');
            $('#userModal').attr('class','modal fade');

        });
    });
</script>
</body>
</html>
