<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_name',
        'city_type',
        'city_category',
        'district_id',
        'spot_id',
    ];

    static public function getByUser()
    {
        if(Auth::user()->hasRole('user')){
            return City::where('district_id', Auth::user()->district_id)->get();
        }

        return [];
    }
}
