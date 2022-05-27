<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use App\Models\ConfirmCode;
use App\Models\User;
use App\Models\UserVipInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function UserLogin(Request $request) {
        try {
            $RememberMe = $request->has('remember_me')? true : false;
            if(strpos("@",$request->input('username')) != false) {
                if (Auth::attempt(["email" => $request->input("username"), "password" => $request->input("password"), "status" => 1], $RememberMe) == true) {
                    return response(["status" => 200, "message" => "User Loged In !!"]);
                }
                else {
                    return response(["status" => 400, "message" => "The Username Or Password Is Wrong !!"]);
                }
            }
            else {
                if (Auth::attempt(["mobile" => $request->input("username"), "password" => $request->input("password"), "status" => 1], $RememberMe) == true) {
                    return response(["status" => 200, "message" => "User Loged In !!"]);
                }
                else {
                    return response(["status" => 400, "message" => "The Username Or Password Is Wrong !!"]);
                }
            }
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function UserLogout() {
        try {
            Auth::logout();

            return response(["status" => 200, "message" => "User LogedOut !!"]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    private function CreateUserAccount($userInfo) {
        try {
            $user = new User();

            $user->firstname = $userInfo->firstname;
            $user->lastname = $userInfo->lastname;
            $user->phone = $userInfo->phone;
            $user->mobile = $userInfo->mobile;
            $user->countryid = $userInfo->countryid;
            $user->provinceid = $userInfo->provinceid;
            $user->cityid = $userInfo->cityid;
            $user->address = $userInfo->address;
            $user->zipcode = $userInfo->zipcode;
            if (file_exists(storage_path('app/UserProfilePictures') . '/' . $userInfo->profilepicture->getClientOriginalName())) {
                $UserProfilePictureName = rand(0,50).rand(0,50).rand(0,50) . $userInfo->profilepicture->getClientOriginalName();
            } else {
                $UserProfilePictureName = $userInfo->profilepicture->getClientOriginalName();
            }
            $userInfo->profilepicture->storeAs('UserProfilePictures', $UserProfilePictureName);
            $user->profilepicture = $UserProfilePictureName;
            $user->email = $userInfo->email;
            $user->password = Hash::make($userInfo->password);
            $user->category = $userInfo->category;
            $user->subcategory = $userInfo->subcategory;
            $user->class = $userInfo->class;
            $user->birthdate = $userInfo->birthdate;

            $user->save();

            Auth::attempt(["email" => $userInfo->email, "password" => $userInfo->password]);

            return response(["status" => 200, "message" => "Registration completed successfully!!", "data" => $user]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    private function CreateCompanyAccount($companyInfo) {
        try {
            $userData = $this->CreateUserAccount($companyInfo);

            $company = new CompanyInfo();

            $company->userid = $userData['data']->id;
            $company->companyname = $companyInfo->companyname;
            $company->autogroupname = $companyInfo->autogroupname;
            $company->businessnumber = $companyInfo->businessnumber;
            $company->dealercode = $companyInfo->dealercode;
            $company->mechanicallevel = $companyInfo->mechanicallevel;
            $company->website = $companyInfo->website;
            $company->fax = $companyInfo->fax;
            $company->about = $companyInfo->about;
            $company->cpfirstname = $companyInfo->cpfirstname;
            $company->cplastname = $companyInfo->cplastname;
            $company->cpmobile = $companyInfo->cpmobile;
            $company->cpemail = $companyInfo->cpemail;
            $company->cpposition = $companyInfo->cpposition;
            if (file_exists(storage_path('app/CompanyCPPicture') . '/' . $companyInfo->cppicture->getClientOriginalName())) {
                $CompanyCPPictureName = rand(0,50).rand(0,50).rand(0,50) . $companyInfo->cppicture->getClientOriginalName();
            } else {
                $CompanyCPPictureName = $companyInfo->cppicture->getClientOriginalName();
            }
            $companyInfo->cppicture->storeAs('CompanyCPPicture', $CompanyCPPictureName);

            if (file_exists(storage_path('app/CompanyLogos') . '/' . $companyInfo->logo->getClientOriginalName())) {
                $CompanyLogoName = rand(0,50).rand(0,50).rand(0,50) . $companyInfo->logo->getClientOriginalName();
            } else {
                $CompanyLogoName = $companyInfo->logo->getClientOriginalName();
            }
            $companyInfo->logo->storeAs('CompanyLogos', $CompanyLogoName);
            $company->logo = $CompanyLogoName;

            $company->save();

            Auth::attempt(["email" => $userData['data']->email, "password" => $userData['data']->password]);

            return response(["status" => 200, "message" => "Registration completed successfully!!"]);

        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function UserAccountRegister(Request $request) {
        try {
            if ($request->input('UserCategory') == 1) {
                $this->CreateCompanyAccount($request->all());
            }
            elseif ($request->input('UserCategory') == 2) {
                $this->CreateUserAccount($request->all());
            }
            else {
                return response(["status" => 400, "message" => "User Category Missed !!"]);
            }
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function CreateConfirmPhoneNumber($userId) {
        try {
            $numbers = ["0","1","2","3","4","5","6","7","8","9"];
            $words = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];

            $user = User::where('id',$userId)->first();

            if (count($user) != 0) {
                $numberIds = array_rand( $numbers, 3 );
                $wordIds = array_rand( $words, 4 );

                $Code = $words[$wordIds[0]].$numbers[$numberIds[0]].$words[$wordIds[1]].$numbers[$numberIds[0]].$words[$wordIds[2]].$numbers[$numberIds[0]].$words[$wordIds[3]];

                $confirmCode = new ConfirmCode();

                $confirmCode->userid = $user->id;
                $confirmCode->code = $Code;
                $confirmCode->expiredate = date("Y-m-d");
                $confirmCode->expiretime = date("H:i:s", strtotime("+2 minutes"));
                $confirmCode->confirmtype = 1;

                $confirmCode->save();
                //////////Send SMS//////////
                $data = array('code' => $Code);
                Mail::send('mail', $data, function($message) {
                    $message->to('abc@gmail.com', 'Tutorials Point')->subject
                    ('Laravel HTML Testing Mail');
                    $message->from('xyz@gmail.com','Virat Gandhi');
                });
            }
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function CreateConfirmEmail($userId) {
        try {
            $numbers = ["0","1","2","3","4","5","6","7","8","9"];
            $words = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];

            $user = User::where('id',$userId)->first();

            if (count($user) != 0) {
                $numberIds = array_rand( $numbers, 3 );
                $wordIds = array_rand( $words, 4 );

                $Code = $words[$wordIds[0]].$numbers[$numberIds[0]].$words[$wordIds[1]].$numbers[$numberIds[0]].$words[$wordIds[2]].$numbers[$numberIds[0]].$words[$wordIds[3]];

                $confirmCode = new ConfirmCode();

                $confirmCode->userid = $user->id;
                $confirmCode->code = $Code;
                $confirmCode->expiredate = date("Y-m-d");
                $confirmCode->expiretime = date("H:i:s", strtotime("+2 minutes"));
                $confirmCode->confirmtype = 0;

                $confirmCode->save();
                //////////Send Email//////////
                $data = array('code' => $Code);
                Mail::send('mail', $data, function($message, $user) {
                    $message->to($user->email, 'Confirm Email')->subject
                    ('Confirm Email');
                    $message->from('my@gmail.com','carsell');
                });
            }
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function CheckConfirmCode(Request $request) {
        try {
            $confirmData = ConfirmCode::where('userid',$request->input('userid'))->where('expiredate',date('Y-m-d'))->orderBy('id','DESC')->first();

            if (count($confirmData) != 0) {
                if ( $confirmData->expiretime >= date("H:i:s") ) {
                    if ( $confirmData->code == $request->input("code") ) {
                        if ($confirmData->confirmtype == 0) {
                            User::where('id',$request->input('userid'))->update(['emailconfirmed' => 1]);
                        }
                        else {
                            User::where('id',$request->input('userid'))->update(['phoneconfirmed' => 1]);
                        }
                        return response(["status" => 200, "message" => "Phone Number Confirmed!!"]);
                    }
                    else {
                        return response(["status" => 400, "message" => "Your Code Is Wrong!!!"]);
                    }
                }
                else {
                    return response(["status" => 400, "message" => "Your Code Has Expired!!!"]);
                }
            }
            else {
                return response(["status" => 400, "message" => "Your Data Is Invalid!!!"]);
            }
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    private function UpgradeUserToVIP($VIPInfo) {
        try {
            $user = User::where('id',$VIPInfo->userid)->first();
            $user->class = 1;
            $user->save();

            $vipInfo = new UserVipInfo();

            $vipInfo->userid = $user->id;
            $vipInfo->startdate = date('Y-m-d');
            if ($VIPInfo->expireStatus == 1) {
                $vipInfo->expiredate = date("Y-m-d", strtotime("+1 month"));
            }
            elseif ($VIPInfo->expireStatus == 2) {
                $vipInfo->expiredate = date("Y-m-d", strtotime("+6 month"));
            }
            elseif ($VIPInfo->expireStatus == 3) {
                $vipInfo->expiredate = date("Y-m-d", strtotime("+12 month"));
            }
            if ($VIPInfo->padStatus == 0) {
                $vipInfo->pad = null;
            }
            else {
                if (file_exists(storage_path('app/UserPadFiles') . '/' . $VIPInfo->PADFile->getClientOriginalName())) {
                    $PADFileName = rand(0,50).rand(0,50).rand(0,50) . $VIPInfo->PADFile->getClientOriginalName();
                } else {
                    $PADFileName = $VIPInfo->PADFile->getClientOriginalName();
                }
                $VIPInfo->PADFile->storeAs('UserPadFiles', $PADFileName);
                $vipInfo->pad = $PADFileName;
            }
            $vipInfo->billing = $VIPInfo->billing;

            $vipInfo->save();

            return response(["status" => 200, "message" => "Upgrade Successfully !!"]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function UserPaymentForUpgrade(Request $request) {
        try {
            //for success Payment
            $response = $this->UpgradeUserToVIP($request);

            return response(["status" => $response['status'], "message" => $response['message']]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }
}
