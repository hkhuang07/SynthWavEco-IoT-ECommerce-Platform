<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticleStatus;
use App\Imports\ArticleStatusImport;
use App\Exports\ArticleStatusExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Arg;

class ArticleStatusController extends Controller
{
    public function getList()
    {
        $article_statuses = ArticleStatus::withCount('articles')->get();
        return view('administrator.article_statuses.list', compact('article_statuses'));
    }

    public function getAdd()
    {
        return view('administrator.article_statuses.add');
    }

    public function postAdd(Request $request)
    {
        $request->validateWithBag('add', [
            'name' => ['required', 'string', 'max:255', 'unique:article_statuses'],
        ]);

        $orm = new ArticleStatus();
        $orm->name = $request->name;
        $orm->save();

        return redirect()->route('administrator.article_statuses')->with('success', 'Added article status successfully.');
    }

    public function getUpdate($id)
    {
        $article_status = ArticleStatus::findOrFail($id);
        return view('administrator.article_statuses.edit', compact('status'));
    }

    public function postUpdate(Request $request, $id)
    {
        $request->validateWithBag('update', [
            'name' => ['required', 'string', 'max:255', 'unique:order_statuses,name,' . $id],
        ]);

        $orm = ArticleStatus::findOrFail($id);
        $orm->name = $request->name;
        $orm->save();

        return redirect()->route('administrator.article_statuses')->with('success', 'Updated article status successfully.');
    }

    public function getDelete($id)
    {
        $orm = ArticleStatus::findOrFail($id);

        if ($orm->articles()->count() > 0) {
            return redirect()->route('administrator.article_statuses')->with('error', 'Cannot delete: There are still orders using this status.');
        }

        $orm->delete();

        return redirect()->route('administrator.article_statuses')->with('success', 'Deleted article status successfully.');
    }

    /*public function postImport(Request $request)
    {
        $request->validateWithBag('import', [
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        try {
            Excel::import(new ArticleStatusImport, $request->file('file_excel'));
            return redirect()->route('administrator.article_statuses')->with('success', 'Imported article statuses successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }


    public function getExport()
    {
        return Excel::download(new ArticleStatusExport, 'article-statuses-list.xlsx');
    }*/
}
