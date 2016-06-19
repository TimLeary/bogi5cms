<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use App\Taxonomy;

class DocumentDescriptionTypeSeeder extends Seeder
{
    use TaxonomySeederTraits;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->createTaxonomyAndItChilds('document_description_type');
    }
}