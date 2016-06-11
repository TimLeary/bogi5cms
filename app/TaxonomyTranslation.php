<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxonomyTranslation extends Model
{
    use SoftDeletes,
        ModelValidatorTrait;
    
    protected $fillable = ['language_id', 'taxonomy_id', 'name'];
    
    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
    
    public function taxonomy()
    {
        return $this->hasOne(Taxonomy::class, 'id', 'taxonomy_id');
    }
}
