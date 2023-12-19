@extends('layouts.dashboard')

@section('content')

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<section class="is-hero-bar p-6 bg-white">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="text-3xl font-bold">
      Add Technician
    </h1>
  </div>
</section>
<div class="p-8">
  <div class="card p-8">
        <form method="POST" action="{{url('addTechnician')}}" enctype="multipart/form-data"> 
      {{ csrf_field() }}
      <div class="form-group mb-4">
        <input type="email" class="@error('email') is-invalid @enderror  w-full  p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="email" name="email" placeholder="Email" value="{{old('email')}}" required = "required">
      @error('email')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror
      </div>

      {{-- <div class="form-group mb-4">
        <input type="password" class="w-full  p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="password" name="password" placeholder="Password" value="{{old('password')}}" required = "required">
      </div> --}}

    <div class="form-group mb-4">
      <input type="text" class="@error('name') is-invalid @enderror  w-full  p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="name" name="name" placeholder="Enter Name" value="{{old('name')}}" required = "required">
    @error('name')
      <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>

    <div class="form-group mb-4">
      <select class="w-full bg-white p-3 text-sm border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" name="country_id" id="country_id">
        <option value="">Please choose an option</option>
        @foreach ($countries as $country)  
          <option value="{{ $country['id'] }}" {{ ($country['name'] == 'United States') ? 'selected' : '' }} >{{ $country['name'] }}</option>
        @endforeach
    </select>
      @error('country_id')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>
    
    <div class="form-group mb-4">
      <input type="text" class="@error('phone_no') is-invalid @enderror  w-full  p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="phone_no"  name="phone_no" placeholder="Phone Number" value="{{old('phone_no')}}" required = "required">
    @error('phone_no')
      <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
    @enderror      
    </div>

    <div class="form-group">
      <input type="text" class="@error('address') is-invalid @enderror  w-full  p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="address" name="address" placeholder="1234 Main St" value="{{old('address')}}" required = "required">
    @error('address')
      <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
    @enderror  
    </div>
    
    <div class="mt-4 flex gap-4">
      <button type="submit" class="bg-indigo-700 py-2.5 px-6 rounded text-white hover:bg-indigo-600 ">Submit</button>
      <button type="reset" class="bg-gray-300 py-2.5 px-6 rounded text-dark hover:bg-gray-200 ">Reset</button>
    </div>
  </form>
  </div>
  
</div>
</div>






@endsection