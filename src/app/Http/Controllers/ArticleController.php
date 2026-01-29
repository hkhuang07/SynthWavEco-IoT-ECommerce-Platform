<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleStatus;
use App\Models\ArticleType;
use App\Models\Topic;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function getList()
    {
        $articles = Article::with(['ArticleType', 'ArticleStatus', 'Topic'])
            ->orderBy('id', 'desc')
            ->get();

        $topics = Topic::all();
        $article_statuses = ArticleStatus::all();
        $article_types = ArticleType::all();

        return view('administrator.articles.list', compact(
            'articles',
            'topics',
            'article_statuses',
            'article_types'
        ));
    }

    public function getAdd()
    {
        $article_statuses = ArticleStatus::all();
        $article_types = ArticleType::all();
        $topics = Topic::all();
        return view('administrator.articles.add', compact('article_statuses', 'article_types', 'topics'));
    }

    public function postAdd(Request $request)
    {
        $request->validateWithBag('add', [
            'topicid'           => ['required', 'exists:topics,id'],
            'articletypeid'     => ['required', 'exists:article_types,id'],
            'statusid'          => ['required', 'exists:article_statuses,id'],
            'title'             => ['required', 'string', 'max:255'],
            'summary'           => ['nullable', 'string', 'max:3000'],
            'content'           => ['required', 'string'],
            'views'             => ['nullable', 'integer', 'min:0'],
            'image'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        DB::beginTransaction();
        try {
            $slug = Str::slug($request->title, '-');

            $path = null;
            if ($request->hasFile('image')) {
                $filename = $slug . '-' . time() . '.' . $request->file('image')->extension();
                $path = Storage::putFileAs('articles', $request->file('image'), $filename);
            }

            $article = Article::create([
                'topicid'       => $request->topicid,
                'articletypeid' => $request->articletypeid,
                'statusid'      => $request->statusid,
                'userid'        => Auth::id() ?? 1, // Lấy ID người dùng hiện tại
                'title'         => $request->title,
                'slug'          => $slug,
                'summary'       => $request->summary,
                'content'       => $request->content,
                'views'         => $request->views ?? 0,
                'image'         => $path
            ]);

            DB::commit();
            return redirect()->route('administrator.articles')->with('success', 'Added article successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function getUpdate($id)
    {
        $article = Article::findOrFail($id);
        $article_statuses = ArticleStatus::all();
        $article_types = ArticleType::all();
        $topics = Topic::all();
        return view('administrator.articles.edit', compact('article', 'article_statuses', 'article_types', 'topics'));
    }

    public function postUpdate(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validateWithBag('update', [
            'topicid'           => ['required', 'exists:topics,id'],
            'articletypeid'     => ['required', 'exists:article_types,id'],
            'statusid'          => ['required', 'exists:article_statuses,id'],
            'title'             => ['required', 'string', 'max:255'],
            'slug'              => ['required', 'string', 'unique:articles,slug,' . $id],
            'summary'           => ['nullable', 'string', 'max:3000'],
            'content'           => ['required', 'string'],
            'image'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        DB::beginTransaction();
        try {
            $path = $article->image;
            if ($request->hasFile('image')) {
                if ($article->image) {
                    Storage::delete($article->image);
                }
                $filename = Str::slug($request->title, '-') . '-' . time() . '.' . $request->file('image')->extension();
                $path = Storage::putFileAs('articles', $request->file('image'), $filename);
            }

            $article->update([
                'topicid'       => $request->topicid,
                'articletypeid' => $request->articletypeid,
                'statusid'      => $request->statusid,
                'title'         => $request->title,
                'slug'          => Str::slug($request->slug, '-'),
                'summary'       => $request->summary,
                'content'       => $request->content,
                'image'         => $path,
                'is_enabled'    => $request->is_enabled ?? 1
            ]);

            DB::commit();
            return redirect()->route('administrator.articles')->with('success', 'Updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    public function getDelete($id)
    {
        $article = Article::findOrFail($id);

        if ($article->image) {
            Storage::delete($article->image);
        }

        $article->delete();
        return redirect()->route('administrator.articles')->with('success', 'Deleted successfully.');
    }

    /*public function postImport(Request $request)
    {
        $request->validateWithBag('import', [
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        try {
            Excel::import(new ArticlesImport, $request->file('file_excel'));
            return redirect()->route('administrator.categories')->with('success', 'Imported categories successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function getExport()
    {
        return Excel::download(new ArticlesExport, 'articles-list.xlsx');
    }*/
}
