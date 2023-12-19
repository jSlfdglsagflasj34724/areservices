@extends('layouts.dashboard')

@section('content')
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<section class="is-hero-bar p-6 bg-white">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="text-3xl font-bold">
      Technician Off Hours
    </h1>
  </div>
</section>

<div class="p-8">
  <div class="card p-8" bg-white>
    <form method="POST" action="{{url('offHoursStore')}}" >
    {{ csrf_field() }}
    <div class="grid grid-cols-2 gap-4">
        <div class="form-group mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-3" for="name">
              Technician Name
          </label>
          <select class="w-full bg-white p-3 text-sm border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" name="name" id="name">
            <option value="">Please choose an option</option>
            @foreach ($technicians as $technician)
              <option value="{{ $technician->technician->id }}" {{ ($technician->technician->id == ($offHours->technican_id ?? '')) ? 'selected' : '' }} >{{ $technician->name }}</option>
            @endforeach
        </select>
        @error('name')
            <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>
    
      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="start_date">
            Start Date
        </label>
            <input type="date" class="@error('start_date') is-invalid @enderror w-full  p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="start_date" name="start_date" placeholder="Enter Start date" min={{ now() }} value="{{ $offHours->start_date ?? '' }}">
        @error('start_date')
            <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>
    
      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="end_date">
            End Date
        </label>
            <input type="date" class="@error('end_date') is-invalid @enderror w-full  p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="end_date" name="end_date" placeholder="Enter End date" min={{ now() }} value="{{ $offHours->end_date ?? '' }}">
        @error('end_date')
            <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="phone_number">
            Phone Number
        </label>
        <input type="text" class="@error('phone_number') is-invalid @enderror w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="phone_no"  name="phone_no" placeholder="Phone Number" value="{{ $offHours->technician->phone_no ?? '' }}" >
        @error('phone_no')
            <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <button type="submit" class="bg-indigo-700 py-2.5 px-6 rounded text-white hover:bg-indigo-600">Submit</button>

</form>

  </div>
</div>

@endsection