<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Medicines List</title>
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
                 <div class="col-md-12">
                     <div class="card">
                         <div class="card-header">{{ __('Medicines List') }}
                             <button type="button" name="add" id="add_data" class="btn btn-outline-success btn-sm" style="
    float: right;font-size: 14px;width: 155px;">Add a medicine</button>
                         </div>
                         <div class="card-body">
                             <br />
                             <span id="form_output"></span>
                              <table id="medicament_table" class="table table-bordered" style="width:100%;text-align: center;">
                <thead>
                <tr>
                    <th>commercial name</th>
                    <th>active substance</th>
                    <th>price (dh)</th>
                    <th>barre code</th>
                    <th>prescription</th>
                    <th>rss (%)</th>
                    <th>laboratory (desg)</th>
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
    <div id="medicamentModal" style="  overflow-y:auto;" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="medicament_form">
                    <div class="modal-header">

                        <h4 class="modal-title">Add a medicament</h4>
                    </div>

                    <div class="modal-body">
                        {{csrf_field()}}
                        <span id="form_output"></span>
                        <div class="form-group">
                            <label>The commercial name</label>
                            <input type="text" name="commercial_name" id="commercial_name" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label>The active substance</label>
                            <input type="text" name="active_substance" id="active_substance" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label>The price</label>
                            <input type="number" name="price" min="0" id="price" class="form-control" step="0.01" required/>
                        </div>
                        <div class="form-group">
                            <label>The barre code</label>
                            <input type="text" name="barre_code" id="barre_code" class="form-control" required/>
                        </div>

                        <div class="form-group">

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="prescription" id="prescriptionwith" value="with">
                                <label class="form-check-label" for="inlineRadio1">with Prescription</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="prescription" id="prescriptionwithout" value="without">
                                <label class="form-check-label" for="inlineRadio2">without Prescription</label>
                            </div>
                            <br>
                            <span id="errorprscription"  style="color: red" hidden>The prescription field is required.</span>
                        </div>

                        <div class="form-group">
                            <label>RSS</label>
                            <input type="number" name="rss" id="rss" min="0" class="form-control" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label>The Laboratory's Name</label>
                            <input type="text" name="name" id="name" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label>The Laboratory's designation</label>
                            <input type="text" name="designation" id="designation" class="form-control" required/>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id" value="" />
                        <input type="hidden" name="button_action" id="button_action" value="insert" />
                        <input type="submit" name="submit" id="action" value="Add" class="btn btn-outline-success" />
                        <button type="button" class="btn btn-outline-primary" id="close" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="deletemodal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm delete</h5>

                </div>
                <div class="modal-body">
                    <p>Do you really wanna delete.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" id="colsedelete" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-danger" id="submitedelete">confirm delte</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
            $(document).ready(function() {
                $('#medicament_table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax" : "{{ route('medicine') }}",
                    "columns" : [
                        {"data": 'commercial_name'},
                        {"data": 'active_substance'},
                        {"data": 'price'},
                        {"data": 'barre_code'},
                        {"data": 'prescription'},
                        {"data": 'rss'},
                        {"data": 'laboratory'},
                        { "data": "action", orderable:false, searchable: false}
                    ]});
                $('#add_data').click(function(){

                    $('#medicamentModal').removeAttr('class');
                    $('#medicamentModal').attr('class','modal show');
                    $('#medicament_form')[0].reset();
                    $('#form_output').html('');
                    $('#button_action').val('insert');
                    $('#action').val('Add');
                    $('.modal-title').text('Adding a medicament');
                });
                $('#medicament_form').on('submit', function(event){
                    event.preventDefault();
                    var form_data = $(this).serialize();

                    $.ajax({
                        url:"{{ route('medicinetstore') }}",
                        method:"POST",
                        data:form_data,
                        dataType:"json",
                        success:function(data)
                        {
                                $('#form_output').html(data.success);
                                $('#medicament_form')[0].reset();
                                $('#action').val('Add');
                                $('.modal-title').text('Add Medicament');
                                $('#button_action').val('insert');
                                $('#medicament_table').DataTable().ajax.reload();
                                $('#medicamentModal').removeAttr('class');
                                $('#medicamentModal').attr('class','modal fade');;
                                $('.error').hide();
                                $('#errorprscription').attr("hidden","hidden");

                        },
                        error: function (err) { // error callback
                            if(err.status == 500 ){
                                console.log(err);
                            }
                        if (err.status == 422){
                            $.each(err.responseJSON.errors, function (i, error) {

                                    if( $('.error').length )$('.error').hide();
                                    $('#errorprscription').attr("hidden","hidden");
                            });
                            var j = 0;
                            $.each(err.responseJSON.errors, function (i, error) {
                               if(i === "prescription" )
                                   $('#errorprscription').removeAttr("hidden");
                               else{
                                   var el = $(document).find('[name="'+i+'"]');
                                   el.after($('<span class="error" code ="'+i+'" style="color: red;">'+error[0]+'</span>'));
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
                    $(document).on('click', '#submitedelete', function(){

                        $.ajax({
                            url:"{{route('medicinedestroy')}}",
                            method:'get',
                            data:{id:id},
                            dataType:'json',
                            success:function(data)
                            {
                                $('#medicament_table').DataTable().ajax.reload();
                                $('#form_output').html(data.success);
                            },
                            error:function (data) {
                                $('#form_output').html(data.error);
                            }
                        });
                        $('#deletemodal').removeAttr('class');
                        $('#deletemodal').attr('class','modal fade');
                    });
                });
                $(document).on('click', '#colsedelete', function(){
                    $('#deletemodal').removeAttr('class');
                    $('#deletemodal').attr('class','modal fade');

                });
                $(document).on('click', '.edit', function(){
                    var id = $(this).attr("id");
                    $('#form_output').html('');
                    $.ajax({
                        url:"{{route('medicineshow')}}",
                        method:'get',
                        data:{id:id},
                        dataType:'json',
                        success:function(data)
                        {
                            $('#commercial_name').val(data.commercial_name);
                            $('#active_substance').val(data.active_substance);
                            $('#rss').val(data.rss);
                            $('#price').val(data.price);
                            $('#barre_code').val(data.barre_code);
                            if(data.prescription === "without")$('#prescriptionwithout').prop("checked", true);
                            else $('#prescriptionwith').prop("checked", true);
                            $('#active_substance').val(data.active_substance);
                            $('#name').val(data.name);
                            $('#designation').val(data.designation);
                            $('#id').val(id);
                            $('#medicamentModal').removeAttr('class');
                            $('#medicamentModal').attr('class','modal show');
                            $('#action').val('Edit');
                            $('.modal-title').text('Editing a medicine');
                            $('#button_action').val('update');
                        }
                    })
                });
                $(document).on('click', '#close', function(){
                    $('#medicament_form')[0].reset();
                    $('#action').val('Add');
                    $('.error').hide();
                    $('.modal-title').text('Add Mediidicne');
                    $('#button_action').val('insert');
                    $('#medicament_table').DataTable().ajax.reload();
                    $('#medicamentModal').removeAttr('class');
                    $('#medicamentModal').attr('class','modal fade');

                });
            });
    </script>
</body>
</html>
