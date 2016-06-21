<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentLanguage extends Model
{
    use SoftDeletes;

    protected $fillable = ['document_id', 'language_id'];

    public function document()
    {
        return $this->hasOne(Document::class, 'id', 'document_id');
    }

    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }

}
