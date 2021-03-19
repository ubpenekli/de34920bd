<?php

namespace App\Http\Controllers;

use App\Device;
use App\Receipt;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class API extends Controller
{
    function apiTest() {
        return response()->json(['test' => Carbon::now()->addHours("-6")], 200);
    }
    public function CheckSubscription(Request $r) : JsonResponse {
        $Response = [];
        $Response['Subscriber'] = Device::where([
            ['token','=',$r->token],
            ['expiry','>=',Carbon::now()->toDateTimeString()]
        ])->first();
        $Response['Status'] = (null !== $Response['Subscriber']);
        return response()->json($Response, 200);
    }
    public function Register(Request $r) : JsonResponse {
        $ExistingDevice = Device::where('uid', '=', $r->uid)->first();
        $Response = [];
        if(!empty($ExistingDevice->id)) {
            $Response['Register'] = true;
            $Response['First'] = false;
        }
        else {
            $Response['Register'] = true;
            $Response['First'] = true;
        }
        //$Response['CreatedToken'] = sha1($r->uid.Carbon::now()->toDateTimeLocalString());
        $Response['NewDevice'] = Device::create([
            'uid' => $r->uid,
            'appId' => $r->appId,
            'lang' => $r->lang,
            'os' => $r->os,
            'expiry' => $r->expiry,
            'token' => sha1($r->uid.Carbon::now()->toDateTimeLocalString()) //$Response['CreatedToken']
        ]);
        return response()->json($Response, 201);
    }
    public function CheckReceipt(Request $r) {
        $ReceiptResponse = json_decode(Http::get('localhost/teknasyon/teknasyon/public/api/verifyReceipt', [
            'receipt' => $r->receipt,
            'clientToken' => $r->clientToken
        ])->getBody()->getContents());
        $Response = [
            'receipt' => $r->receipt,
            'clientToken' => $r->clientToken,
            'status' => $ReceiptResponse->status,
            'expireDate' => Carbon::parse(strtotime($ReceiptResponse->expireDate))->format('Y-m-d H:i:s')
        ];
        Receipt::create($Response);
        return response()->json($Response, 200);
    }
}
