<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Sentinel;

class fileController extends Controller
{
    public function image($type, $file_id)
    {
        $lokasi = null;
        if ($type == 'profile-pict') {
            $lokasi = config('value.img_path.avatar').'/'.$file_id;
        }
        elseif ($type == 'logo') {
            $lokasi = config('value.img_path.logo').'/'.$file_id;
        }

        $dir = storage_path('app/' . $lokasi);
        if (!File::exists($dir)) {
          $lokasi = config('value.img_path.avatar').'/1-default.jpg';
          $dir = storage_path('app/' . $lokasi);
        }
        return response()->file($dir);
    }
}
