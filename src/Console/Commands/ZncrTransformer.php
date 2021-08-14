<?php

namespace ZncrTransformerGenerator\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ZncrTransformer extends Command
{
/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:zncr-transformer {class} {--model=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates transformer with fillable based properties';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model = $this->option('model');
        $class = $this->argument('class');
        if(!$model || !$class) return;

        $modelObj = new $model;

        $modelExploded = explode("\\", $model);

        $modelName = $modelExploded[count($modelExploded) - 1];
        $modelInstance = '$' . Str::camel($modelName);

        $fillableDisplay = "'id' => " . $modelInstance . "->id,\r\n";
        $fillables = $modelObj->getFillable();
        foreach($fillables as $key => $fillableItem){
            $fillableDisplay .= "\t\t\t" . "'" . $fillableItem . "' => " . $modelInstance . "->" . $fillableItem . "," . ($key != (count($fillables) - 1) ? "\r\n" : "");
        }

        $fileContent = file_get_contents(__DIR__ . '/../stubs/zncr-transformer.stub');

        $fileContent = str_replace('DummyNamespace', 'App\Transformers', $fileContent);
        $fileContent = str_replace('DummyModelPath', substr($model, 0, 1) == "\\" ? substr($model, 1) : $model, $fileContent);
        $fileContent = str_replace('DummyClass', $class, $fileContent);
        $fileContent = str_replace('DummyModelInstance', $modelInstance, $fileContent);
        $fileContent = str_replace('DummyModel', $modelName, $fileContent);
        $fileContent = str_replace('DummyFillable', $fillableDisplay, $fileContent);

        file_put_contents(app_path('Transformers/' . $class . '.php'), $fileContent);
    }
}