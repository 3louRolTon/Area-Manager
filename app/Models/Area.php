<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Area extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'area_name',
    ];

    static public function getByUser()
    {
        if(Auth::user()->hasRole('super-admin')) {
            return Area::all();
        } else {
            return Area::where('id', Auth::user()->area_id)->get();
        }

    }

}
