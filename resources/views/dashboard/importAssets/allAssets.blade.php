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
      Assets List
    </h1>
 
    <a href="{{ route('asset.create') }}" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300" >Add Asset</a>
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
          <th class="text-sm text-left" data-priority="1">Brand Name</th>
          <th class="text-sm text-left" data-priority="2">Serial Number</th>
          <th class="text-sm text-left" data-priority="3">Model</th>
          <th class="text-sm text-left" data-priority="3">Year</th>
          <th class="text-sm text-left" data-priority="3">Company Name</th>
          <th class="text-sm text-left" data-priority="4">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($assets as $key => $value)
          <tr>
            <td class="text-sm text-left">{{ $value->brand_name }}</td>
            <td class="text-sm text-left">{{ $value->serial_number ?? ''}}</td>
            <td class="text-sm text-left">{{ $value->model ?? '' }}</td> 
            <td class="text-sm text-left">{{ $value->year ?? '' }}</td>
            <td class="text-sm text-left">{{ $value->company_name ?? '' }}</td>
            <td class="text-sm text-left">
              <div class="flex space-x-3">
                <a href="assetDetails/{{ $value->id }}" class="bg-[#3b82f6] text-white text-center block w-[32px] flex justify-center items-center h-[32px] rounded">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                </a>
                <a href="assetDelete/{{$value->id}}" onclick="return confirm('Are you sure you want to delete the customer?')" class="bg-red-500 text-white text-center block w-[32px] flex justify-center items-center h-[32px] rounded">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                  </svg>
                </a>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<script>
  $(document).ready(function() {
    var table = $('#example').DataTable({
                  responsive: true,
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