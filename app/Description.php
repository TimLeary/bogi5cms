<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Description extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['description'];
    
    public function translations()
    {
        return $this->hasMany(DescriptionTranslation::class);
    }
}
