<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DescriptionTranslation extends Model
{
    use SoftDeletes;

    protected $fillable = ['description_id', 'language_id', 'description'];
    
    public function description()
    {
        return $this->hasOne(Description::class);
    }
    
    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
}
