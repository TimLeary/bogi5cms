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
        return $this->hasOne(Description::class, 'id', 'description_id');
    }
    
    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }

    public function saveDescriptionTranslationsFromArray($descriptionTranslations, $descriptionId)
    {
        $languageCodes = Language::getLanguageCodes();
        $defaultLanguageCode = Language::getDefaultLanguageCode();
        unset($languageCodes[Language::getDefaultLanguageCode()]);

        unset($descriptionTranslations[$defaultLanguageCode]);

        if(!empty($descriptionTranslations)){
            foreach ($descriptionTranslations as $languageCode => $translation) {
                $newTranslation = new self;
                $newTranslation->description_id = $descriptionId;
                $newTranslation->language_id = $languageCodes[$languageCode];
                $newTranslation->description = $translation;
                $newTranslation->save();
            }
        }
    }
}
