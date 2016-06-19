<?php

namespace App\Console\Commands;

use App\Description;
use App\Document;
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
        $documentsData = json_decode(file_get_contents($file));

        $defaultLanguage = Language::getDefaultLanguage();
        $defaultLanguageCode = $defaultLanguage->iso_code;

        dd($defaultLanguageCode);

        if($documentsData){


            foreach ($documentsData as $documentData) {
                $documentId = $this->createDocument($documentData);

                if(!empty($documentsData["descriptions"])){
                    $numDescriptions = count($documentsData["descriptions"]);
                    for($i = 0; $i < $numDescriptions; $i++){

                    }
                }
            }
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
