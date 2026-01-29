<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\ArticleType;
use Illuminate\Http\Request;
use App\Imports\ArticleTypeImport;
use App\Exports\ArticleTypeExport;
use Maatwebsite\Excel\Facades\Excel;

class ArticleTypeController extends Controller
{
    public function getList()
    {
        $article_types = ArticleType::withCount('articles')->get();
        return view('administrator.article_types.list', compact('article_types'));
    }
    public function getAdd()
    {
        return view('administrator.article_types.add');
    }

    public function postAdd(Request $request)
    {
        $request->validateWithBag('add', [
            'name' => ['required', 'string', 'max:255', 'unique:article_types'],
        ]);

        $orm = new ArticleType();
        $orm->name = $request->name;
        $orm->slug = Str::slug($request->name, '-');
        $orm->save();

        return redirect()->route('administrator.article_types')->with('success', 'Added article type successfully.');
    }

    public function getUpdate($id)
    {
        $article_type = ArticleType::findOrFail($id);
        return view('administrator.article_types.edit', compact('article_type'));
    }

    public function postUpdate(Request $request, $id)
    {
        $request->validateWithBag('update', [
            'name' => ['required', 'string', 'max:255', 'unique:article_types,name,' . $id],
        ]);

        $orm = ArticleType::findOrFail($id);
        $orm->name = $request->name;
        $orm->slug = Str::slug($request->name, '-');
        $orm->save();

        return redirect()->route('administrator.article_types')->with('success', 'Updated article type successfully.');
    }

    public function getDelete($id)
    {
        $orm = ArticleType::findOrFail($id);

        if ($orm->articles()->count() > 0) {
            return redirect()->route('administrator.article_types')->with('error', 'Cannot delete: There are still articles using this type.');
        }

        $orm->delete();

        return redirect()->route('administrator.article_types')->with('success', 'Deleted article type successfully.');
    }

    /*public function postImport(Request $request)
    {
        $request->validateWithBag('import', [
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        try {
            Excel::import(new ArticleTypeImport, $request->file('file_excel'));
            return redirect()->route('administrator.article_types')->with('success', 'Imported article types successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }


    public function getExport()
    {
        return Excel::download(new ArticleTypeExport, 'article-types-list.xlsx');
    }*/
}
