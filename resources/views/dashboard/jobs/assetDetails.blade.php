@extends('layouts.dashboard')

@section('content')
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<section class="is-hero-bar p-6 bg-white">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="text-3xl font-bold">
      Job's Asset Details
    </h1>
  </div>
</section>

<div class="p-8">
  <div class="card p-8" bg-white>
    <form method="POST" action="{{url('asset')}}/{{ $data->assets[0]->id }}" x-data="handler()">
    {{ csrf_field() }}
    <div class="grid grid-cols-4 gap-4">
        <div class="form-group mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-3" for="serial_number">
              Brand Name
          </label>
          <input type="name" class="@error('brand_name') is-invalid @enderror w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="brand_name" name="brand_name" placeholder="Brand Name" value="{{ $data->assets[0]->brand_name ?? '' }}" required="required">
      @error('brand_name')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror
        </div>
    
      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="serial_number">
            Serial Name
        </label>
        <input type="text" class="@error('serial_number') is-invalid @enderror w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="serial_number" name="serial_number" placeholder="Serial Number" value="{{ $data->assets[0]->serial_number ?? '' }}" >
      @error('serial_number')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror
      </div>
    
      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="serial_number">
            Model
        </label>
        <input type="text" class="@error('model') is-invalid @enderror w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="model"  name="model" placeholder="Model" value="{{ $data->assets[0]->model ?? '' }}" >
      @error('model')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror
      </div>
    
      {{-- <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="serial_number">
            Barcode Url
        </label>
        <input type="text" class="@error('barcode_url') is-invalid @enderror w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="barcode_url" name="barcode_url" placeholder="Barcode Url" value="{{ $data->assets[0]->barcode_url ?? '' }}" required="required">
      @error('barcode_url')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror
      </div> --}}

      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="serial_number">
            Year
        </label>
        <input type="text" class="@error('year') is-invalid @enderror w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="year" name="year" placeholder="Year" value="{{ $data->assets[0]->year ?? '' }}">
      @error('year')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror
      </div>

      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="serial_number">
            Comapny Name
        </label>
        <input type="text" class="@error('company_name') is-invalid @enderror w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="company_name" name="company_name" placeholder="Company Name" value="{{ $data->assets[0]->company_name ?? '' }}" required="required">
      @error('company_name')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror
      </div>

      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="serial_number">
            Location
        </label>
        <input type="text" class="@error('location') is-invalid @enderror w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="location" name="location" placeholder="Location" value="{{ $data->assets[0]->location ?? '' }}" required="required">
      @error('location')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror
      </div>

      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="serial_number">
            Landmark
        </label>
        <input type="text" class="@error('landmark') is-invalid @enderror w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="landmark" name="landmark" placeholder="Landmark" value="{{ $data->assets[0]->landmark ?? '' }}" required="required">
      @error('landmark')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror 
      </div>

      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="serial_number">
            Asset Tag
        </label>
        <input type="text" class="@error('asset_tag') is-invalid @enderror w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="asset_tag" name="asset_tag" placeholder="Asset Tag" value="{{ $data->assets[0]->asset_tag ?? '' }}" required="required">
      @error('asset_tag')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror
      </div>

      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="serial_number">
            Asset Type  
        </label>
      <select class="w-full bg-white p-3 text-sm border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" name="asset_type" id="asset_type">
        <option value="">Please select Asset type</option>
          @foreach ($assetTypes as $assetType)
            <option value="{{ $assetType->id }}" {{ ( $assetType->name ?? '' == $data->assets[0]->assetType->name ) ? 'selected' : '' }} >{{ $assetType->name }}</option>
          @endforeach
      </select>
      @error('asset_type')
        <div style='color:#ff0000'; class="alert alert-danger">{{ $message }}</div>
      @enderror  
      </div>

      <div class="form-group mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-3" for="serial_number">
            Note
        </label>
        <input type="text" class="w-full p-3 text-sm font-medium border rounded border-gray-400 placeholder:text-finlendia-base focus:outline-none focus:ring-1 focus:ring-gray-800 focus:border-transparent invalid" id="note" name="note" placeholder="Note" value="{{ $data->assets[0]->note ?? '' }}">
      </div>

        <template x-for="(field, index) in fields" :key="index">
          <div class="col-span-full">
              <p class="text-lg font-semibold" ></p>
              <div class="grid grid-cols-4 gap-4">
                  <div>
                      <label class="block text-gray-700 text-sm font-bold mb-3" for="field_name">
                          Field Name
                      </label>
                      <input
                          class="shadow appearance-none border rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                          :name="`assets[${index}][field_name]`" x-model="field.field_name" id="field_name" type="text"
                          placeholder="Field Name" />
                  </div>

                  <div>
                      <label class="block text-gray-700 text-sm font-bold mb-3" for="field_value">
                          Field Value
                      </label>
                      <input
                          class="shadow appearance-none border rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                          :name="`assets[${index}][field_value]`" x-model="field.field_value" type="text"
                          placeholder="Field Value" />
                  </div>
                  <div class="mt-2 p-6">
                      <button type="button"
                          class="px-4 py-2 mr-1 ml-2 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-red-500 rounded shadow outline-none active:bg-red-600 hover:shadow-md focus:outline-none"
                          @click="removeField(index)">
                          Remove
                      </button>
                  </div>
              </div>
          </div>
        </template>
    </div>
      <button type="button" class="bg-indigo-700 py-2.5 px-6 rounded text-white hover:bg-indigo-600"
          @click="addNewField()">
          Add Asset Fields
      </button>
     <br><br>
    <div>
      <button type="submit" class="bg-indigo-700 py-2.5 px-6 rounded text-white hover:bg-indigo-600">Submit</button>
    </div>
</form>

  </div>
</div>

@push('scripts')
    <script>
        function handler() {
            return {
                fields: (@json($data->assets[0]->asset_field).length > 0) ? @json($data->assets[0]->asset_field)  :  [{
                    field_name: null,
                    field_value: null
                }],
                addNewField() {
                    this.fields.push({
                        field_name: null,
                        field_value: null
                    });
                },
                removeField(index) {
                    this.fields.splice(index, 1);
                }
            }
        }
    </script>
@endpush
@endsection