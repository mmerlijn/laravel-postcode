<?php

namespace mmerlijn\laravelPostcode\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use mmerlijn\laravelPostcode\Http\Resources\PostcodeResource;
use mmerlijn\laravelPostcode\Models\Postcode;
use mmerlijn\laravelPostcode\Models\PostcodeNotFound;

class PostcodeController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getAddress(Request $request)
    {
        $request->validate([
            'postcode' => ['required', 'regex:/^(\d{4}\w{2})$/i'], //
            'nr' => 'required',
        ], [
                'required' => ':attribute is een verplicht veld',
                'regex' => ':attribute formaat is niet geldig',
            ]
        );
        $data = Postcode::getAddress($request->postcode, $request->nr)->first();
        if (!$data and config('postcode.postcode_table_not_found')) {
            PostcodeNotFound::create(['postcode' => $request->postcode, 'number' => $request->nr]);
        }
        return new PostcodeResource($data);

    }
}