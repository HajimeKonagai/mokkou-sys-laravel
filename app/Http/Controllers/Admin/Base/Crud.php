<?php
namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

abstract class Crud extends Controller
{
    protected static $perPage = 25;
    abstract public static function mainModel();
    abstract public static function mainModelWith();

    protected static function configs()
    {
        return config('blu.'.strtolower(last(explode('\\', static::mainModel()))));
    }

    protected static function viewDir()
    {
        return 'Admin/'.last(explode('\\', static::mainModel())) . '/';
    }

    protected static function routePrefix()
    {
        return 'admin.'.strtolower(last(explode('\\', static::mainModel()))) . '.';
    }

    protected static function config()
    {
        return \Arr::get(static::configs(), 'config');;
    }
    protected static function indexConfig()
    {
        return \Arr::get(static::configs(), 'index');;
    }
    protected static function searchConfig()
    {
        return \Arr::get(static::configs(), 'search');;
    }
    protected static function formConfig()
    {
        return \Arr::get(static::configs(), 'form');;
    }

    public static function _index(Request $request)
    {
        $mainModel = static::mainModel();
        $query = $mainModel::query();
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

    public static function _show(Request $request, $item)
    {
        $item->load(static::mainModelWith());
        if ($request->expectsJson())
        {
            return $item;
        }

        return Inertia::render(static::viewDir().'Show', [
            'config' => static::config(),
            'item' => $item,
            'formConfig' => static::formConfig(),
        ]);
    }

    public function _create()
    {
        return Inertia::render(static::viewDir().'Create', [
            'config' => static::config(),
            'formConfig' => static::formConfig(),
        ]);
    }

    public function _edit(Request $request, $item)
    {
        $item->load(static::mainModelWith());
        return Inertia::render(static::viewDir().'Edit', [
            'config' => static::config(),
            'item' => $item,
            'formConfig' => static::formConfig(),
        ]);
    }

    public static function _store(Request $request)
    {
        $mainModel = static::mainModel();
        $item = new $mainModel;
        $result = \Blu\Save::saveTransaction($request, $item, static::config(), $useDefault = true);

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

    public static function _update(Request $request, $item)
    {
        $result = \Blu\Save::saveTransaction($request, $item, static::config(), $useDefault = false);

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

    public static function _destroy(Request $request, $item)
    {
        $id = $item->id;
        $item->delete();

        // TODO: success/fail result

        if ($request->expectsJson())
        {
            return response()->json([], 204);
        }

        return back()->with('success', '「id : '.$id.'」を完全に削除しました。');
    }
}
