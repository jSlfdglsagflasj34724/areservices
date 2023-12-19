<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Job;
use App\Models\Asset;
use App\Models\AssetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssetJobController extends Controller
{
    public function show(Job $job)
    {
        $data = $job->load(['assets' => ['assetType', 'asset_field']]);
        $assetTypes = AssetType::get();
        
        return view('dashboard/jobs/assetDetails', compact('data', 'assetTypes'));
    }

    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'brand_name' => ['required'],
            'company_name' => ['required'],
            'location' => ['required', 'string'],
            'landmark' => ['required'],
            'asset_tag' => ['required', 'digits:6'],
        ]);

        try {
            DB::transaction(function ($query) use ($request, $asset) {
                $asset->fill($request->only('brand_name', 'serial_number', 'model', 'barcode_url', 'year', 'company_name', 'location', 'landmark', 'asset_tag', 'note'));
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
            });

            $request->session()->flash('alert-success', 'Asset Data updated successfully!');

            return redirect()->to('/jobs');
        } catch (Exception $ex) {
            Log::info('Error message while updating asset:'. $request->asset_tag .'::{'.$ex->getMessage().'}');
            $request->session()->flash('alert-danger', 'Something went wrong!');

            return redirect()->to('/jobs');
        }
    }
}
