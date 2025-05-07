<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Base\Crud;
use Inertia\Inertia;
use App\Models\Task;
use App\Models\Project;


class TaskController extends Crud
{
    protected static function configs()
    {
        $configs = parent::configs();
        return $configs;
    }

    public static function mainModel()
    {
        return Task::class;
    }

    public static function mainModelWith()
    {
        return [];
    }

    public function __invoke(Request $request)
    {
        $project = null;
        if ($request->session()->has('project_id'))
        {
            $project = Project::find($request->session()->get('project_id'));
        }
        /*
        if (!$project)
        {
            return redirect()
                ->route('admin.project')
                ->with('warning', '現場を選択してください');
        }
        */

        $mainModel = static::mainModel();
        $query = $mainModel::query();
        $query->with(static::mainModelWith());

        if ($request->expectsJson())
        {
            if (!$project) abort(404);
            $query->where('project_id', $project->id);
            $query->orderBy('seq');
            return \Blu\Query::itemsByRequest(
                $request,
                static::config(),
                $query,
                static::$perPage
            );
        }
        
        $formConfigs = $viewConfigs = static::configs();
        $formConfigs['config']['task_material']['hasMany']['tag'] = 'ul';

        return Inertia::render(static::viewDir(), [
            'viewConfigs' => $viewConfigs,
            'formConfigs' => $formConfigs,
            'productConfigs' => config('blu.product'),
            'materialConfigs' => config('blu.material'),
        ]);

    }

    public function show(Request $request, Task $id)
    {
        return static::_show($request, $id);
    }

    public function store(Request $request)
    {
        $mainModel = static::mainModel();
        $item = new $mainModel;

        // project の設定
        $project = null;
        if ($request->session()->has('project_id'))
        {
            $project = Project::find($request->session()->get('project_id'));
        }
        if (!$project)
        {
            return back()
                ->with('warning', '現場を選択してください');
        }
        $item->project_id = $project->id;
        // 順序の設定
        $item->seq = $project->task()->count() + 1;
    
        $result = \Blu\Save::saveTransaction($request, $item, static::config(), $useDefault = true);

        if (!$result)
        {
            return back()->withErrors('保存に失敗しました。');
        }

        return back()
            ->with([
                'createdId' => $item->id,
            ])
            ->with('success', '保存しました。');
    }

    public function update(Request $request, Task $id)
    {
        return static::_update($request, $id);
    }

    public function duplicate(Request $request, Task $id)
    {
        $newTask = $id->replicate();
        $newTask->save();
        foreach ($id->task_material as $task_material)
        {
            $newTaskMaterial = $task_material->replicate();
            $newTaskMaterial->task_id = $newTask->id;
            $newTaskMaterial->save();
        }

        static::sort_seq($id->project);
        return back()
            ->with('success', '複製しました。');
    }

    public function seq_decrease(Task $id)
    {
        $prev = Task::where('project_id', $id->project_id)
            ->where('seq', $id->seq - 1)->first();
        if (!$prev) return;

        $prev->seq = $id->seq;
        $prev->save();
        $id->seq = $id->seq - 1;
        $id->save();

        static::sort_seq($id->project);
        return back()
            ->with('success', '並べ替えました。');
    }

    public function seq_increase(Task $id)
    {
        $next = Task::where('project_id', $id->project_id)
            ->where('seq', $id->seq + 1)->first();
        if (!$next) return;

        $next->seq = $id->seq;
        $next->save();
        $id->seq = $id->seq + 1;
        $id->save();

        static::sort_seq($id->project);
        return back()
            ->with('success', '並べ替えました。');
    }

    public static function sort_seq(Project $project)
    {
        $seq = 1;
        foreach ($project->task as $task)
        {
            $task->seq = $seq;
            $task->save();
            $seq++;
        }
    }

    public function destroy(Request $request, Task $id)
    {
        return static::_destroy($request, $id);
    }
}
