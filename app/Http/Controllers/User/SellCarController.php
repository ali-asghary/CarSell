<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarInquiry;
use App\Models\CarTradeIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SellCarController extends Controller
{
    private $BuyerSendRequestrules = [
        'name' => 'string|required|max:255',
        'email' => 'string|required|max:255',
        'phone' => 'numeric|required',
        'subject' => 'string|required|max:255',
        'message' => 'string|required',
    ];

    private $BuyerTradeInrules = [
        'name' => 'string|required|max:255',
        'email' => 'string|required|max:255',
        'phone' => 'numeric|required',
        'subject' => 'string|required|max:255',
        'message' => 'string|required',
        'make' => 'numeric|required',
        'model' => 'numeric|required',
        'year' => 'numeric|required',
        'mileage' => 'numeric|required',
        'color' => 'numeric|required',
        'bodytypeid' => 'numeric|required',
        'drivetrain' => 'numeric|required',
        'transmission' => 'numeric|required',
        'fueltypeid' => 'numeric|required',
        'enginetypeid' => 'numeric|required',
        'condition' => 'numeric|required',
        'accident' => 'numeric|required',
        'door' => 'numeric|required',
        'vinnumber' => 'string|required',
    ];

    public function BuyerSendRequestToSeller(Request $request) {
        try {
            $validation_message = array();
            $validation = Validator::make($request->all(),$this->BuyerSendRequestrules);
            if ($validation->fails()) {
                foreach ($validation->errors()->getMessages() as $message) {
                    $validation_message[] = $message;
                }
            }

            if ($validation_message != []) {
                return response(["status" => 400, "message" => $validation_message]);
            }

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

    public function BuyerTradeInWithSeller(Request $request) {
        try {
            $validation_message = array();
            $validation = Validator::make($request->all(),$this->BuyerTradeInrules);
            if ($validation->fails()) {
                foreach ($validation->errors()->getMessages() as $message) {
                    $validation_message[] = $message;
                }
            }

            if ($validation_message != []) {
                return response(["status" => 400, "message" => $validation_message]);
            }

            $cartradein = new CarTradeIn();

            $cartradein->carid = $request->input('carId');
            $cartradein->name = $request->input('name');
            $cartradein->email = $request->input('email');
            $cartradein->phone = $request->input('phone');
            $cartradein->subject = $request->input('subject');
            $cartradein->message = $request->input('message');
            $cartradein->make = $request->input('make');
            $cartradein->model = $request->input('model');
            $cartradein->year = $request->input('year');
            $cartradein->mileage = $request->input('mileage');
            $cartradein->color = $request->input('color');
            $cartradein->bodytypeid = $request->input('bodytypeid');
            $cartradein->drivetrain = $request->input('drivetrain');
            $cartradein->transmission = $request->input('transmission');
            $cartradein->fueltypeid = $request->input('fueltypeid');
            $cartradein->enginetypeid = $request->input('enginetypeid');
            $cartradein->condition = $request->input('condition');
            $cartradein->accident = $request->input('accident');
            $cartradein->door = $request->input('door');
            $cartradein->vinnumber = $request->input('vinnumber');

            $cartradein->save();

            return response(["status" => 200, "message" => "TrdeIn Set Successfully !!"]);
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
