<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Description;
use App\Document;

class DocumentTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_has_name()
    {
        $description = factory(Description::class)->create();
        $document = new Document();
        $document->name_description_id = $description->id;
        $document->save();

        $this->assertEquals($description->description, $document->name->description);
    }
}
