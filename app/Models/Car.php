<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    public function BodyType() {
        return $this->belongsTo(CarBodyType::class, 'bodytypeid');
    }

    public function DriveTrain() {
        return $this->belongsTo(CarDriveTrain::class, 'drivetrain');
    }

    public function Transmission() {
        return $this->belongsTo(CarTransmission::class, 'transmission');
    }

    public function FuelType() {
        return $this->belongsTo(CarFuelType::class, 'fueltypeid');
    }

    public function EngineType() {
        return $this->belongsTo(CarEngineType::class, 'enginetypeid');
    }

    public function Condition() {
        return $this->belongsTo(CarCondition::class, 'condition');
    }

    public function Accident() {
        return $this->belongsTo(CarAccident::class, 'accident');
    }

    public function Make() {
        return $this->belongsTo(CarMake::class, 'make');
    }

    public function Model() {
        return $this->belongsTo(CarModel::class, 'model');
    }
}
