<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use App\Taxonomy;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $documentTx = new Taxonomy(['id' => Config::get('taxonomies.document_type'), 'name' => 'document_type']);
        $documentTx->save();

        foreach (Config::get('taxonomies.document_types') as $name => $id) {
            $tx = new Taxonomy();
            $tx->id = $id;
            $tx->name = $name;
            $tx->save();
            $tx->makeChildOf($documentTx);
        }
    }
}
