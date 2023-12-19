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
      Technician
    </h1>
    <div>
      <label class="font-semibold mr-2" for="">Status</label>
      <select class="p-2 rounded-md border" name="" id="myFancyDropdown" onchange="sendRequest()"
      class="border-2 border-gray-300 rounded-lg w-48">
        <option value="active" {{ $status == 1 ? 'selected' : '' }}  >Active</option>
        <option value="in-active" {{ $status == 0 ? 'selected' : '' }} >In-Active</option>
      </select>
      <button class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300" onclick="window.location.href = '{{ route('technician') }}'">Add Technician</button>
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
                        <th class="text-sm text-left" data-priority="2">Address</th>
                        <th class="text-sm text-left" data-priority="3">Phone No</th>
                        <th class="text-sm text-left" data-priority="3">Status</th>
                        <th class="text-sm text-left" data-priority="4">Action</th>
                    </tr>
                </thead>
                <tbody>
                  
                    @foreach ($technician as $key => $value)
                    <tr>
                        <td class="text-sm text-left">{{ $value->name }}</td>
                        <td class="text-sm text-left">{{ $value->address ?? ''}}</td>
                        <td class="text-sm text-left">+{{$value->country_code['phonecode'] }} {{$value->phone_no}}</td>
                        <td class="text-sm text-left"><input id="status" data-id="{{ $value->usersData->id }}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-offHours="{{ $value->offHours ? $value->offHours->id : ''  }}" data-off="InActive" {{ $value->usersData->status ? 'checked' : '' }}></td>
                        <td class="text-sm text-left"><!-- a class="text-blue-600 text-sm" href="editCustomer/{{ $value->id }}">{{ __('Edit Customer') }}</a> -->
                           <div class="flex space-x-3">
                                <a href="editTechnician/{{ $value->id }}" class="bg-[#3b82f6] text-white text-center block w-[32px] flex justify-center items-center h-[32px] rounded">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                      <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                      <path d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z" />
                                </svg>
                            </a>
                            {{-- <a href="deleteTechnician/{{$value->user_id}}" onclick="return confirm('Are you sure you want to delete the technician?')" class="bg-red-500 text-white text-center block w-[32px] flex justify-center items-center h-[32px] rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                                </svg>
                            </a> --}}

                              <!--  <label for="toogleA" class="flex items-center cursor-pointer">
                     
                                    <div class="relative">
                              
                                      <input id="toogleA" type="checkbox" class="sr-only" />
                                
                                      <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
                                      
                                      <div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
                                    </div>
                                    
                                </label> -->
                           </div>
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
                    "bFilter": false
                })
                // .columns.adjust()
                // .responsive.recalc();

                  
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var user_id = $(this).data('id');
        let div1 = document.getElementById('status')  ;
        let offHours = div1.getAttribute('data-offHours') 
        
        console.log(offHours)
        let response
        if (offHours !== '') {
          response = confirm('This technican is working as off hours technican are you sure you want to make it in-active?')
        } else {
          response = confirm('Are you sure you want to change the status?')
        }
        
        if (response) {
          $.ajax({
              type: "GET",
              dataType: "json",
              url: '/changeStatus',
              data: {'status': status, 'user_id': user_id},
              success: function(data){
                alert('Status change successfully')
                setTimeout(function(){
                  window.location.reload();
                }, 1000);
              }, error: function(errors){
                alert('Something went wrong!')
              }
          });
        }
        setTimeout(function(){
                  window.location.reload();
                }, 1000);
    })
  });
  function sendRequest() {
          let elmSelect = document.getElementById('myFancyDropdown').value;
          
          let url = new URL(window.location.href);
          url.searchParams.set('status', elmSelect);
          window.location.href = url;
      }


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