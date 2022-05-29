<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActionCost;
use App\Models\AuctionInfo;
use App\Models\Car;
use App\Models\CarCertified;
use App\Models\CarDamage;
use App\Models\CarFaxProof;
use App\Models\CarInspection;
use App\Models\CarPicture;
use App\Models\CarService;
use App\Models\RelationCarDisclosure;
use App\Models\RelationCarMechanicalIssue;
use App\Models\RelationCarModification;
use App\Models\RelationCarOption;
use App\Models\RelationCarWarningLight;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\New_;

class CarController extends Controller
{
    private $insertrules = [
        'price' => 'numeric|required',
        'discounttype' => 'numeric|required',
        'discount' => 'numeric|required',
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
        'description' => 'string|required',
    ];

    private $updaterules = [
        'priceEdit' => 'numeric|required',
        'discounttypeEdit' => 'numeric|required',
        'discountEdit' => 'numeric|required',
        'makeEdit' => 'numeric|required',
        'modelEdit' => 'numeric|required',
        'yearEdit' => 'numeric|required',
        'mileageEdit' => 'numeric|required',
        'colorEdit' => 'numeric|required',
        'bodytypeidEdit' => 'numeric|required',
        'drivetrainEdit' => 'numeric|required',
        'transmissionEdit' => 'numeric|required',
        'fueltypeidEdit' => 'numeric|required',
        'enginetypeidEdit' => 'numeric|required',
        'conditionEdit' => 'numeric|required',
        'accidentEdit' => 'numeric|required',
        'doorEdit' => 'numeric|required',
        'vinnumberEdit' => 'string|required',
        'descriptionEdit' => 'string|required',
    ];

    private $searchrules = [
        'PriceSearch' => 'string|max:50',
        'MakeSearch' => 'numeric',
        'ModelSearch' => 'numeric',
        'YearSearch' => 'numeric',
        'MileageSearch' => 'numeric',
        'ConditionSearch' => 'numeric',
        'BodyTypeSearch' => 'numeric',
        'DriveTrainSearch' => 'numeric',
        'TransmissionSearch' => 'numeric',
        'FuelTypeSearch' => 'numeric',
        'AccidentSearch' => 'numeric',
        'AuctionFlagSearch' => 'numeric',
        'ListedDateSearch' => 'date',
        'KeyWordSearch' => 'string|max:30',
    ];

    private function changeErrorMessage (array $errors){
        $message = array();
        foreach ($errors as $model_error) {
            foreach ($model_error as $error) {
                switch ($error) {
                    case 'The title must be a string.':
                        $message[] = "عنوان باید در قالب حروف وارد شود.";
                        break;
                    case 'The title field is required.':
                        $message[] = "وارد نمودن عنوان الزامی است.";
                        break;
                    case 'The title must not be greater than 50 characters.':
                        $message[] = "تعداد حروف عنوان نباید بیشتر از ۵۰ کاراکتر باشد.";
                        break;
                    case 'The city id must be a number.':
                        $message[] = "شهر باید در قالب عدد وارد شود.";
                        break;
                    case 'The city id field is required.':
                        $message[] = "وارد نمودن شهر الزامی است.";
                        break;
                    case 'The title edit field is required.':
                        $message[] = "وارد نمودن عنوان الزامی است.";
                        break;
                    case 'The title edit must be a string.':
                        $message[] = "عنوان باید در قالب حروف وارد شود.";
                        break;
                    case 'The title edit must not be greater than 50 characters.':
                        $message[] = "تعداد حروف عنوان نباید بیشتر از ۵۰ کاراکتر باشد.";
                        break;
                    case 'The city edit id must be a number.':
                        $message[] = "شهر باید در قالب عدد وارد شود.";
                        break;
                    case 'The city edit id field is required.':
                        $message[] = "وارد نمودن شهر الزامی است.";
                        break;
                    case 'The title search edit must be a string.':
                        $message[] = "عنوان باید در قالب حروف وارد شود.";
                        break;
                    case 'The title search must not be greater than 20 characters.':
                        $message[] = "تعداد حروف عنوان نباید بیشتر از ۲۰ کاراکتر باشد.";
                        break;
                    case 'The city id search must be a number.':
                        $message[] = "شهر باید در قالب عدد وارد شود.";
                        break;
                }
            }
        }
        return $message;
    }

    public function GetCars() {
        try {
            //$cars = Car::whereActive(1)->get();
            $cars = Car::where('active',1)->get();

            return response(["status" => 200, "message" => "Cars List", "data" => $cars]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public  function GetUserCars() {
        try {
            $cars = Car::where('userid',Auth::user()->id)->get();

            foreach ($cars as $car) {
                $car->bodytypeid = $car->BodyType->title;
                $car->drivetrain = $car->DriveTrain->title;
                $car->transmission = $car->Transmission->title;
                $car->fueltypeid = $car->FuelType->title;
                $car->enginetypeid = $car->EngineType->title;
                $car->condition = $car->Condition->title;
                $car->accident = $car->Accident->title;
                $car->make = $car->Make->title;
                $car->model = $car->Model->title;
                $car->picture = CarPicture::where('carid',$car->id);
                $car->faxproof = CarFaxProof::where('carid',$car->id);
                $car->certified = CarCertified::where('carid',$car->id);
                $car->inspection = CarInspection::where('carid',$car->id);
                $car->service = CarService::where('carid',$car->id);

                if ($car->auction == 1) {
                    $auctionInfo = AuctionInfo::where('carid',$car->id)->first();

                    $car->damage = CarDamage::where('carid',$car->id)->get();
                    $car->auctionInfo = $auctionInfo;
                }
            }

            return response(["status" => 200, "message" => "User Cars List !!", "data" => $cars]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function InsertCar(Request $request) {
        try {
            $validation_message = array();
            $validation = Validator::make($request->all(),$this->insertrules);
            if ($validation->fails()) {
                foreach ($validation->errors()->getMessages() as $message) {
                    $validation_message[] = $message;
                }
            }

            if ($validation_message != []) {
                return response(["status" => 400, "message" => $validation_message]);
            }

            if ($request->input('auction') == 1) {
                $payflag = 0;
                $payPrice = ActionCost::where('title','like','example')->first();
                if($request->input('paytype') == 1) {
                    //creditcard pay

                    $payflag = 1;
                }
                elseif($request->input('paytype') == 2) {
                    //carpager pay
                    if (Auth::user()->wallet >= $payPrice->usercost) {
                        $newWallet = Auth::user()->wallet - $payPrice->usercost;
                        User::where('id',Auth::user()->id)->update(["wallet" => $newWallet]);
                        $payflag = 1;
                    }
                    else {
                        return response(["status" => 400, "message" => "Wallet Not Enough !!"]);
                    }
                }

                if ($payflag == 0) {
                    return response(["status" => 400, "message" => "Payment Failed !!"]);
                }
            }

            $userId = Auth::user()->id;
            $car = new Car();

            $car->price = $request->input('price');
            $car->discounttype = $request->input('discounttype');
            $car->discount = $request->input('discount');
            $car->make = $request->input('make');
            $car->model = $request->input('model');
            $car->year = $request->input('year');
            $car->mileage = $request->input('mileage');
            $car->color = $request->input('color');
            $car->bodytypeid = $request->input('bodytypeid');
            $car->drivetrain = $request->input('drivetrain');
            $car->transmission = $request->input('transmission');
            $car->fueltypeid = $request->input('fueltypeid');
            $car->enginetypeid = $request->input('enginetypeid');
            $car->condition = $request->input('condition');
            $car->accident = $request->input('accident');
            $car->door = $request->input('door');
            $car->vinnumber = $request->input('vinnumber');
            $car->description = $request->input('description');
            $car->auction = $request->input('auction');
            $car->userid = $userId;
            if ($request->input('auction') == 0) {
                $car->active = $request->input('active');
            }

            $car->save();

            foreach ($request->file('picture') as $carpicture) {
                if (file_exists(storage_path('app/CarPictures') . '/' . $carpicture->getClientOriginalName())) {
                    $PictureName = $userId . $carpicture->getClientOriginalName();
                } else {
                    $PictureName = $carpicture->getClientOriginalName();
                }
                $carpicture->storeAs('CarPictures', $PictureName);

                $newcarpicture = new CarPicture();

                $newcarpicture->carid = $car->id;
                $newcarpicture->imageaddress = $PictureName;

                $newcarpicture->save();
            }

            foreach ($request->file('certified') as $carcertified) {
                if (file_exists(storage_path('app/CarCertifieds') . '/' . $carcertified->getClientOriginalName())) {
                    $CertifiedName = $userId . $carcertified->getClientOriginalName();
                } else {
                    $CertifiedName = $carcertified->getClientOriginalName();
                }
                $carcertified->storeAs('CarCertifieds', $CertifiedName);

                $newcarcertified = new CarCertified();

                $newcarcertified->carid = $car->id;
                $newcarcertified->imageaddress = $CertifiedName;

                $newcarcertified->save();
            }

            foreach ($request->file('carfaxproof') as $carfaxproof) {
                if (file_exists(storage_path('app/CarFaxProofs') . '/' . $carfaxproof->getClientOriginalName())) {
                    $FaxProofName = $userId . $carfaxproof->getClientOriginalName();
                } else {
                    $FaxProofName = $carfaxproof->getClientOriginalName();
                }
                $carfaxproof->storeAs('CarFaxProofs', $FaxProofName);

                $newcarfaxproof = new CarFaxProof();

                $newcarfaxproof->carid = $car->id;
                $newcarfaxproof->imageaddress = $FaxProofName;

                $newcarfaxproof->save();
            }

            foreach ($request->file('inspection') as $carinspection) {
                if (file_exists(storage_path('app/CarInspections') . '/' . $carinspection->getClientOriginalName())) {
                    $CarInspectionName = $userId . $carinspection->getClientOriginalName();
                } else {
                    $CarInspectionName = $carinspection->getClientOriginalName();
                }
                $carinspection->storeAs('CarInspections', $CarInspectionName);

                $newcarinspection = new CarInspection();

                $newcarinspection->carid = $car->id;
                $newcarinspection->imageaddress = $CarInspectionName;

                $newcarinspection->save();
            }

            foreach ($request->file('service') as $carservice) {
                if (file_exists(storage_path('app/CarServices') . '/' . $carservice->getClientOriginalName())) {
                    $CarServiceName = $userId . $carservice->getClientOriginalName();
                } else {
                    $CarServiceName = $carservice->getClientOriginalName();
                }
                $carservice->storeAs('CarServices', $CarServiceName);

                $newcarservice = new CarService();

                $newcarservice->carid = $car->id;
                $newcarservice->imageaddress = $CarServiceName;

                $newcarservice->save();
            }

            if ($request->input('option') != null && $request->input('option') != []) {
                foreach ($request->input('option') as $data) {
                    $relationcaroption = new RelationCarOption();

                    $relationcaroption->carid = $car->id;
                    $relationcaroption->optionid = $data;

                    $relationcaroption->save();
                }
            }

            if ($request->input('modification') != null && $request->input('modification') != []) {
                foreach ($request->input('modification') as $data) {
                    $relationcarmodification = new RelationCarModification();

                    $relationcarmodification->carid = $car->id;
                    $relationcarmodification->modificationid = $data;

                    $relationcarmodification->save();
                }
            }

            if ($request->input('disclusure') != null && $request->input('disclusure') != []) {
                foreach ($request->input('disclusure') as $data) {
                    $relationcardisclusure = new RelationCarDisclosure();

                    $relationcardisclusure->carid = $car->id;
                    $relationcardisclusure->disclosureid = $data;

                    $relationcardisclusure->save();
                }
            }

            if ($request->input('mechanicalissue') != null && $request->input('mechanicalissue') != []) {
                foreach ($request->input('mechanicalissue') as $data) {
                    $relationcarmechanicalissue = new RelationCarMechanicalIssue();

                    $relationcarmechanicalissue->carid = $car->id;
                    $relationcarmechanicalissue->mechanicalissueid = $data;

                    $relationcarmechanicalissue->save();
                }
            }

            if ($request->input('warninglight') != null && $request->input('warninglight') != []) {
                foreach ($request->input('warninglight') as $data) {
                    $relationcarwarninglight = new RelationCarWarningLight();

                    $relationcarwarninglight->carid = $car->id;
                    $relationcarwarninglight->warninglightid = $data;

                    $relationcarwarninglight->save();
                }
            }

            if ($request->input('auction') == 1) {
                $auctioninfo = new AuctionInfo();

                $auctioninfo->carid = $car->id;
                $auctioninfo->registerprovinceid = $request->input('registerprovinceid');
                $auctioninfo->lien = $request->input('lien');
                $auctioninfo->unpaiddebt = $request->input('unpaiddebt');
                $auctioninfo->otherdisclusure = $request->input('otherdisclusure');

                foreach ($request->file('damagephoto') as $cardamagephoto) {
                    if (file_exists(storage_path('app/CarDamagePhotos') . '/' . $cardamagephoto->getClientOriginalName())) {
                        $CarDamagePhotoName = $userId . $cardamagephoto->getClientOriginalName();
                    } else {
                        $CarDamagePhotoName = $cardamagephoto->getClientOriginalName();
                    }
                    $cardamagephoto->storeAs('CarDamagePhotos', $CarDamagePhotoName);

                    $newcardamagephoto = new CarDamage();

                    $newcardamagephoto->carid = $car->id;
                    $newcardamagephoto->imageaddress = $CarServiceName;

                    $newcardamagephoto->save();
                }

                $auctioninfo->startdate = $request->input('startdate');
                $auctioninfo->starttime = $request->input('starttime');
                $auctioninfo->starttoclose = $request->input('starttoclose');
                $auctioninfo->decisiontime = $request->input('decisiontime');
                $auctioninfo->tasktime = $request->input('tasktime');
                $auctioninfo->auctiondealclearingtime = $request->input('auctiondealclearingtime');
                /*$auctioninfo->investigationtime = $request->input('investigationtime');
                $auctioninfo->claimdealclearingtime = $request->input('claimdealclearingtime');
                $auctioninfo->carpagertime = $request->input('carpagertime');*/
                $auctioninfo->startprice = $request->input('startprice');
                $auctioninfo->minreservedprice = $request->input('minreservedprice');

                $auctioninfo->save();
            }
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function DeleteCar($carId) {
        try {
            $carInfo = Car::where('id',$carId)->first();

            if ($carInfo->auction == 1) {
                $auctionInfo = AuctionInfo::where('carid', $carId)->first();

                if (date('Y-m-d') >= $auctionInfo->startdate) {
                    return response(["status" => 400, "message" => "forbidden"]);
                    /* $cardamage = CarDamage::where('carid', $carId)->get();
                     foreach ($cardamage as $data) {
                         if (file_exists(storage_path('app/CarDamagePhotos') . '/' . $data->imageaddress)) {
                             unlink(storage_path('app/CarDamagePhotos') . '/' . $data->imageaddress);
                         }
                     }
                     $auctionInfo->delete();*/
                }
            }

            $carInfo->active = 0;
            $carInfo->save();

            /*$carcertified = CarCertified::where('carid', $carId)->get();
            foreach ($carcertified as $data) {
                if (file_exists(storage_path('app/CarCertifieds') . '/' . $data->imageaddress)) {
                    unlink(storage_path('app/CarCertifieds') . '/' . $data->imageaddress);
                }
            }
            $carfaxproof = CarFaxProof::where('carid', $carId)->get();
            foreach ($carfaxproof as $data) {
                if (file_exists(storage_path('app/CarFaxProofs') . '/' . $data->imageaddress)) {
                    unlink(storage_path('app/CarFaxProofs') . '/' . $data->imageaddress);
                }
            }
            $carinspection = CarInspection::where('carid', $carId)->get();
            foreach ($carinspection as $data) {
                if (file_exists(storage_path('app/CarInspections') . '/' . $data->imageaddress)) {
                    unlink(storage_path('app/CarInspections') . '/' . $data->imageaddress);
                }
            }
            $carpicture = CarPicture::where('carid', $carId)->get();
            foreach ($carpicture as $data) {
                if (file_exists(storage_path('app/CarPictures') . '/' . $data->imageaddress)) {
                    unlink(storage_path('app/CarPictures') . '/' . $data->imageaddress);
                }
            }
            $carservice = CarService::where('carid', $carId)->get();
            foreach ($carservice as $data) {
                if (file_exists(storage_path('app/CarServices') . '/' . $data->imageaddress)) {
                    unlink(storage_path('app/CarServices') . '/' . $data->imageaddress);
                }
            }

            RelationCarOption::where('carid',$carInfo->id)->delete();
            RelationCarModification::where('carid',$carInfo->id)->delete();
            RelationCarDisclosure::where('carid',$carInfo->id)->delete();
            RelationCarMechanicalIssue::where('carid',$carInfo->id)->delete();
            RelationCarWarningLight::where('carid',$carInfo->id)->delete();

            $carInfo->delete();*/

            return response(["status" => 200, "message" => "AuctionCar Deleted !!"]);

        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function EditCar($carId) {
        try {
            $carInfo = Car::where('id',$carId)->first();

            $carInfo->bodytypeid = $carInfo->BodyType->title;
            $carInfo->drivetrain = $carInfo->DriveTrain->title;
            $carInfo->transmission = $carInfo->Transmission->title;
            $carInfo->fueltypeid = $carInfo->FuelType->title;
            $carInfo->enginetypeid = $carInfo->EngineType->title;
            $carInfo->condition = $carInfo->Condition->title;
            $carInfo->accident = $carInfo->Accident->title;
            $carInfo->make = $carInfo->Make->title;
            $carInfo->model = $carInfo->Model->title;
            $carInfo->picture = CarPicture::where('carid',$carInfo->id);
            $carInfo->faxproof = CarFaxProof::where('carid',$carInfo->id);
            $carInfo->certified = CarCertified::where('carid',$carInfo->id);
            $carInfo->inspection = CarInspection::where('carid',$carInfo->id);
            $carInfo->service = CarService::where('carid',$carInfo->id);

            if ($carInfo->auction == 1) {
                //$auctionInfo = $carInfo->Auction;
                $auctionInfo = AuctionInfo::where('carid',$carId)->first();
                $carInfo->auctionInfo =  $auctionInfo;
                $carInfo->damage = CarDamage::where('carid',$carInfo->id)->get();
            }
            else {
                $carInfo->auctionInfo =  "";
            }

            return response(["status" => 200, "message" => "Car Detail", "data" => $carInfo]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function UpdateCar(Request $request) {
        try {
            $validation_message = array();
            $validation = Validator::make($request->all(),$this->updaterules);
            if ($validation->fails()) {
                foreach ($validation->errors()->getMessages() as $message) {
                    $validation_message[] = $message;
                }
            }

            if ($validation_message != []) {
                return response(["status" => 400, "message" => $validation_message]);
            }

            $carId = $request->input('carId');

            $car = Car::whereId($carId)->first();

            $car->price = $request->input('price');
            $car->discounttype = $request->input('discounttype');
            $car->discount = $request->input('discount');
            $car->make = $request->input('make');
            $car->model = $request->input('model');
            $car->year = $request->input('year');
            $car->mileage = $request->input('mileage');
            $car->color = $request->input('color');
            $car->bodytypeid = $request->input('bodytypeid');
            $car->drivetrain = $request->input('drivetrain');
            $car->transmission = $request->input('transmission');
            $car->fueltypeid = $request->input('fueltypeid');
            $car->enginetypeid = $request->input('enginetypeid');
            $car->condition = $request->input('condition');
            $car->accident = $request->input('accident');
            $car->door = $request->input('door');
            $car->vinnumber = $request->input('vinnumber');
            $car->description = $request->input('description');
            $car->auction = $request->input('auction');

            $car->save();

            foreach ($request->file('picture') as $carpicture) {
                if (file_exists(storage_path('app/CarPictures') . '/' . $carpicture->getClientOriginalName())) {
                    $PictureName = $car->userid . $carpicture->getClientOriginalName();
                } else {
                    $PictureName = $carpicture->getClientOriginalName();
                }
                $carpicture->storeAs('CarPictures', $PictureName);

                $newcarpicture = new CarPicture();

                $newcarpicture->carid = $carId;
                $newcarpicture->imageaddress = $PictureName;

                $newcarpicture->save();
            }

            foreach ($request->input('removepicture') as $data) {
                $removecarpicture = CarPicture::whereId($data)->first();

                if (file_exists(storage_path('app/CarPictures') . '/' . $removecarpicture->imageaddress)) {
                    unlink(storage_path('app/CarPictures') . '/' . $removecarpicture->imageaddress);
                }

                $removecarpicture->delete();
            }

            foreach ($request->file('certified') as $carcertified) {
                if (file_exists(storage_path('app/CarCertifieds') . '/' . $carcertified->getClientOriginalName())) {
                    $CertifiedName = $car->userid . $carcertified->getClientOriginalName();
                } else {
                    $CertifiedName = $carcertified->getClientOriginalName();
                }
                $carcertified->storeAs('CarCertifieds', $CertifiedName);

                $newcarcertified = new CarCertified();

                $newcarcertified->carid = $carId;
                $newcarcertified->imageaddress = $CertifiedName;

                $newcarcertified->save();
            }

            foreach ($request->input('removecertified') as $data) {
                $removecertified = CarCertified::whereId($data)->first();

                if (file_exists(storage_path('app/CarCertifieds') . '/' . $removecertified->imageaddress)) {
                    unlink(storage_path('app/CarCertifieds') . '/' . $removecertified->imageaddress);
                }

                $removecertified->delete();
            }

            foreach ($request->file('carfaxproof') as $carfaxproof) {
                if (file_exists(storage_path('app/CarFaxProofs') . '/' . $carfaxproof->getClientOriginalName())) {
                    $FaxProofName = $car->userid . $carfaxproof->getClientOriginalName();
                } else {
                    $FaxProofName = $carfaxproof->getClientOriginalName();
                }
                $carfaxproof->storeAs('CarFaxProofs', $FaxProofName);

                $newcarfaxproof = new CarFaxProof();

                $newcarfaxproof->carid = $carId;
                $newcarfaxproof->imageaddress = $FaxProofName;

                $newcarfaxproof->save();
            }

            foreach ($request->input('removefaxproof') as $data) {
                $removecarfaxproof = CarFaxProof::whereId($data)->first();

                if (file_exists(storage_path('app/CarFaxProofs') . '/' . $removecarfaxproof->imageaddress)) {
                    unlink(storage_path('app/CarFaxProofs') . '/' . $removecarfaxproof->imageaddress);
                }

                $removecarfaxproof->delete();
            }

            foreach ($request->file('inspection') as $carinspection) {
                if (file_exists(storage_path('app/CarInspections') . '/' . $carinspection->getClientOriginalName())) {
                    $CarInspectionName = $car->userid . $carinspection->getClientOriginalName();
                } else {
                    $CarInspectionName = $carinspection->getClientOriginalName();
                }
                $carinspection->storeAs('CarInspections', $CarInspectionName);

                $newcarinspection = new CarInspection();

                $newcarinspection->carid = $carId;
                $newcarinspection->imageaddress = $CarInspectionName;

                $newcarinspection->save();
            }

            foreach ($request->input('removeinspection') as $data) {
                $removeinspection = CarInspection::whereId($data)->first();

                if (file_exists(storage_path('app/CarInspections') . '/' . $removeinspection->imageaddress)) {
                    unlink(storage_path('app/CarInspections') . '/' . $removeinspection->imageaddress);
                }

                $removeinspection->delete();
            }

            foreach ($request->file('service') as $carservice) {
                if (file_exists(storage_path('app/CarServices') . '/' . $carservice->getClientOriginalName())) {
                    $CarServiceName = $car->userid . $carservice->getClientOriginalName();
                } else {
                    $CarServiceName = $carservice->getClientOriginalName();
                }
                $carservice->storeAs('CarServices', $CarServiceName);

                $newcarservice = new CarService();

                $newcarservice->carid = $carId;
                $newcarservice->imageaddress = $CarServiceName;

                $newcarservice->save();
            }

            foreach ($request->input('removeservice') as $data) {
                $removeservice = CarService::whereId($data)->first();

                if (file_exists(storage_path('app/CarServices') . '/' . $removeservice->imageaddress)) {
                    unlink(storage_path('app/CarServices') . '/' . $removeservice->imageaddress);
                }

                $removeservice->delete();
            }

            if ($request->input('option') != null && $request->input('option') != []) {
                RelationCarOption::where('carid',$carId)->delete();

                foreach ($request->input('option') as $data) {
                    $relationcaroption = new RelationCarOption();

                    $relationcaroption->carid = $carId;
                    $relationcaroption->optionid = $data;

                    $relationcaroption->save();
                }
            }

            if ($request->input('modification') != null && $request->input('modification') != []) {
                RelationCarModification::where('carid',$carId)->delete();

                foreach ($request->input('modification') as $data) {
                    $relationcarmodification = new RelationCarModification();

                    $relationcarmodification->carid = $carId;
                    $relationcarmodification->modificationid = $data;

                    $relationcarmodification->save();
                }
            }

            if ($request->input('disclusure') != null && $request->input('disclusure') != []) {
                RelationCarDisclosure::where('carid',$carId)->delete();

                foreach ($request->input('disclusure') as $data) {
                    $relationcardisclusure = new RelationCarDisclosure();

                    $relationcardisclusure->carid = $carId;
                    $relationcardisclusure->disclosureid = $data;

                    $relationcardisclusure->save();
                }
            }

            if ($request->input('mechanicalissue') != null && $request->input('mechanicalissue') != []) {
                RelationCarMechanicalIssue::where('carid',$carId)->delete();

                foreach ($request->input('mechanicalissue') as $data) {
                    $relationcarmechanicalissue = new RelationCarMechanicalIssue();

                    $relationcarmechanicalissue->carid = $carId;
                    $relationcarmechanicalissue->mechanicalissueid = $data;

                    $relationcarmechanicalissue->save();
                }
            }

            if ($request->input('warninglight') != null && $request->input('warninglight') != []) {
                RelationCarWarningLight::where('carid',$carId)->delete();

                foreach ($request->input('warninglight') as $data) {
                    $relationcarwarninglight = new RelationCarWarningLight();

                    $relationcarwarninglight->carid = $carId;
                    $relationcarwarninglight->warninglightid = $data;

                    $relationcarwarninglight->save();
                }
            }

            if ($request->input('auction') == 1) {
                $auctioninfo = AuctionInfo::where('carid',$carId)->first();

                if (count($auctioninfo) == 0) {
                    $auctioninfo = new AuctionInfo();
                }
                $auctioninfo->carid = $car->id;
                $auctioninfo->registerprovinceid = $request->input('registerprovinceid');
                $auctioninfo->lien = $request->input('lien');
                $auctioninfo->unpaiddebt = $request->input('unpaiddebt');
                $auctioninfo->otherdisclusure = $request->input('otherdisclusure');

                foreach ($request->file('damagephoto') as $cardamagephoto) {
                    if (file_exists(storage_path('app/CarDamagePhotos') . '/' . $cardamagephoto->getClientOriginalName())) {
                        $CarDamagePhotoName = $car->userid . $cardamagephoto->getClientOriginalName();
                    } else {
                        $CarDamagePhotoName = $cardamagephoto->getClientOriginalName();
                    }
                    $cardamagephoto->storeAs('CarDamagePhotos', $CarDamagePhotoName);

                    $newcardamagephoto = new CarDamage();

                    $newcardamagephoto->carid = $carId;
                    $newcardamagephoto->imageaddress = $CarServiceName;

                    $newcardamagephoto->save();
                }

                foreach ($request->input('removedamagephoto') as $data) {
                    $removedamagephoto = CarDamage::whereId($data)->first();

                    if (file_exists(storage_path('app/CarDamagePhotos') . '/' . $removedamagephoto->imageaddress)) {
                        unlink(storage_path('app/CarDamagePhotos') . '/' . $removedamagephoto->imageaddress);
                    }

                    $removedamagephoto->delete();
                }

                $auctioninfo->startdate = $request->input('startdate');
                $auctioninfo->starttime = $request->input('starttime');
                $auctioninfo->starttoclose = $request->input('starttoclose');
                $auctioninfo->decisiontime = $request->input('decisiontime');
                $auctioninfo->tasktime = $request->input('tasktime');
                $auctioninfo->auctiondealclearingtime = $request->input('auctiondealclearingtime');
                $auctioninfo->claim = $request->input('claim');
                $auctioninfo->investigationtime = $request->input('investigationtime');
                $auctioninfo->claimdealclearingtime = $request->input('claimdealclearingtime');
                $auctioninfo->carpagertime = $request->input('carpagertime');
                $auctioninfo->startprice = $request->input('startprice');
                $auctioninfo->minreservedprice = $request->input('minreservedprice');

                $auctioninfo->save();
            }
            else {
                AuctionInfo::where('carid',$carId)->delete();
            }
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function ActiveCar(Request $request) {
        try {
            $car = Car::where('id',$request->input('carId'))->first();

            if ($car->auction == 2) {

                $car->active = 1;
                $car->save();
            }
            else {
                return response(["status" => 400, "message" => "Car In Auction, You Cant Change Active Status"]);
            }
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }

    public function SearchCar(Request $request) {
        try {
            $validation_message = array();
            $validation = Validator::make($request->all(),$this->searchrules);
            if ($validation->fails()) {
                foreach ($validation->errors()->getMessages() as $message) {
                    $validation_message[] = $message;
                }
            }

            if ($validation_message != []) {
                return response(["status" => 400, "message" => $validation_message]);
            }

            $cars = Car::where('active',1)->orderBy('id','DESC');
            foreach ($request->all() as $key => $value){
                if ($value != null){
                    switch ($key) {
                        case "PriceSearch":
                            $value = explode("-",$value);
                            $cars->where('price','>=',$value[0])->where('price','<=',$value[1]);
                            break;
                        case "MakeSearch":
                            $cars->where('make','=',$value);
                            break;
                        case "ModelSearch":
                            $cars->where('model','=',$value);
                            break;
                        case "YearSearch":
                            $cars->where('year','>=',$value);
                            break;
                        case "MileageSearch":
                            $cars->where('mileage','<=',$value);
                            break;
                        case "ConditionSearch":
                            $cars->where('condition','=',$value);
                            break;
                        case "BodyTypeSearch":
                            $cars->where('bodytypeid','=',$value);
                            break;
                        case "DriveTrainSearch":
                            $cars->where('drivetrain','=',$value);
                            break;
                        case "TransmissionSearch":
                            $cars->where('transmission','=',$value);
                            break;
                        case "FuelTypeSearch":
                            $cars->where('fueltypeid','=',$value);
                            break;
                        case "AccidentSearch":
                            $cars->where('accident','=',$value);
                            break;
                        case "AuctionFlagSearch":
                            $cars->where('auction','=',$value);
                            break;
                        case "ListedDateSearch":
                            $cars->where('created_at','>=',$value);
                            break;
                        case "KeyWordSearch":
                            $cars->where('description','like',"%".$value."%");
                            break;
                    }
                }
            }
            $cars = $cars->skip($request->input('skip'))->take($request->input('take'));

            return response(["status" => 200, "message" => "Cars List !!", "data" => $cars]);
        }
        catch (\Exception $e) {
            return response(["status" => 400, "message" => $e->getMessage()]);
        }
    }
}
