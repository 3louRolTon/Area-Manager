<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Deputat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name1',
        'name2',
        'name3',
        'district',
        'biography',
        'district_id',
    ];

    static public function getByUser()
    {
        if(Auth::user()->hasRole('user')){
            return Deputat::where('district_id', Auth::user()->district_id)->get();
        }

        return [];
    }
}
