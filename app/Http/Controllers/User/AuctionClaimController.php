<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AuctionInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuctionClaimController extends Controller
{
    public function SetAuctionClaim(Request $request) {
        try {
            AuctionInfo::where('id',$request->input('actionInfoId'))->update(["claim" => 1]);

            $auctionclaim = new AuctionClaimInfo();

            $auctionclaim->auctionid = $request->input('actionInfoId');

            $auctionclaim->save();
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }
}
