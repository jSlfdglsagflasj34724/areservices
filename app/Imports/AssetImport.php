<?php

namespace App\Imports;

use App\Models\Assets;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;


class AssetImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $data['qrcode'] = QrCode::generate($row['asset']);
        $qrCode = QrCode::generate($row['asset'], storage_path('app/public/'.$row['iu_serial'].'_qrcode.svg') );
        $cartPackage = [
            "brand_name" => $row['indoor_make'],
            "serial_number" => $row['asset'],
            "model" => $row['iu_model'],
            "barcode_url" => $row['iu_serial'].'_qrcode.svg',
        ];
        $insertPackage = Assets::updateOrCreate(['serial_number' => $row['asset'] ],$cartPackage);
    }
}
