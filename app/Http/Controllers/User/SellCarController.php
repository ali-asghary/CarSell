<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellCarController extends Controller
{
    public function BuyerSendRequestToSeller(Request $request) {
        try {
            $carinquiry = new CarInquiry();

            $carinquiry->carid = $request->input('carId');
            $carinquiry->name = $request->input('name');
            $carinquiry->email = $request->input('email');
            $carinquiry->phone = $request->input('phone');
            $carinquiry->subject = $request->input('subject');
            $carinquiry->message = $request->input('message');

            $carinquiry->save();

            return response(["status" => 200, "message" => "Inquiry Send Successfully !!"]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function SellerGetRequests(Request $request) {
        try {
            $inquiries = CarInquiry::whereIn('carid',$request->input('carId'))->get();

            return response(["status" => 200, "message" => "Car Inquiries List !!", "data" => $inquiries]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }
}
