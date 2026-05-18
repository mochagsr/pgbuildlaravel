<?php

namespace App\Http\Controllers;

use App\Models\AboutImage;
use App\Models\AboutSetting;

class TentangController extends Controller
{
    public function index()
    {
        $setting = AboutSetting::getSetting();
        $images  = AboutImage::orderBy('urutan')->get();
        return view('tentang', compact('setting', 'images'));
    }
}
