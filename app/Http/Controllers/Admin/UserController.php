<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Base\Crud;
use Inertia\Inertia;
use App\Models\User as MainModel;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;

class UserController extends Crud
{
    protected static function configs()
    {
        $configs = parent::configs();
        $product_options = Product::get()->toArray();

        $configs['config']['product']['options'] = $product_options;

        return $configs;
    }

    public static function mainModel()
    {
        return MainModel::class;
    }

    public static function mainModelWith()
    {
        return ['product'];
    }

    public function index(Request $request)
    {
        $mainModel = static::mainModel();
        $query = $mainModel::supplier(); // supplier only
        $query->with(static::mainModelWith());

        if ($request->expectsJson())
        {
            return \Blu\Query::itemsByRequest(
                $request,
                static::config(),
                $query,
                static::$perPage
            );
        }

        return Inertia::render(static::viewDir().'Index', [
            'config' => static::config(),
            'indexConfig' => static::indexConfig(),
            'searchConfig' => static::searchConfig()
        ]);
    }

    public function show(Request $request, MainModel $id)
    {
        return static::_show($request, $id);
    }

    public function create(Request $request)
    {
        $config = static::config();
        $config['password']['required'] = true;
        $config['password_confirmation']['required'] = true;
        return Inertia::render(static::viewDir().'Create', [
            'config' => $config,
            'formConfig' => [
                'name',
                'email',
                'password',
                'password_confirmation',
                'product',
            ],
        ]);

    }

    public function edit(Request $request, MainModel $id)
    {
        $id->load(static::mainModelWith());

        $config = static::config();
        $config['password']['description'] = 'パスワードの変更時のみ入力してください';
        $config['password_confirmation']['description'] = 'パスワードの変更時のみ入力してください';

        return Inertia::render(static::viewDir().'Edit', [
            'config' => $config,
            'item' => $id,
            'formConfig' => [
                'name',
                'email',
                'password',
                'password_confirmation',
                'product',
            ],
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        // event(new Registered($user = $this->_create($request->all())));
        $mainModel = static::mainModel();
        $item = new $mainModel;
        $input = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'is_admin' => 0,
            'product' => $request->input('product'),
        ];
        $result = \Blu\Save::saveTransaction($input, $item, static::config(), $useDefault = true);

        if ($request->expectsJson())
        {
            if (!$result)
            {
                return response()->json(['message' => '保存に失敗しました。'], 500);
            }

            return response()->json([
                $result,
            ], 201);
        }

        if (!$result)
        {
            return back()->withErrors('保存に失敗しました。');
        }

        return redirect()
            ->route(static::routePrefix().'edit', [ 'id' => $result->id ] )
            ->with('success', '保存しました。');
    }

    public function update(Request $request, MainModel $id)
    {
        $input = [];
        if ($request->password || $request->password_confirmation)
        {
            $this->validator($request->all(), $id->id)->validate();
            $input = [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'product' => $request->input('product'),
            ];
            $id->save();
        }
        else
        {
            $this->validator_no_password($request->all(), $id->id)->validate();
            $input = [
                'name' => $request['name'],
                'email' => $request['email'],
                'product' => $request->input('product'),
            ];
        }

        $result = \Blu\Save::saveTransaction($input, $id, static::config(), $useDefault = false);

        if ($request->expectsJson())
        {
            if (!$result)
            {
                return response()->json(['message' => '保存に失敗しました。'], 500);
            }

            return response()->json([
                $result,
            ], 204);
        }

        if (!$result)
        {
            return back()->withErrors('error', '保存に失敗しました。');
        }

        return redirect()
            ->route(static::routePrefix().'edit', [ 'id' => $result->id ] )
            ->with('success', '更新しました。');
    }

    public function destroy(MainModel $id)
    {
        return static::_destroy($request, $id);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $ignoreId = false)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users'.($ignoreId ? ',email,'.$ignoreId.',id' : ''),
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function validator_no_password(array $data, $ignoreId = false)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users'.($ignoreId ? ',email,'.$ignoreId.',id' : ''),
        ]);
    }
}
