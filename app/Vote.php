<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'voteable_action' => 'boolean'
    ];

    public function model()
    {
        return $this->morphTo();
    }

}
