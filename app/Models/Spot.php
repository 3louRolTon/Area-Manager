<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Spot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'spot_name',
        'information',
        'phone_number',
        'point_x',
        'point_y',
        'address',
        'district_id',
        'deputat_id',
        'city_id'
    ];

    static public function getByUser()
    {
        if(Auth::user()->hasRole('user')){
            return Spot::where('district_id', Auth::user()->district_id)->get();
        }

        return [];
    }
}
