@extends('layouts.dashboard')

@section('content')
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<section class="is-hero-bar p-6 bg-white">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="text-3xl font-bold">
      Jobs Details
    </h1>
    <a href="{{ route('technician.index', $data->id) }}" type="submit" class="bg-indigo-700 py-2.5 px-6 rounded text-white hover:bg-indigo-600">Assign Technician</a>
  </div>
</section>

<div class="p-8">
  <div class="card p-8" bg-white>
    <form method="POST" action="{{route('job.update', $data)}}">
    {{ csrf_field() }}
    <div class="grid grid-cols-2 gap-4" x-data="{jobStatus: null}">
        <div class="form-group mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-3" for="name">
              Job Name
          </label>
          <input type="name" class="w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="name" name="name" placeholder="Job Name" value="{{ $data->job_name }}" disabled>
        </div>
    
      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="description">
            Job Description
        </label>
        <input type="text" class="w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="description" name="description" placeholder="Job Description" value="{{ $data->job_description }}" disabled>
      </div>
    
      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="availability">
            Availability
        </label>
        <input type="text" class="w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="availability"  name="availability" placeholder="Availability" value="{{ $data->availability }}" disabled>
      </div>
    
      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="status">
            Status
        </label>
        <input type="text" class="w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="status" name="status" placeholder="Status" value="{{ $data->status }}" disabled>
      </div>

      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="priority_name">
            Priority Name
        </label>
        <input type="text" class="w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="priority_name" name="priority_name" placeholder="Priority Name" value="{{ $data->priority->priority_name }}" disabled>
      </div>

      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="priority_desc">
            Priority Description
        </label>
        <input type="text" class="w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="priority_desc" name="priority_desc" placeholder="Priority Description" value="{{ $data->priority->priority_desc }}" disabled>
      </div>

      @if ($data->status->value == 'open' || $data->status->value == 'in-progress' || $data->status->value == 'schedule')
        <div class="form-group mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-3" for="priority_desc">
            Status change
          </label>
          <select class="w-full bg-white p-3 text-sm border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" name="status" id="status_change" @change="jobStatus=$event.target.value">
            @if ($data->status->value == 'open')
            <option value="completed">COMPLETED</option>
              <option value="cancelled">CANCELLED</option>
              <option value="scheduled">SCHEDULE</option>
            @elseif ($data->status->value == 'scheduled' || $data->status->value == 'reschedule')
              <option value="in-progress">IN-PROGRESS</option>
              <option value="cancelled">CANCELLED</option>
            @elseif ($data->status->value == 'in-progress')
              <option value="completed">COMPLETED</option>
              <option value="cancelled">CANCELLED</option>
            @endif
        </select>
        </div>
      @endif

      </div>

      @if ($data->status->value == 'open' || $data->status->value == 'in-progress' || $data->status->value == 'scheduled')
        <div class="form-group mb-4">
          <button type="submit" class="bg-indigo-700 py-2.5 px-6 rounded text-white hover:bg-indigo-600">Submit</button>
        </div>  
      @endif
     
    </div>
    <div class="grid grid-cols-4 mt-4">
      @foreach ( $data->file as $file )  
            <div class="form-group mb-4 px-8">
              <img src="{{ asset('storage/'.$file->file_name) }}" alt="Image"/> 
            </div>
      @endforeach
    </div>
</form>

  </div>
</div>

@endsection
