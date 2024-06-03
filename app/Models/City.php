<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class City extends Model
{
    use HasFactory;
    public $timestamps = true;

    public function getCitiesByRegionId(int $regionId)
    {
        return  City::where('region_id', $regionId)
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
    }
}
