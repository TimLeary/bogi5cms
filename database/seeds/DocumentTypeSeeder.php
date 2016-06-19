<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DocumentTypeSeeder extends Seeder
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

        $this->createTaxonomyAndItChilds('document_type');
    }
}
