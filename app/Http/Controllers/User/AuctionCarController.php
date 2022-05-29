<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActionCost;
use App\Models\AuctionBid;
use App\Models\AuctionClaimInfo;
use App\Models\AuctionDocument;
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
                $payPrice = ActionCost::where('title','like','example')->first();
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

    private function AutoAuctionBid($auctionid) {
        $auctionbid = AuctionBid::where('auctionid',$auctionid)->orderBy('bidprice','DESC')->first();

        $autoBids = AuctionUser::where('auctionid',$auctionid)->where('auto_bid',1)->orderBy('id','ASC')->get();

        foreach ($autoBids as $data) {
            if ($auctionbid->bidprice+$data->auto_bid_value <= $data->maxbid) {
                $TempBid = AuctionBid::where('auctionid',$auctionid)->where('userid',$data->userid)->first();
                if (count($TempBid) != 0) {
                    $TempBid->bidprice = $auctionbid->bidprice+$data->auto_bid_value;
                    $TempBid->bidtime = date('H:i:s');

                    $TempBid->save();
                }
                else {
                    $newauctionbid = new AuctionBid();

                    $newauctionbid->auctionid = $auctionid;
                    $newauctionbid->bidprice = $auctionbid->bidprice+$data->auto_bid_value;
                    $newauctionbid->bidtime = date('H:i:s');
                    $newauctionbid->userid = $data->userid;

                    $newauctionbid->save();
                }
            }
        }
    }

    public function AuctionBid(Request $request) {
        try {
            $auctionbid = AuctionBid::where('auctionid',$request->input('auctionId'))->where('userid',Auth::user()->id)->first();

            if (count($auctionbid) != 0 ) {
                if ($auctionbid->bidprice < $request->input('bidValue')) {
                    $auctionbid->bidprice = $request->input('bidValue');
                    $auctionbid->bidtime = date('H:i:s');

                    $auctionbid->save();
                }
            }
            else {
                $existauctionbid = AuctionBid::where('auctionid',$request->input('auctionId'))->orderBy('bidprice','DESC')->first();

                if (count($existauctionbid) != 0) {
                    if ($existauctionbid->bidprice < $request->input('bidValue')) {
                        $newauctionbid = new AuctionBid();

                        $newauctionbid->auctionid = $request->input('auctionId');
                        $newauctionbid->bidprice = $request->input('bidValue');
                        $newauctionbid->bidtime = date('H:i:s');
                        $newauctionbid->userid = Auth::user()->id;

                        $newauctionbid->save();
                    } else {
                        return response(["status" => 400, "message" => "Your Bid Is Low !!"]);
                    }
                }
                else {
                    $newauctionbid = new AuctionBid();

                    $newauctionbid->auctionid = $request->input('auctionId');
                    $newauctionbid->bidprice = $request->input('bidValue');
                    $newauctionbid->bidtime = date('H:i:s');
                    $newauctionbid->userid = Auth::user()->id;

                    $newauctionbid->save();
                }
            }

            $this->AutoAuctionBid($request->input('auctionId'));

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

    public function SellerSendAuctionDocument(Request $request) {
        try {
            foreach ($request->input('documents') as $document) {
                if (file_exists(storage_path('app/AuctionDocuments') . '/' . $document->getClientOriginalName())) {
                    $AuctionDocumentName = Auth::user()->id . $document->getClientOriginalName();
                } else {
                    $AuctionDocumentName = $document->getClientOriginalName();
                }
                $document->storeAs('AuctionDocuments', $AuctionDocumentName);

                $auctionDocument = new AuctionDocument();

                $auctionDocument->auctioninfoid = $request->input('auctioninfoid');
                $auctionDocument->fileaddress = $AuctionDocumentName;
                $auctionDocument->sideflag = 1;

                $auctionDocument->save();
            }

            return response(["status" => 200, "message" => "Documents Uploaded Successfully !!"]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function BuyerSendAuctionDocument(Request $request) {
        try {
            foreach ($request->input('documents') as $document) {
                if (file_exists(storage_path('app/AuctionDocuments') . '/' . $document->getClientOriginalName())) {
                    $AuctionDocumentName = Auth::user()->id . $document->getClientOriginalName();
                } else {
                    $AuctionDocumentName = $document->getClientOriginalName();
                }
                $document->storeAs('AuctionDocuments', $AuctionDocumentName);

                $auctionDocument = new AuctionDocument();

                $auctionDocument->auctioninfoid = $request->input('auctioninfoid');
                $auctionDocument->fileaddress = $AuctionDocumentName;
                $auctionDocument->sideflag = 2;

                $auctionDocument->save();
            }

            return response(["status" => 200, "message" => "Documents Uploaded Successfully !!"]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function AuctionUnsuccessfully(Request $request) {
        try {
            AuctionInfo::where('id',$request->input('auctioninfoid'))->update(["status" => 2]);

            return response(["status" => 200, "message" => "Auction Closed With Error !!"]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function AuctionSuccessfully(Request $request) {
        try {
            AuctionInfo::where('id',$request->input('auctioninfoid'))->update(["status" => 1]);

            return response(["status" => 200, "message" => "Auction Closed With Success !!"]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }
}
