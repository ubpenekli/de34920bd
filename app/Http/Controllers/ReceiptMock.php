<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ReceiptMock extends Controller
{
    public function VerifyReceipt(Request $r) : JsonResponse {
        if(Str::endsWith($r->receipt, ["1","3","5","7","9"])) {
            $Response = [
                'status' => true,
                'expireDate' => Carbon::now()->addHours("-6")
            ];
        }
        else {
            $Response = [
                'status' => false,
                'expireDate' => Carbon::now()->addHours("-6")
            ];
        }
        return response()->json($Response, 200);
    }
}
