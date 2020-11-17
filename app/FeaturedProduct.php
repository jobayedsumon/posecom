<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class FeaturedProduct extends Model
{
    //
    protected $guarded = [];
    use LogsActivity;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
