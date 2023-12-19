<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Asset;
use App\Models\AssetType;
use App\Enums\AssetStatus;
use App\Models\AssetFields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AssetsController extends Controller
{
    public function index()
    {
        $data = [
            'assets' => Asset::orderBy('id', 'DESC')->get()
        ];

        return view('dashboard/importAssets/allAssets', $data);
    }

    public function create()
    {
        $data = [
            'assetTypes' => AssetType::orderBy('id', 'DESC')->get()
        ];

        return view('dashboard/importAssets/addAsset', $data);
    }

    public function store(Request $request)
    { 
        $request->validate([
            'brand_name' => ['required'],
            'serial_number' => ['required'],
            'asset_type_id' => ['required'],
            // 'barcode_url' => ['required', 'url'],
            'year' => ['required', 'digits:4'],
            'company_name' => ['required'],
            'location' => ['required', 'string'],
            'landmark' => ['required'],
            'asset_tag' => ['required', 'digits:6'],
        ]);
        
        try {
            $asset = new Asset();
            $asset->fill($request->all());
            $asset->user_id = Auth::id();
            $asset->check = AssetStatus::AUTO->value;
            $asset->save();
    
            if($request['assets'])
            {
                foreach ($request['assets'] as $key => $value) {
                    if ( $value['field_name'] != null && $value['field_value'] != null ) {
                        $asset_fields = [
                            'field_name' => $value['field_name'],
                            'field_value' => $value['field_value']
                        ];
                    $asset->asset_field()->updateOrCreate($asset_fields);
                    }
                }
            }
    
            $request->session()->flash('alert-success', 'Asset is successful added!');
            
            return redirect()->to('/assets');

        } catch (Exception $e) {
            Log::info('Error message while adding asset:'. $request->asset_tag .'::{'.$e->getMessage().'}');
            $request->session()->flash('alert-danger', 'Something went wrong!');
            
            return redirect()->to('/assets');            
        }
    }

    public function show(Asset $asset)
    {
        $data = [
            'asset' => $asset,
            'assetTypes' => AssetType::orderBy('id', 'DESC')->get(),
            'assetFields' => AssetFields::where(['asset_id' => $asset->id])->get()
        ];

        return view('dashboard/importAssets/showAsset', $data);
    }

    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'brand_name' => ['required'],
            'serial_number' => ['required'],
            'asset_type' => ['required'],
            'year' => ['required', 'digits:4'],
            'company_name' => ['required'],
            'location' => ['required', 'string'],
            'landmark' => ['required'],
            'asset_tag' => ['required', 'digits:6'],
        ]);

        try {
            $asset->fill($request->all());
            $asset->check = AssetStatus::AUTO->value;
            $asset->user_id = Auth::id();
            $asset->update();
    
            $asset->asset_field()->delete();
    
            if($request['assets'])
            {
                foreach ($request['assets'] as $key => $value) {
                    if ( $value['field_name'] != null && $value['field_value'] != null ) {
                        $asset_fields = [
                            'field_name' => $value['field_name'],
                            'field_value' => $value['field_value']
                        ];
                        $asset->asset_field()->updateOrCreate($asset_fields);
                    }
                }
            }
    
            $request->session()->flash('alert-success', 'Asset is successful updated!');
    
            return redirect()->to('/assets');

        } catch (Exception $e) {
            Log::info('Error message while adding asset:'. $request->asset_tag .'::{'.$e->getMessage().'}');
            $request->session()->flash('alert-danger', 'Something went wrong!');
    
            return redirect()->to('/assets');            
        }
           
    }

    public function destroy(Request $request, Asset $asset)
    {
        $asset->delete();

        $request->session()->flash('alert-success', 'Asset is successful deleted!');
        
        return redirect()->to('/assets');
    }
}
