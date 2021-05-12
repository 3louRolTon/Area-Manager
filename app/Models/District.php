<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class District extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'district_name',
        'area_id'
    ];

    static public function getByUser()
    {
        if(Auth::user()->hasRole('admin')) {
            return District::all();
        } elseif(Auth::user()->hasRole('user')){
            return District::where('id', Auth::user()->district_id)->get();
        }

        return [];
    }
}
