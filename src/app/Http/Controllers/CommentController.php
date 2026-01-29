<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function getList()
    {
        $comments = Comment::with(['article', 'user'])
                            ->orderBy('created_at', 'desc')
                            ->get();
        return view('administrator.comments.list', compact('comments'));
    }

    public function getAdd()
    {
        $articles = Article::select('id', 'title')->orderBy('created_at', 'desc')->get();
        return view('administrator.comments.add', compact('articles'));
    }

    public function postAdd(Request $request)
    {
        $request->validate([
            'articleid' => ['required', 'exists:articles,id'],
            'content'   => ['required', 'string', 'min:5'], // Giảm min xuống 5 cho linh hoạt
        ]);

        Comment::create([
            'articleid' => $request->articleid,
            'userid'    => Auth::id(), 
            'content'   => $request->content,
            'is_censored' => 0, 
            'is_enabled'  => 1  
        ]);

        return redirect()->route('administrator.comments')->with('success', 'Thêm bình luận thành công!');
    }

    public function getUpdate($id)
    {
        $articles = Article::select('id', 'title')->get();
        $comment = Comment::findOrFail($id);
        return view('administrator.comments.edit', compact('articles', 'comment'));
    }

    public function postUpdate(Request $request, $id)
    {
        $request->validate([
            'articleid' => ['required', 'exists:articles,id'],
            'content'   => ['required', 'string', 'min:5'],
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update([
            'articleid' => $request->articleid,
            'content'   => $request->content,
        ]);

        return redirect()->route('administrator.comments')->with('success', 'Cập nhật thành công!');
    }

    public function getDelete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->route('administrator.comments')->with('success', 'Đã xóa bình luận.');
    }

    public function getCensored($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->is_censored = $comment->is_censored == 1 ? 0 : 1;
        $comment->save();
        
        return redirect()->route('administrator.comments')->with('success', 'Thay đổi trạng thái kiểm duyệt thành công!');
    }

    public function getEnabled($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->is_enabled = $comment->is_enabled == 1 ? 0 : 1;
        $comment->save();
        
        return redirect()->route('administrator.comments')->with('success', 'Thay đổi trạng thái hiển thị thành công!');
    }
}