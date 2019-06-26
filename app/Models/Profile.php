<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function spec()
    {
        return $this->belongsTo('App\Models\Spec');
    }

}
