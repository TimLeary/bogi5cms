<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Description;
use App\DescriptionTranslation;
use Illuminate\Support\Facades\Config;

class DescriptionTest extends TestCase
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
    public function it_can_be_created()
    {
        $desc = $this->faker->sentence;
        $description = new Description();
        $description->description = $desc;
        $this->assertTrue($description->save());
        $this->assertEquals($description->description, $desc);
    }

    /**
     * @test
     */
    public function it_can_saved_from_an_array()
    {
        $defaultLanguageCode = \App\Language::getDefaultLanguageCode();

        $descrtiptionArray = [
            $defaultLanguageCode => $this->faker->sentence
        ];

        $descriptionObj = new Description();
        $descId = $descriptionObj->saveDescriptionsFromArray($descrtiptionArray);

        $this->assertEquals(Description::find($descId)->description, $descrtiptionArray[$defaultLanguageCode]);
    }

    /**
     * @test
     */
    public function it_can_be_translated()
    {
        $description = factory(Description::class)->create();
        $descriptionTranslation = new DescriptionTranslation();
        $descriptionTranslation->description_id = $description->id;
        $descriptionTranslation->description = $translate = $this->faker->sentence;
        $descriptionTranslation->language_id = Config::get('taxonomies.languages.german.id');
        $descriptionTranslation->save();
        $this->assertEquals($description->translations[0]->description, $translate);
    }

    /**
     * @test
     */
    public function it_can_be_saved_with_translation_from_an_array()
    {
        $defaultLanguageCode = \App\Language::getDefaultLanguageCode();

        $descriptionArray = [
            $defaultLanguageCode => $this->faker->sentence,
            Config::get('taxonomies.languages.german.iso_code') => $this->faker->sentence
        ];

        $descId = (new Description())->saveDescriptionsFromArray($descriptionArray);

        $description = Description::find($descId);

        $this->assertEquals(
            $description->description,
            $descriptionArray[$defaultLanguageCode]
        );
        $this->assertEquals(
            $description->translations[0]->description,
            $descriptionArray[Config::get('taxonomies.languages.german.iso_code')]
        );
    }
}