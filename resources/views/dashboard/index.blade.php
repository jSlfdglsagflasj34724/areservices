@extends('layouts.dashboard')

@section('content')

            <!-- Content header -->
            <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
              <h1 class="text-2xl font-semibold">Dashboard</h1>
            </div>

            <!-- Content -->
            <div class="mt-2">
              <!-- State cards -->
              <div class="grid grid-cols-1 gap-8 p-4 lg:grid-cols-2 xl:grid-cols-4">
                <!-- Value card -->
                <a href="{{ url('jobs') }}">
                  <div class="flex items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                    <div>
                      <h6
                        class="text-xs font-medium leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light"
                      >
                        Open Jobs
                      </h6>
                      <span class="text-xl font-semibold">{{ $openJobs }}</span>
                    </div>
                    <div>
                      <span>
                        <svg
                          class="w-12 h-12 text-gray-300 dark:text-primary-dark"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                          />
                        </svg>
                      </span>
                    </div>
                  </div>
                </a>

                <!-- Users card -->
                <a href="{{ url('expeditedJobs') }}">
                  <div class="flex items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                    <div>
                      <h6
                        class="text-xs font-medium leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light"
                      >
                        Critical Jobs
                      </h6>
                      <span class="text-xl font-semibold">{{ $criticalJobs }}</span>
                    </div>
                    <div>
                      <span>
                        <svg
                          class="w-12 h-12 text-gray-300 dark:text-primary-dark"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                          />
                        </svg>
                      </span>
                    </div>
                  </div>
                </a>

                <!-- Orders card -->
                <a href="{{ url('listCustomer') }}">
                  <div class="flex items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                    <div>
                      <h6
                        class="text-xs font-medium leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light"
                      >
                        Customers
                      </h6>
                      <span class="text-xl font-semibold">{{ $customers }}</span>
                    </div>
                    <div>
                      <span>
                        <svg
                          class="w-12 h-12 text-gray-300 dark:text-primary-dark"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                          />
                        </svg>
                      </span>
                    </div>
                  </div>
                </a>

                <!-- Tickets card -->
                <a href="{{ url('listTechnician') }}">
                  <div class="flex items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                    <div>
                      <h6
                        class="text-xs font-medium leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light"
                      >
                        Technicians
                      </h6>
                      <span class="text-xl font-semibold">{{ $technicians }}</span>
                    </div>
                    <div>
                      <span>
                        <svg
                          class="w-12 h-12 text-gray-300 dark:text-primary-dark"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                          />
                        </svg>
                      </span>
                    </div>
                  </div>
                </div>
                </a>

              <!-- Charts -->
    

              <!-- Two grid columns -->
         
            </div>

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

<div class="p-4">
        <!--Card-->
        <div id='recipients' class="p-4 mt-6 lg:mt-0 rounded shadow bg-white">
            <table id="example" class="custom-table" class="" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead>
                    <tr>
                        <th class="text-sm text-left" data-priority="1">Name</th>
                        <th class="text-sm text-left" data-priority="2">Desrription</th>
                        <th class="text-sm text-left" data-priority="3">Status</th>
                        <th class="text-sm text-left" data-priority="3">Priority Name</th>
                        <th class="text-sm text-left" data-priority="4">Created By</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($jobs as $key => $value)
                    <tr>
                      <td class="text-sm text-left">{{ $value->job_name ?? '' }}</td>
                      <td class="text-sm text-left">{{ $value->job_description ?? ''}}</td>
                      <td class="text-sm text-left">{{$value->status ?? '' }}</td>
                      <td class="text-sm text-left">{{ $value->priority->priority_name ?? '' }}</td>
                      <td class="text-sm text-left">{{ $value->user->name ?? '' }}</td>
                        
                    </tr>
                     @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div style="margin-left: 15px">
      <a href="{{ url('expeditedJobs') }}" class="bg-blue-200 px-4 py-2 rounded hover:bg-gray-300">View All Critical Jobs</a>
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
                    "bPaginate": false,
                    "bFilter": false,
                    "bInfo" : false,
                    responsive: true
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