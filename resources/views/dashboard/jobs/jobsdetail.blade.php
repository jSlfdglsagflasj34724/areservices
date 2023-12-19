@extends('layouts.dashboard')

@section('content')
<!-- <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css"/> -->
<!--Regular Datatables CSS-->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <!--Responsive Extension Datatables CSS-->
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>

<section class="is-hero-bar p-6 bg-white">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="text-3xl font-bold mb-3">
      Jobs Details
    </h1>
    <div>
      <label class="font-semibold mr-2" for="">Status</label>
      <select class="p-2 rounded-md border" name="" id="myFancyDropdown" onchange="sendRequest()"
      class="border-2 border-gray-300 rounded-lg w-48">
        <option value="open" {{ ($status == 'open' ? 'selected' : '') }} >OPEN</option>
        <option value="reschedule" {{ ($status == 'reschedule' ? 'selected' : '') }} >RESCHEDULE</option>
        <option value="scheduled" {{ ($status == 'scheduled' ? 'selected' : '') }} >SCHEDULE</option>
        <option value="in-progress" {{ ($status == 'in-progress' ? 'selected' : '') }} >INPROGRESS</option>
        <option value="completed" {{ ($status == 'completed' ? 'selected' : '') }} >COMPLETED</option>
        <option value="cancelled" {{ ($status == 'cancelled' ? 'selected' : '') }} >CANCELLED</option>
      </select>
        <button style="background: #ff0000c7;" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300" onclick="window.location.href = '{{ route('expeditedJobs.index') }}'">Expedited Jobs</button>
    </div>
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
                        <th class="text-sm text-left" data-priority="1">Job Name</th>
                        <th class="text-sm text-left" data-priority="2">Job Description</th>
                        <th class="text-sm text-left" data-priority="3">Priority Name</th>
                        <th class="text-sm text-left" data-priority="4">Assigned Technician</th>
                        <th class="text-sm text-left" data-priority="4">Company Name</th>
                        <th class="text-sm text-left" data-priority="4">Asset Type</th>
                        <th class="text-sm text-left" data-priority="4">Created Date</th>
                        <th class="text-sm text-left" data-priority="4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobsdetail as $key => $value)
                    <tr>
                        <td class="text-sm text-left">
                          <a href="jobDetails/{{ $value->id }}" class="text-blue-500 hover:underline">
                            {{ $value->job_name }}</td>
                          </a>
                        <td class="text-sm text-left">{{ $value->job_description ?? ''}}</td>
                        <td class="text-sm text-left">{{ $value['priority']['priority_name'] ?? ''}}</td>
                        <td class="text-sm text-left">{{ $value['assignedTechnician']['technician']['name'] ?? 'No Technician assigned'}}</td>
                        <td class="text-sm text-left">{{ $value['assets'][0]['company_name'] ?? ''}}</td>
                        <td class="text-sm text-left">{{ $value['assets'][0]['assetType']['name'] ?? ''}}</td>
                        <td class="text-sm text-left">{{ $value->created_at->toDateString() }}</td>
                        <td class="text-sm text-left">
                          <div class="flex space-x-3">                            
                            <a href="asset/{{ $value->id }}" class="text-blue-500 hover:underline">
                              View Asset
                            </a>
                          </div>
                        </td>
          </div>
                    </tr>
                     @endforeach
                </tbody>
            </table>
        </div>

<script>
        function sendRequest() {
            let elmSelect = document.getElementById('myFancyDropdown').value;
    
            let url = new URL(window.location.href);
            url.searchParams.set('status', elmSelect);
            window.location.href = url;
        }
    </script>
<script>
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
    </style>
@endsection