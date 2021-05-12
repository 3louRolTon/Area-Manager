<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vk',
        'ok',
        'telegram',
        'instagram',
        'facebook',
        'twitter',
        'site',
        'deputat_id'
    ];
}
