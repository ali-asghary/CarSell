<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActionCost;
use App\Models\AuctionBid;
use App\Models\AuctionClaimInfo;
use App\Models\AuctionInfo;
use App\Models\AuctionUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuctionCarController extends Controller
{
    private function VIPJoinToAuction($request) {
        try {
            $auctionuser = new AuctionUser();

            $auctionuser->userid = Auth::user()->id;
            $auctionuser->auctionid = $request->auctionid;
            $auctionuser->pay_type = 1;
            $auctionuser->auto_bid = $request->autoBid;
            $auctionuser->maxbid = $request->maxBid;
            $auctionuser->auto_bid_value = $request->autoBidValue;

            $auctionuser->save();

            return response(["status" => 200, "message" => "Successfully Joined To Auction !!"]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    private function UserJoinToAuction($request) {
        try {
            $auctionuser = new AuctionUser();

            $auctionuser->userid = Auth::user()->id;
            $auctionuser->auctionid = $request->auctionid;
            $auctionuser->pay_type = $request->paytype;
            $auctionuser->auto_bid = $request->autoBid;
            $auctionuser->maxbid = $request->maxBid;
            $auctionuser->auto_bid_value = $request->autoBidValue;

            $auctionuser->save();

            return response(["status" => 200, "message" => "Successfully Joined To Auction !!"]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function JoinToAuction(Request $request) {
        try {
            if (Auth::user()->class == 1) {
                $this->VIPJoinToAuction($request);
            }
            else {
                $payPrice = ActionCost::where('title','like','Sample')->first();
                if ($request->input('paytype') == 2) {
                    //// Send Request To Payment API ////
                    $paymentResult = 1;

                    if ($paymentResult == 1) {
                        $this->UserJoinToAuction($request);
                    } else {
                        return response(["status" => 400, "message" => "Payment Failed !!"]);
                    }
                }
                elseif ($request->input('paytype') == 3) {
                    $payPrice = 0;
                    if (Auth::user()->wallet >= $payPrice->usercost) {
                        $newWallet = Auth::user()->wallet - $payPrice->usercost;
                        User::where('id',Auth::user()->id)->update(["wallet" => $newWallet]);
                        $this->UserJoinToAuction($request);
                    }
                    else {
                        return response(["status" => 400, "message" => "Wallet Not Enough !!"]);
                    }
                }
            }
        }
        catch (\Exception $e) {
            return response(["status" => 40, "message" => $e->getMessage()]);
        }
    }

    private function AutoAuctionBid($auctionid, $auctionbidid) {
        $auctionbid = AuctionBid::where('id',$auctionbidid)->first();

        $autoBids = AuctionUser::where('auctionid',$auctionid)->where('auto_bid',1)->orderBy('id','ASC')->get();

        foreach ($autoBids as $data) {
            if ($auctionbid->maxbid+$data->auto_bid_value < $data->maxbid) {
                $auctionbid->maxbid = $auctionbid->maxbid+$data->auto_bid_value;
                $auctionbid->bidtime = date('H:i:s');
                $auctionbid->userid = $data->userid;

                $auctionbid->save();
            }
        }
    }

    public function AuctionBid(Request $request) {
        try {
            $auctionbid = AuctionBid::where('auctionid',$request->input('auctionId'))->first();

            if (count($auctionbid) != 0 ) {
                if ($auctionbid->maxbid < $request->input('bidValue')) {
                    $auctionbid->maxbid = $request->input('bidValue');
                    $auctionbid->bidtime = date('H:i:s');
                    $auctionbid->userid = Auth::user()->id;

                    $auctionbid->save();
                }

                $this->AutoAuctionBid($request->input('auctionId'), $auctionbid->id);
            }
            else {
                $newauctionbid = new AuctionBid();

                $newauctionbid->auctionid = $request->input('auctionId');
                $newauctionbid->maxbid = $request->input('bidValue');
                $newauctionbid->bidtime = date('H:i:s');
                $newauctionbid->userid = Auth::user()->id;

                $newauctionbid->save();

                $this->AutoAuctionBid($request->input('auctionId'), $newauctionbid->id);
            }

            return response(["status" => 200, "data" => $auctionbid->userid]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function GetCurrentAuctionBid(Request $request) {
        try {
            $auctionBid = AuctionBid::where('auctionid',$request->input('auctionId'))->first();

            return response(["status" => 20, "message" => "Last Auction Bid !!" ,"data" => $auctionBid]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }
}
