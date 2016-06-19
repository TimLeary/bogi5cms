<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Language extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['iso_code'];

    public function taxonomy()
    {
        return $this->hasOne(Taxonomy::class);
    }
    
    static public function getLanguageCodes($database = null) {
        $connection = is_null($database) ? \Illuminate\Support\Facades\DB::connection() : \Illuminate\Support\Facades\DB::connection($database);
        return $connection->table('languages')->lists('id', 'iso_code');
    }

    static public function getDefaultLanguageCode() {
        return DB::table('languages')->where('is_default', 1)->value('iso_code');
    }

    static public function getDefaultLanguageId() {
        return DB::table('languages')->where('is_default', 1)->value('id');
    }

    static public function getDefaultLanguage() {
        return DB::table('languages')->where('is_default', 1)->first();
    }
}