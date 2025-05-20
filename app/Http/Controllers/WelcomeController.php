<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranModel;
use App\Models\JadwalModel;
use App\Models\MahasiswaModel;

class WelcomeController extends Controller
{
    public function index()
    {
        // Data for breadcrumb
        $breadcrumb = (object) [
            'title' => 'Welcome',
            'list' => ['Home']
        ];

        // Count data for statistics
        $pesertaCount = PendaftaranModel::count();
        $jadwalCount = JadwalModel::count();
        
        // For certificates, we'll use a placeholder or you can replace this with actual data
        // This is just an example - you might want to adjust based on your actual data structure
        $sertifikatCount = PendaftaranModel::where('created_at', '<', now()->subDays(30))->count();

        return view('welcome', compact('breadcrumb', 'pesertaCount', 'jadwalCount', 'sertifikatCount'));
    }
}
