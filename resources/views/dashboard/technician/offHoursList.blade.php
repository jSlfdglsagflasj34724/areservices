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
    <h1 class="text-3xl font-bold">
      Technician (Off Hours)
    </h1>
    <div>
      <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300" onclick="window.location.href = '{{ route('OffHourscreate.create') }}'">Update</button>
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
                        <th class="text-sm text-left" data-priority="1">Name</th>
                        <th class="text-sm text-left" data-priority="2">Start Date</th>
                        <th class="text-sm text-left" data-priority="3">End Date</th>
                        <th class="text-sm text-left" data-priority="3">Phone No</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-sm text-left">{{ $offHours->technician->name ?? '' }}</td>
                        <td class="text-sm text-left">{{ $offHours->start_date ?? '' }}</td>
                        <td class="text-sm text-left">{{ $offHours->end_date ?? '' }}</td>
                        <td class="text-sm text-left">{{ $offHours->technician->phone_no ?? '' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<script>
$(document).ready(function() {

            var table = $('#example').DataTable({
                    responsive: true,
                    "bFilter": false,
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