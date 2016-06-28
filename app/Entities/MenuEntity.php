<?php

namespace app\Entities;

use App\Document;
use App\Language;
use App\Taxonomy;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MenuEntity
{
    public function getMenuByName($name)
    {
        $menuId = DB::table('documents AS d')
            ->whereNull('d.deleted_at')
            ->join('descriptions AS desc', 'd.name_description_id', '=', 'desc.id')
            ->where('desc.description', $name)
            ->where('d.type_taxonomy_id', Config::get('taxonomies.document_types.navigation'))
            ->value('d.id');

        if($menuId) {
            return $this->generateMenu($menuId);
        } else {
            return null;
        }
    }

    public function generateMenu($menuId) {
        $menuItems = Document::find($menuId)->getChildren();
        $numMenuItems = count($menuItems);

        $menu = [];

        for ($i = 0; $i < $numMenuItems; $i++){
            $element = [];
            $element['type'] = $menuItems[$i]->type->name;

            $name = $menuItems[$i]->name;
            $element['name'][Language::getDefaultLanguageCode()] = $name->description;

            $translations = $name->translations;
            $numTranslations = count($translations);
            for($j = 0; $j < $numTranslations; $j++) {
                $element['name'][$translations[$j]->language->iso_code] = $translations[$j]->description;
            }

            if($menuItems[$i]->has_descendants) {
                $element['childs'] = $this->generateMenu($menuItems[$i]->id);
            }

            $menu[] = $element;
        }

        return $menu;
    }
}