<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Base\Crud;
use Inertia\Inertia;
use App\Models\User as MainModel;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Material;

class UserController extends Crud
{
    private static $common_columns = [
        'name',
        'zip',
        'address',
        'tel',
        'fax', 
        'url',
        'close_date',
        'pay_date',
        'pay_way',
        'staff',
    ];
    protected static function configs()
    {
        $configs = parent::configs();
        $material_options = Material::get()->toArray();

        $configs['config']['material']['options'] = $material_options;

        return $configs;
    }

    public static function mainModel()
    {
        return MainModel::class;
    }

    public static function mainModelWith()
    {
        return ['material'];
    }

    public function __invoke(Request $request)
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

        // create
        $createConfigs = static::configs();
        $createConfigs['config']['password']['required'] = true;
        $createConfigs['config']['password_confirmation']['required'] = true;

        // edit
        $editConfigs = static::configs();
        $editConfigs['config']['password']['description'] = 'パスワードの変更時のみ入力してください';
        $editConfigs['config']['password_confirmation']['description'] = 'パスワードの変更時のみ入力してください';

        return Inertia::render(static::viewDir(), [
            'configs' => static::configs(),
            'materialConfigs' => config('blu.material'),

            'createConfigs' => $createConfigs,
            'editConfigs' => $editConfigs,
        ]);
    }

    public function show(Request $request, MainModel $id)
    {
        $id->load(['pricing']);
        return static::_show($request, $id);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        try
        {
            \DB::beginTransaction();

            // event(new Registered($user = $this->_create($request->all())));
            $values = [
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'is_admin' => 0,
            ];
            foreach (static::$common_columns as $common_column)
            {
                $item->{$common_column} = $request->input($common_column);
            }
            $item = MainModel::create($values);
            $result = \Blu\Save::save(['pricing' => $request->input('pricing')], $item, static::config(), $useDefault = false);

            if (!$result) throw new \Exception();

            \DB::commit();
        }
        catch (Throwable $e)
        {
            \DB::rollBack();

            if ($request->expectsJson()) return response()->json(['message' => '保存に失敗しました。'], 500);
            return back()->withErrors('保存に失敗しました。');
        }

        if ($request->expectsJson())
        {
            return response()->json([
                $result,
            ], 201);
        }

        return redirect()
            ->back()
            ->with(['createdId' => $item->id,])
            // ->route(static::routePrefix().'edit', [ 'id' => $result->id ] )
            ->with('success', '保存しました。');
    }

    public function update(Request $request, MainModel $id)
    {
        try
        {
            \DB::beginTransaction();
            if ($request->password || $request->password_confirmation)
            {
                $this->validator($request->all(), $id->id)->validate();
                $values = [
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                ];
                foreach (static::$common_columns as $common_column)
                {
                    $values[$common_column] = $request->input($common_column);
                }
                $id->fill($values);
                $id->save();
            }
            else
            {
                $this->validator_no_password($request->all(), $id->id)->validate();
                $values = [];
                foreach (static::$common_columns as $common_column)
                {
                    $values[$common_column] = $request->input($common_column);
                }
                $id->fill($values);
                $id->save();
            }

            $result = \Blu\Save::save(['pricing' => $request->input('pricing')], $id, static::config(), $useDefault = false);

            if (!$result) throw new \Exception();

            \DB::commit();
        }
        catch (Throwable $e)
        {
            \DB::rollBack();

            if ($request->expectsJson()) return response()->json(['message' => '保存に失敗しました。'], 500);
            return back()->withErrors('保存に失敗しました。');
        }


        if ($request->expectsJson())
        {
            return response()->json([
                $result,
            ], 204);
        }

        return redirect()
            ->back()
            // ->route(static::routePrefix().'edit', [ 'id' => $result->id ] )
            ->with('success', '更新しました。');
    }

    public function destroy(Request $request, MainModel $id)
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
            'password' => ['string', 'min:8', 'confirmed'],
        ]);
    }
}
