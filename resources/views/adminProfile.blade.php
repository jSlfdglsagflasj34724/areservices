@extends('layouts.dashboard')
{{-- @dd($admin); --}}
@section('content')

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<section class="is-hero-bar p-6 bg-white">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="text-3xl font-bold">
      Admin Profile
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

<div class="p-8">
  <div class="card p-8">
        <form method="POST" action="{{url('profile')}}"> 
      {{ csrf_field() }}
      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="name">
          Name
        </label>
        <input type="text" class="@error('name') is-invalid @enderror w-full  p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="name" name="name" placeholder="Name" value="{{ $admin->name }}" required="required">
      @error('name')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror
      </div>

      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="email">
          Email
        </label>
        <input type="email" class="@error('email') is-invalid @enderror w-full  p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="email" name="email" placeholder="Email" value="{{ $admin->email }}" required="required">
      @error('email')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror  
      </div>

    <div class="form-group mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-3" for="name">
        Country Code
      </label>
      <select class="w-full bg-white p-3 text-sm border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" name="country_id" id="country_id">
        <option value="">Please choose an option</option>
        @foreach ($countries as $country)
        @if (is_null($admin->country))
          <option value="{{ $country['id'] }}" >{{ $country['name'] }}</option>
        @else
          <option value="{{ $country['id'] }}" {{ ($country['id'] == $admin->country->id) ? 'selected' : '' }} >{{ $country['name'] }}</option>
        @endif
        @endforeach
    </select>
      @error('country_id')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-3" for="phone_number">
        Phone Number
      </label>
      <input type="text" class="@error('phone_number') is-invalid @enderror w-full  p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="phone_number"  name="phone_number" placeholder="Phone Number" value="{{ $admin->phone_number }}" required="required">
      @error('phone_number')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>
    
    <input type="hidden" class="w-full  p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="id"  name="id" value="{{ $admin->id }}">
    
    <div class="mt-4 flex gap-4">
      <button type="submit" class="bg-indigo-700 py-2.5 px-6 rounded text-white hover:bg-indigo-600 ">Submit</button>
    </div>

  </form>
  </div>
  
</div>
</div>






@endsection