<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GenerateSwaggerYamlService;
use Symfony\Component\Yaml\Yaml;

class SwaggerController extends Controller
{

    public function __invoke()
    {
        $swagger = GenerateSwaggerYamlService::generate();
        return response($swagger);
    }

    public function yaml()
    {
        $swagger = GenerateSwaggerYamlService::generate();

        return Yaml::dump($swagger, 99, 4);
       // , Yaml::DUMP_OBJECT | Yaml::DUMP_OBJECT_AS_MAP);// | Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
    }


    public function download_yaml()
    {
        return response($this->yaml())
            ->header('Content-Type', 'text/yaml')
            ->header('Content-Disposition', 'attachment; filename="mokkou.swagger.yaml"');
    }

}
