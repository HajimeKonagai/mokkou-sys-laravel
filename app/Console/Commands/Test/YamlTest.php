<?php

namespace App\Console\Commands\Test;

use Illuminate\Console\Command;
use Illuminate\Routing\Router;
use Illuminate\Routing\Route;
use ReflectionClass;
use ReflectionFunction;
use Symfony\Component\Yaml\Yaml;
use App\Services\GenerateSwaggerYamlService;

class YamlTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:yaml-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $router;

    public function __construct(Router $router)
    {
        parent::__construct();

        $this->router = $router;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $s = new GenerateSwaggerYamlService;
        $s->generate();

        return;

        foreach ($this->router->getRoutes() as $route)
        {
            //dump($route->uri());
            //dump($route->getController());
            //dump($route->getControllerClass());
            dump(in_array('App\Http\Middleware\SwaggerRoute', $this->router->gatherRouteMiddleware($route)));
            /*
            dump($route->methods());
            dump(ltrim($route->getActionName(), '\\'));
            dump($this->isVendorRoute($route));
            */
        }

        /*
        $routes = (new Collection($this->router->getRoutes()))->map(function ($route) {
            return $this->getRouteInformation($route);
        })->filter()->all();
        */
        return;

        dump(Yaml::dump([
            'a' => 'b',
            'c' => [
                1 , 2, 3
            ],
            'D' => [
                'a' => 'b'
            ]
        ]));
    }

    protected function isVendorRoute(Route $route)
    {
        if ($route->action['uses'] instanceof Closure) {
            $path = (new ReflectionFunction($route->action['uses']))
                                ->getFileName();
        } elseif (is_string($route->action['uses']) &&
                  str_contains($route->action['uses'], 'SerializableClosure')) {
            return false;
        } elseif (is_string($route->action['uses'])) {
            if ($this->isFrameworkController($route)) {
                return false;
            }

            $path = (new ReflectionClass($route->getControllerClass()))
                                ->getFileName();
        } else {
            return false;
        }

        return str_starts_with($path, base_path('vendor'));
    }

    protected function isFrameworkController(Route $route)
    {
        return in_array($route->getControllerClass(), [
            '\Illuminate\Routing\RedirectController',
            '\Illuminate\Routing\ViewController',
        ], true);
    }

}
