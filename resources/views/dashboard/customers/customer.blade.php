@extends('layouts.dashboard')

@section('content')
<!-- <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css"/> -->
<!--Regular Datatables CSS-->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <!--Responsive Extension Datatables CSS-->
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</head>
<section class="is-hero-bar p-6 bg-white">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="text-3xl font-bold">
      Customers
    </h1>
 
    <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300" onclick="window.location.href = '{{ route('customer') }}'">Add Customer</button>
  </div>
</section>

<div class="mx-4">
     @foreach ([ 'success'] as $msg)
      @if(Session::has('alert-' . $msg))

      <p class="self-center p-4 mb-4 font-medium  text-bold text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 flex justify-between alert-success alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}   
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      </p>
    
      @endif
      @endforeach

</div>

<div class="mx-4">
    @foreach ([ 'danger'] as $msg)
     @if(Session::has('alert-' . $msg))

     <p class="self-center p-4 mb-4 font-medium  text-bold text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 red:text-green-400 flex justify-between alert-danger alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}   
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     </p>
   
     @endif
     @endforeach

</div>

<div class="p-4">
        <!--Card-->
        <div id='recipients' class="p-4 mt-6 lg:mt-0 rounded shadow bg-white">
            <table id="example" class="custom-table" class="" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    <tr>
                        <th class="text-sm text-left" data-priority="1">Name</th>
                        <th class="text-sm text-left" data-priority="2">Address</th>
                        <th class="text-sm text-left" data-priority="3">Phone No</th>
                        <th class="text-sm text-left" data-priority="4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $key => $value)
                    <tr>
                        <td class="text-sm text-left">{{ $value->name }}</td>
                        <td class="text-sm text-left">{{ $value->address ?? ''}}</td>
                        <td class="text-sm text-left">+{{$value->country_code['phonecode'] }} {{ $value->phone_no }}</td>
                        <td class="text-sm text-left"><!-- a class="text-blue-600 text-sm" href="editCustomer/{{ $value->id }}">{{ __('Edit Customer') }}</a> -->
                           <div class="flex space-x-3">
                                <a href="editCustomer/{{ $value->id }}" class="bg-[#3b82f6] text-white text-center block w-[32px] flex justify-center items-center h-[32px] rounded">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                      <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                      <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                                </svg>
                            </a>
                            <a href="deleteCustomer/{{$value->user_id}}" onclick="return confirm('Are you sure you want to delete the customer, all the related data will be deleted such as jobs etc ?')" class="bg-red-500 text-white text-center block w-[32px] flex justify-center items-center h-[32px] rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                                </svg>
                            </a>

                              {{-- <input data-id="{{$value->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $value->is_activated ? 'checked' : '' }}> --}}

                           </div>
                    </tr>
                     @endforeach
                </tbody>
            </table>
        </div>
    </div>
<script>
    $(function() {
    $('.toggle-class').change(function() {
        // alert('fdsdfsdf');
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var user_id = $(this).data('id'); 
         
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/changeStatus',
            data: {'status': status, 'user_id': user_id},
            success: function(data){
              console.log(data.success)
            }
        });
    });
  });
        $(document).ready(function() {

            var table = $('#example').DataTable({
                    responsive: true,
                    "bFilter": false
                })
                .columns.adjust()
                .responsive.recalc();
        });


        var alert_del = document.querySelectorAll('.close');
        alert_del.forEach((x) =>
            x.addEventListener('click', function () {
                x.parentElement.classList.add('hidden');
            })
            );


    </script>

    <style type="text/css">
        /* Toggle A */
input:checked ~ .dot {
  transform: translateX(100%);
  background-color: #48bb78;
}

/* Toggle B */
input:checked ~ .dot {
  transform: translateX(100%);
  background-color: #48bb78;
}
.toggle.btn {
    min-width: 59px;
    min-height: 34px;
}
.toggle {
    position: relative;
    overflow: hidden;
}
.btn-danger {
    color: #fff;
    background-color: #d9534f;
    border-color: #d43f3a;
}
.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}

.toggle input[type=checkbox] {
    display: none;
}

input[type=checkbox], input[type=radio] {
    margin: 4px 0 0;
    margin-top: 1px\9;
    line-height: normal;
}
input[type=checkbox], input[type=radio] {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    padding: 0;
}
.toggle.off .toggle-group {
    left: -100%;
}
.toggle-group {
    position: absolute;
    width: 200%;
    top: 0;
    bottom: 0;
    left: 0;
    transition: left .35s;
    -webkit-transition: left .35s;
    -moz-user-select: none;
    -webkit-user-select: none;
}

.toggle-on.btn {
    padding-right: 24px;
}
.toggle-on {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 50%;
    margin: 0;
    border: 0;
    border-radius: 0;
}
.btn-success {
    color: #fff;
    background-color: #5cb85c;
    border-color: #4cae4c;
}

.toggle-off.btn {
    padding-left: 24px;
}
.btn-danger.active, .btn-danger:active, .open>.dropdown-toggle.btn-danger {
    background-image: none;
}
.btn-danger.active, .btn-danger:active, .open>.dropdown-toggle.btn-danger {
    color: #fff;
    background-color: #c9302c;
    border-color: #ac2925;
}
.btn.active, .btn:active {
    background-image: none;
    outline: 0;
    -webkit-box-shadow: inset 0 3px 5px rgba(0,0,0,.125);
    box-shadow: inset 0 3px 5px rgba(0,0,0,.125);
}
.toggle-off {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 50%;
    right: 0;
    margin: 0;
    border: 0;
    border-radius: 0;
}
.btn-danger {
    color: #fff;
    background-color: #d9534f;
    border-color: #d43f3a;
}
.toggle-handle {
    position: relative;
    margin: 0 auto;
    padding-top: 0;
    padding-bottom: 0;
    height: 100%;
    width: 0;
    border-width: 0 1px;
}
.btn-default {
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}

    </style>
@endsection