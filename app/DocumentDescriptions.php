<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentDescriptions extends Model
{
    use SoftDeletes;

    protected $fillable = ['document_id', 'type_taxonomy_id', 'description_id'];

    public function document()
    {
        return $this->hasOne(Document::class, 'id', 'document_id');
    }

    public function type()
    {
        return $this->hasOne(Taxonomy::class, 'id', 'type_taxonomy_id');
    }

    public function description()
    {
        return $this->hasOne(Description::class, 'id', 'description_id');
    }
}
