@extends('layouts.dashboard')

@section('content')
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<section class="is-hero-bar p-6 bg-white">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="text-3xl font-bold">
      Assign Technician
    </h1>
  </div>
</section>

<div class="p-8">
  <div class="card p-8">
    <form method="POST" action="{{url('technician', $job->id)}}"> 
    {{ csrf_field() }}
    <div class="grid grid-cols-2 gap-4">
        <div class="form-group mb-2">
            <select class="w-full bg-white p-3 text-sm border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" name="technician" id="technician">
                <option value="">Please select technician</option>
                @foreach ($technicians as $technician)
                @if (!is_null($job_technician))
                  <option value="{{ $technician['id'] }}" {{ ($technician['id'] == $job_technician['technican_id'] ) ? 'selected' : '' }} >{{ $technician['name'] }}</option>  
                @else
                  <option value="{{ $technician['id'] }}" >{{ $technician['name'] }}</option> 
                @endif
                @endforeach
            </select>
          @error('technician')
            <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>
    
      <div class="form-group mb-2">
        @if (!is_null($job_technician))
          <input type="date" class="@error('date') is-invalid @enderror w-full  p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="date" name="date" placeholder="Enter date" value="{{ $job_technician['date'] }}" > 
        @else
          <input type="date" class="@error('date') is-invalid @enderror w-full  p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="date" name="date" placeholder="Enter date" >
        @endif
        @error('date')
            <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>
    </div>
  
  <button type="submit" class="bg-indigo-700 py-2.5 px-6 rounded text-white hover:bg-indigo-600">Submit</button>
</form>

  </div>
</div>

@endsection