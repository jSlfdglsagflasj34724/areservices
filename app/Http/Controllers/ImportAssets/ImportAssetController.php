<?php

namespace App\Http\Controllers\ImportAssets;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Customers;
use App\Models\User;
use App\Models\Assets;
use Config;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon; 
use Mail; 
use DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AssetImport;

class ImportAssetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('dashboard/importAssets/assetsimport');
    }

    public function listing()
    {
        $data = [
            'assets' =>Assets::orderBy('id' ,'DESC')->get()
        ];
        return view('dashboard/importAssets/allAssets', $data);
    }

    public function uploadAssets(Request $request)
    {
            Excel::import(new AssetImport, $request->assets);
            $request->session()->flash('alert-success', 'File is successful upload!');
            return redirect()->to('/allAssets');
    }

}    