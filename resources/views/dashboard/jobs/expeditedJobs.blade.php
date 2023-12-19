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
      Expedited Jobs
    </h1>
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
                        <th class="text-sm text-left" data-priority="4">Job Details</th>
                        <th class="text-sm text-left" data-priority="4">Asset Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expeditedJobs as $key => $value)
                    <tr>
                        <td class="text-sm text-left">{{ $value->job_name }}</td>
                        <td class="text-sm text-left">{{ $value->job_description ?? ''}}</td>
                        <td class="text-sm text-left">{{ $value['priority']['priority_name'] ?? ''}}</td>
                        <td class="text-sm text-left">{{ $value['assignedTechnician']['technician']['name'] ?? 'No Technician assigned'}}</td>
                        <td class="text-sm text-left">
                          <div class="flex space-x-3">
                            <a href="jobDetails/{{ $value->id }}" class="bg-[#3b82f6] text-white text-center block w-[32px] flex justify-center items-center h-[32px] rounded">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              </svg>  
                            </a>
                          </div>
                        </td>
                        <td class="text-sm text-left">
                          <div class="flex space-x-3">
                            <a href="asset/{{ $value->id }}" class="bg-[#3b82f6] text-white text-center block w-[32px] flex justify-center items-center h-[32px] rounded">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6" class="w-3 h-3">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                              </svg>
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
        $(document).ready(function() {

            var table = $('#example').DataTable({
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
    </style>
@endsection