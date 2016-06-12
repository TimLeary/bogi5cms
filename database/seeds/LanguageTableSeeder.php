<?php 

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use App\Taxonomy;
use App\Language;

class LanguageTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		
        $languageTx = new Taxonomy(['id' => Config::get('taxonomies.language'), 'name' => 'language']);
        $languageTx->save();
        
        foreach (Config::get('taxonomies.languages') as $name => $properties) {
            $tx = new Taxonomy();
            $tx->id = $properties['id'];
            $tx->name = $name;
            $tx->save();
            $tx->makeChildOf($languageTx);
            
            $language = new Language(['taxonomy_id' => $properties['id'], 'iso_code' => $properties['iso_code']]);
            $language->id = $properties['language_id'];
            if (Config::get('taxonomies.default_language') == $name) {
                $language->is_default = 1;
            }
            $language->save();
        }
	}

}