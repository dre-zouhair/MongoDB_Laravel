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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>


                        <div class="card-body">
                            <span id="form_output"></span>

                            <form method="post" id="user_profile" >
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control " name="name" value="{{$user->name }}" required autocomplete="name" autofocus readonly>


                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cin" class="col-md-4 col-form-label text-md-right">{{ __('cin') }}</label>

                                    <div class="col-md-6">
                                        <input id="cin" type="text" class="form-control" name="cin" value="{{$user->cin }}" required autocomplete="cin" autofocus readonly>


                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Profession') }}</label>

                                    <div class="col-md-6">
                                        <input id="profession" type="text" class="form-control " name="profession" value=" {{$user->profession }}" readonly required autocomplete="profession" autofocus>


                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('phone') }}</label>

                                    <div class="col-md-6">
                                        <input id="phone" type="phone" class="form-control " name="phone" value="{{$user->phone}}" required readonly autocomplete="new-phone">


                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <input type="button" id="edit" name="action" value=" {{ __('Modify') }}" class="btn btn-outline-secondary edit">
                                        <input type="button" id="changepassword" name="action" value=" {{ __('Change password') }}" class="btn btn btn-outline-secondary edit">
                                        <input type="button" id="changemail" name="action" value=" {{ __('Change Email') }}" class="btn btn-outline-secondary edit">
                                        <input name="button_action" value="update" hidden>
                                        <button id="save" type="submit" class="btn btn-outline-success" hidden name="button_action" value="update" >Save changes</button>
                                        <button id="close" class="btn btn-outline-primary " hidden>close</button>

                                    </div>
                                </div>
                            </form>
                        </div>

                </div>
            </div>
        </div>

    </div>
    <div id="passwordModal" class="modal fade" style="  overflow-y:auto;" role="dialog">
        <div class="modal-dialog" style="max-width: 550px;">
            <div class="modal-content">
                <form method="POST" action="{{ route('register') }}" id="password_form">
                    <div class="modal-header">

                        <h4 class="modal-title">Changing your password</h4>
                    </div>
                    <div class="modal-body">
                        {{csrf_field()}}
                        <span id="form_output"></span>

                            @csrf
                            <div class="form-group row">
                                <label for="oldpassword" class="col-md-4 col-form-label text-md-right">{{ __('Old Password') }}</label>

                                <div class="col-md-7">
                                    <input id="oldpassword" type="password" class="form-control " name="oldpassword" value="{{ old('oldpassword') }}" required autocomplete="oldpassword" autofocus>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                                <div class="col-md-7">
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm New  Password') }}</label>

                                <div class="col-md-7">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="button_action" id="actionpassword" value="update" class="btn btn-outline-success" >Update password</button>
                        <button type="button" id="closepassword" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="emailModal" class="modal fade" style="  overflow-y:auto;" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('register') }}" id="email_form">
                    <div class="modal-header">

                        <h4 class="modal-title">Change your email address</h4>
                    </div>
                    <div class="modal-body">
                        {{csrf_field()}}
                        <span id="form_output"></span>

                        @csrf
                        <div class="form-group row">
                            <label for="oldemail" class="col-md-4 col-form-label text-md-right">{{ __('Old email') }}</label>

                            <div class="col-md-7">
                                <input id="oldemail" type="email" class="form-control " name="oldemail" value="{{ old('oldemail') }}" required autocomplete="oldemail" autofocus>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('New email') }}</label>

                            <div class="col-md-7">
                                <input id="email" type="email" class="form-control " name="email" required autocomplete="new-email">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm New  email') }}</label>

                            <div class="col-md-7">
                                <input id="email-confirm" type="email" class="form-control" name="email_confirmation" required autocomplete="new-email">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="button_action" id="actionemail" value="update" class="btn btn-outline-success" >Update email</button>
                        <button type="button" id="closeemail" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
    $(document).on('click', '#edit', function(event){
        var id = $(this).attr("id");
        event.preventDefault();
        $('#form_output').html('');
        $('#name').removeAttr("readonly");
        $('#profession').removeAttr("readonly");
        $('#email').removeAttr("readonly");
        $('#cin').removeAttr("readonly");
        $('#phone').removeAttr("readonly");
        $('#id').val(id);
        $('#edit').hide();
        $('#changepassword').hide();
        $('#changemail').hide();
        $('#save').removeAttr("hidden");
        $('#close').removeAttr("hidden");
        $('.modal-title').text('Edit Data');
    });
    $(document).on('click', '#save', function(event){
        var id = $(this).attr("id");
        event.preventDefault();
        $('#form_output').html('');
        $('#id').val(id);

        var form_data = $('#user_profile').serialize();
        var d = $('#user_profile').serializeArray();
        $.ajax({
            url:"{{ route('userstore') }}",
            method:"POST",
            data:form_data,
            dataType:"json",
            success:function(data)
            {
                $.each(d, function (i, error) {
                    var id_ = "#error"+error.name;
                    $(id_).hide();

                });
                 $('#form_output').html(data.success);
                $('#name').attr("readonly","readonly");
                $('#profession').attr("readonly","readonly");
                $('#email').attr("readonly","readonly");
                $('#cin').attr("readonly","readonly");
                $('#phone').attr("readonly","readonly");
                $('#edit').show();
                $('#changepassword').show();
                $('#changemail').show();
                $('#save').attr("hidden","hidden");
                $('#close').attr("hidden","hidden");

            },
            error: function (err) { // error callback
                if (err.status == 422){
                    $.each(d, function (i, error) {
                    var id_ = "#error"+error.name;
                    $(id_).hide();

                    });
                    $.each(err.responseJSON.errors, function (i, error) {

                        var el = $(document).find('[name="'+i+'"]');
                        el.after($('<span id="error'+i+'"  style="color: red;">'+error[0]+'</span>'));

                    });
                }
            }
        })
    });
    $(document).on('click', '#close', function(event){

        event.preventDefault();
        $('#form_output').html('');
        var d = $('#user_profile').serializeArray();
        $.each(d, function (i, error) {
            var id_ = "#error"+error.name;
            $(id_).hide();
            console.log(id_);
        });
        $('#user_profile').trigger("reset");
        $('#name').attr("readonly","readonly");
        $('#profession').attr("readonly","readonly");

        $('#cin').attr("readonly","readonly");
        $('#phone').attr("readonly","readonly");
        $('#edit').show();
        $('#changepassword').show();
        $('#changemail').show();
        $('#save').attr("hidden","hidden");
        $('#close').attr("hidden","hidden");


    });
    $(document).on('click', '#changepassword', function(event){
        $('#passwordModal').removeAttr('class');
        $('#passwordModal').attr('class','modal show');
    });
    $(document).on('click', '#changemail', function(event){
        $('#emailModal').removeAttr('class');
        $('#emailModal').attr('class','modal show');
    });
    $(document).on('click', '#closepassword', function(){

        $('#passwordModal').removeAttr('class');
        $('#passwordModal').attr('class','modal fade');
        $('#password_form').trigger("reset");
    });
    $(document).on('click', '#closeemail', function(){
        $('#emailModal').removeAttr('class');
        $('#emailModal').attr('class','modal fade');
        $('#email_form').trigger("reset");
    });
    $('#password_form').on('submit', function(event){
        event.preventDefault();
        console.log( $( this ).serializeArray())
        var form_data = $(this).serialize();
        $.ajax({
            url:"{{ route('changepassword') }}",//chngepassword
            method:"POST",
            data:form_data,
            dataType:"json",
            success:function(data)
            {
                $('#passwordModal').removeAttr('class');
                $('#passwordModal').attr('class','modal fade');
                $('#passwor_form').trigger("reset");
                $('#form_output').html(data.data);
                setTimeout(function() {
                    window.location.reload();
                }, 5000);
            },
            error: function (err) { // error callback
                console.log(err.responseJSON);
                if (err.status == 422){
                    $.each(err.responseJSON.errors, function (i, error) {

                        if( $('.error').length )         // use this if you are using id to check
                        {
                            $('.error').hide();

                        }


                    });
                    $.each(err.responseJSON.errors, function (i, error) {

                        var el = $(document).find('[name="'+i+'"]');
                        el.after($('<span class="error" style="color: red;">'+error+'</span>'));

                    });
                }
            }
        })
    });
    $('#email_form').on('submit', function(event){
        event.preventDefault();
        console.log( $( this ).serializeArray())
        var form_data = $(this).serialize();
        $.ajax({
            url:"{{ route('changemail') }}",//chngeemail
            method:"POST",
            data:form_data,
            dataType:"json",
            success:function(data)
            {

                $('#emailModal').removeAttr('class');
                $('#emailModal').attr('class','modal fade');
                $('#email_form').trigger("reset");
                $('#form_output').html(data.data);
                setTimeout(function() {
                    window.location.reload();
                }, 100);
            },
            error: function (err) { // error callback
                console.log(err.responseJSON);
                if (err.status == 422){
                    $.each(err.responseJSON.errors, function (i, error) {

                        if( $('.error').length )         // use this if you are using id to check
                        {
                            $('.error').hide();

                        }
                    });
                    $.each(err.responseJSON.errors, function (i, error) {

                        var el = $(document).find('[name="'+i+'"]');
                        el.after($('<span class="error" style="color: red;">'+error+'</span>'));

                    });
                }
            }
        })
    });
</script>
</div>
</body>
</html>
