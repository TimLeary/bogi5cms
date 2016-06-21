<?php

namespace App\Console\Commands;

use App\Description;
use App\Document;
use App\DocumentDescriptions;
use App\DocumentLanguage;
use Illuminate\Console\Command;
use App\Language;
use Illuminate\Support\Facades\Config;

class createDocumentFromJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create-document-from-json {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It creates documents from json file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');
        $documentsData = json_decode(file_get_contents($file), true);

        if($documentsData){
            foreach ($documentsData as $documentData) {
                $documentId = $this->createDocument($documentData);
                if(!empty($documentData["descriptions"])) {
                    $this->makeDocumentDescriptions($documentData, $documentId);
                }

                if(!empty($documentsData["languages"])) {
                    $this->makeDocumentLanguages($documentsData["languages"], $documentId);
                } else {
                    $this->makeDocumentLanguages([Language::getDefaultLanguageCode()], $documentId);
                }
            }
        }
    }

    protected function makeDocumentLanguages(array $languages, $documentId){
        $languageCodes = Language::getLanguageCodes();

        $numLanguages = count($languages);
        for($i = 0; $i < $numLanguages; $i++){
            $documentLanguage = new DocumentLanguage();
            $documentLanguage->language_id = $languageCodes[$languages[$i]];
            $documentLanguage->document_id = $documentId;
            $documentLanguage->save();
        }
    }

    protected function makeDocumentDescriptions($documentData, $documentId) {
        $numDescriptions = count($documentData["descriptions"]);
        for($i = 0; $i < $numDescriptions; $i++){
            $descriptionType = Config::get('taxonomies.document_description_types.'.$documentData["descriptions"][$i]["type"]);

            $documentDescription = new DocumentDescriptions();
            $documentDescription->document_id = $documentId;
            $documentDescription->type_taxonomy_id = $descriptionType;
            $documentDescription->description_id = (new Description())->saveDescriptionsFromArray($documentData["descriptions"][$i]["description"]);
            $documentDescription->save();
        }
    }

    protected function createDocument($documentData)
    {
        $descriptionModel = new Description();
        $nameId = $descriptionModel->saveDescriptionsFromArray($documentData["name"]);
        $document = new Document();
        $document->name_description_id = $nameId;
        $document->type_taxonomy_id = Config::get("taxonomies.document_types.".$documentData["type"]);
        $document->is_active = $documentData["is_active"];
        $document->save();
        if($documentData["parent_id"]){
            $document->makeChildOf($documentData["parent_id"]);
        }

        return $document->id;
    }
}
