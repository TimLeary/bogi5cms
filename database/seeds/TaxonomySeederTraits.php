<?php

use Illuminate\Support\Facades\Config;
use App\Taxonomy;

trait TaxonomySeederTraits {
    public function createTaxonomyAndItChilds($taxonomyName){
        $baseTx = new Taxonomy(['id' => Config::get('taxonomies.'.$taxonomyName), 'name' => $taxonomyName]);
        $baseTx->save();

        foreach (Config::get('taxonomies.'.$taxonomyName.'s') as $name => $id) {
            $tx = new Taxonomy();
            $tx->id = $id;
            $tx->name = $name;
            $tx->save();
            $tx->makeChildOf($baseTx);
        }
    }
}