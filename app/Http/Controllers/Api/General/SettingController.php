<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\SettingResource;
use App\Models\RelatedNewsSite;
use App\Models\Setting;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    use ApiResponseTrait;
    public function index(){
        $settings = Setting::first();
        $related_sites = RelatedNewsSite::select('name' , 'url')->get();
        $data = [
            'settings' => new SettingResource($settings),
            'related_sites' => $related_sites,
        ];
        return $this->apiResponse($data, 'Settings get successfully' , 200);
    }
}
