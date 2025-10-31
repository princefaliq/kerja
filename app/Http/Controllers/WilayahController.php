<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    protected $base = 'https://wilayah.id/api';

    public function provinces()
    {
        // cache 24 jam agar tidak sering request ke API
        $data = Cache::remember('wilayah_provinces', 60 * 24, function () {
            $res = Http::get("{$this->base}/provinces.json");
            return $res->successful() ? $res->json() : ['data' => []];
        });

        return response()->json($data);
    }

    public function regencies($provinceCode)
    {
        $key = "wilayah_regencies_{$provinceCode}";
        $data = Cache::remember($key, 60 * 24, function () use ($provinceCode) {
            $res = Http::get("{$this->base}/regencies/{$provinceCode}.json");
            return $res->successful() ? $res->json() : ['data' => []];
        });

        return response()->json($data);
    }

    public function districts($regencyCode)
    {
        $key = "wilayah_districts_{$regencyCode}";
        $data = Cache::remember($key, 60 * 24, function () use ($regencyCode) {
            $res = Http::get("{$this->base}/districts/{$regencyCode}.json");
            return $res->successful() ? $res->json() : ['data' => []];
        });

        return response()->json($data);
    }

    public function villages($districtCode)
    {
        $key = "wilayah_villages_{$districtCode}";
        $data = Cache::remember($key, 60 * 24, function () use ($districtCode) {
            $res = Http::get("{$this->base}/villages/{$districtCode}.json");
            return $res->successful() ? $res->json() : ['data' => []];
        });

        return response()->json($data);
    }
}
