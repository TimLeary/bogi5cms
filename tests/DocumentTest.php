<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Description;
use App\Document;
use App\DocumentLink;

class DocumentTest extends TestCase
{
    use DatabaseTransactions;

    protected $faker;

    public function setUp()
    {
        parent::setUp();
        $this->faker = Faker\Factory::create();
    }

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

    /**
     * @test
     */
    public function it_could_has_link()
    {
        $description = factory(Description::class)->create();
        $document = new Document();
        $document->name_description_id = $description->id;
        $document->save();
        $link = new DocumentLink();
        $link->document_id = $document->id;
        $link->link = $this->faker->url;
        $link->save();
        $this->assertEquals($document->getDocumentLink(), $link->link);
    }

    /**
     * @test
     */
    public function it_could_be_navigation()
    {
        
    }
}
