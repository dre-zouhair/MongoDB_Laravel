<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Medicine extends Eloquent
{
    protected $collection = 'medicines';
    protected $guarded = [];
    public function laboratory()
    {
        return $this->embedsOne(Laboratory::class,'laboratory');
    }
}
