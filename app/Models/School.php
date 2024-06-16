<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use \App\Models\Register;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city_id',
        'description',
        'user_id'
    ];


    public function registers()
    {
        return $this->hasMany(Register::class);
    }


    public function hasRelatedRegisters()
    {
        return $this->registers()->exists();
    }


}
