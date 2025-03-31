<?php
namespace App\Services;

use Symfony\Component\Yaml\Yaml;
use Illuminate\Routing\Router;

use App\Http\Controllers\TodoController;
use App\Http\Controllers\Base\Crud;


class GenerateSwaggerYamlService
{
    public static $method_names = [
        'get', 'post', 'put', 'patch', 'delete',
    ];
    public static function generate()
    {
        $router = resolve(Router::class);
        $result = config('swagger.default');
        $result['servers'][] = [
            'url'=> url(''),
            'description' => env('APP_ENV', '').' server',
        ];

        $controllers = [];

        // ルーティングを取得
        foreach ($router->getRoutes() as $route)
        {
            $controller = $route->getController();

            if (is_subclass_of($controller, 'App\Http\Controllers\Base\Crud'))
            {
                $controllers[] = $controller;

                // uri
                if (!isset($result['paths']['/'.$route->uri()]))
                {
                    $result['paths']['/'.$route->uri()] = [];
                }

                // example のためにモデルも取得
                $mainModel = $controller::mainModel();
                $mainQuery = $mainModel::query()
                    ->with($controller::mainModelWith());

                // config を取得
                $config = config('blu.'.strtolower(last(explode('\\',$mainModel))));

                // method
                foreach ($route->methods() as $method)
                {
                    // method を限定
                    $method_name = strtolower($method);
                    if (!in_array($method_name, static::$method_names)) continue;
                    // action を取る
                    $action = $route->getActionMethod();

                    $action_template = null;
                    switch($action)
                    {
                    case 'index':
                        $action_template = static::action_index($mainModel, $mainQuery, $config);
                        break;
                    case 'show':
                        $action_template = config('swagger.template.actions.show');
                        $action_template['responses']['200']['content']['application/json']['schema']['example'] = $mainQuery->first()->toArray();
                        break;
                    case 'store':
                        $action_template = config('swagger.template.actions.store');
                        $action_template['requestBody']['content']['application/json']['example'] = config('swagger.demo_data.'.strtolower(last(explode('\\',$mainModel))))[0];
                        break;
                    case 'update':
                        $action_template = config('swagger.template.actions.update');
                        $action_template['requestBody']['content']['application/json']['example'] = $mainQuery->first()->toArray();
                        break;
                    case 'destroy':
                        $action_template = config('swagger.template.actions.delete');
                        break;
                    default:
                        break;
                    }

                    if ($action_template)
                    {
                        // basic properties
                        $model_name = last(explode('\\',$mainModel));
                        $action_template['operationId'] = $route->getName() ?: strtolower($model_name).'.'.$action;
                        $action_template['tags'] = [$model_name];
                        $action_template = static::replace_model_name($action_template, $model_name);

                        $result['paths']['/'.$route->uri()][$method_name] = $action_template;
                    }
                    // dump($route->getControllerClass());
                    // dump(TodoController::class);
                    // dump($template_action);
                    // $result['paths'][$route->uri()][];
                }
                
                // dump($route->parameterNames());
            }
        }


        /**
         * components
         */
        foreach ($controllers as $controller)
        {
            $mainModel = $controller::mainModel();
            $config = config('blu.'.strtolower(last(explode('\\',$mainModel))));

            $template = static::componentsSchemaModel($mainModel, $config);
            $model_name = last(explode('\\',$mainModel));
            $result['components']['schemas'][$model_name] = $template;

            /**
             * relations
             */
            $mainModelWith = $controller::mainModelWith();

            foreach ($mainModelWith as $with)
            {
                $parentModel = $mainModel;
                $rels = explode('.', $with);
                foreach ($rels as $rel)
                {
                    $parentModelItem = new $parentModel;
                    $relationModel = get_class($parentModelItem->{$rel}()->getRelated());
                    $relationModelName = last(explode('\\',$relationModel));

                    if (isset($result['components']['schemas'][$relationModelName]))
                    {
                        if (\Arr::get($config, $with))
                        {

                            $r_template = static::componentsSchemaModel($mainModel, $config[$with][$config[$with]['type']]['config']);
                            $result['components']['schemas'][$relationModelName] = $r_template;
                        }
                    }
                    
                    if (
                        is_a($parentModelItem->{$rel}(), 'Illuminate\Database\Eloquent\Relations\HasMany') ||
                        is_a($parentModelItem->{$rel}(), 'Illuminate\Database\Eloquent\Relations\BelongsToMany')
                    )
                    {
                        \Arr::set($result['components']['schemas'][last(explode('\\',$parentModel))], 'properties.'.$rel, [
                            'type' => 'array',
                            'items' => [
                                '$ref' => '#/components/schemas/'. $relationModelName,
                            ]
                        ]);
                    }
                    else
                    {
                        \Arr::set($result['components']['schemas'][last(explode('\\',$parentModel))], 'properties.'.$rel, [
                            '$ref' => '#/components/schemas/'. $relationModelName,
                        ]);
                    }


                    $parentModel = $relationModel;
                }
            }


        }

        /**
         * GET 時の components
         */


        /**
         * POST 時の components
         */

        return $result;
    }

    private static function componentsSchemaModel($mainModel, $config)
    {
        $model_name = last(explode('\\',$mainModel));

        $template = config('swagger.template.components.schemas');

        $required = [];
        $properties = [];

        $example = $mainModel::first();

        $default_types = [
            'text',
            'seq',
            'textarea',
            'select',
            'radio',
            'checkbox',
            'number',
            'range',
            'search',
            'tel',
            'email',
            'datetime-local',
            'date',
            'time',
            'month',
            'week',
            'url',
            // 'password', どっちにしても生で保存しないので、ここでは関与しない
            'hidden',
            'reference', // blu の独自フィールド
        ];


        foreach ($config as $key => $val)
        {
            // relation をスキップ
            if (isset($val['type']) && !in_array($val['type'], $default_types)) continue;

            if (\Arr::get($val, 'required', false)) $required[] = $key;

            $property = static::convert_type_to_schema($val['type']);
            $property['example'] = $example->{$key};
            if (\Arr::get($val, 'label', null)) $property['description'] = $val['label'];
            $properties[$key] = $property;
        }

        if ($required) $template['required'] = $required;
        $template['properties'] = $properties;

        return $template;
    }


    private static function replace_model_name($template, $model_name)
    {
        foreach ($template as $key => $val)
        {
            if (is_array($val))
            {
                $template[$key] = static::replace_model_name($val, $model_name);
            }
            else
            {
                if (strpos($val, '{MODEL_NAME}') !== false)
                {
                    $template[$key] = str_replace('{MODEL_NAME}', $model_name, $val);
                }
            }
        }

        return $template;
    }

    private static function action_index($mainModel, $mainQuery, $config)
    {
        $template = config('swagger.template.actions.index');

        // parameters
        $parameters = [];
        foreach ($config as $key => $val)
        {
            if (!isset($val['search'])) continue;

            foreach ($val['search'] as $s_key => $searchConfig)
            {
                $compare = isset($searchConfig['compare']) ? strtoupper($searchConfig['compare']) : '=';
                $searchField = isset($searchConfig['field']) ? $searchConfig['field'] : $key;

                $parameters[] = [
                    'name' => $s_key,
                    'in' => 'query',
                    'required' => false,
                    'schema' => static::convert_type_to_schema($searchConfig['type']),
                    'description' => $searchField.' '.$compare.' {value}',
                ];

                // TODO: format
                if ($searchConfig['type'] == 'date')
                {
                    $parameters['schema']['format'] = 'date';
                }
            }
        }
        $template['parameters'] = $parameters;

        // example from database
        $template['responses']['200']['content']['application/json']['schema']['example'] = $mainQuery->paginate(3)->toArray();

        return $template;
    }




    private static function convert_type_to_schema($type)
    {
        // boolean integer string array object
        switch ($type)
        {
        case 'seq':
        case 'select':
        case 'number':
        case 'radio':
            return [
                'type' => 'integer'
            ];
        // TODO: valid types
        /*
        case 'range':
        case 'search':
        case 'tel':
        case 'email':
        case 'datetime-local':
        case 'date':
        case 'time':
        case 'month':
        case 'week':
        case 'url':

        case 'checkbox':
            return 'array';
        case 'text',:
        case 'textarea':
            */

        }

        return [
            'type' => 'string'
        ];
    }
}