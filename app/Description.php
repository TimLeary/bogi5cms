<?php

namespace App;

use Illuminate\Contracts\Validation\ValidationException;
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

    public function saveDescriptionsFromArray($descriptions)
    {
        $defaultLanguage = Language::getDefaultLanguage();
        $defaultLanguageCode = $defaultLanguage->iso_code;

        if(!empty($descriptions[$defaultLanguageCode])){
            $description = new self;
            $description->description = $descriptions[$defaultLanguageCode];
            $description->save();

            $descriptionId = $description->id;
            $translations = new DescriptionTranslation();
            $translations->saveDescriptionTranslationsFromArray($descriptions, $descriptionId);

            return $descriptionId;
        } else {
            throw new ValidationException('Description has not value in default language');
        }
    }

    public static function getDescriptionsArrayById($id)
    {
        $defaultLanguage = Language::getDefaultLanguage();
        $defaultLanguageCode = $defaultLanguage->iso_code;
        $description = self::find($id);
    }
}
