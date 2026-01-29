<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Imports\TopicsImport;
use App\Exports\TopicsExport;
use Maatwebsite\Excel\Facades\Excel;


class TopicController extends Controller
{
    public function getList()
    {
        $topics = Topic::all();
        return view('administrator.topics.list', compact('topics'));
    }

    public function getAdd()
    {
        $topics = Topic::all();
        return view('administrator.topics.add', compact('topics'));
    }

    public function postAdd(Request $request)
    {
        $request->validateWithBag('add', [
            'name' => ['required', 'string', 'max:255', 'unique:topics'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('topics', $request->file('image'), $filename);
        }

        $orm = new Topic();
        $orm->name = $request->name;
        $orm->slug = Str::slug($request->name, '-');
        $orm->description = $request->description;
        $orm->image = $path ?? null;
        $orm->save();

        return redirect()->route('administrator.topics')->with('success', 'Added topic successfully.');
    }


    public function getUpdate($id)
    {
        $topic = Topic::findOrFail($id);
        return view('administrator.topics.edit', compact('topic'));
    }

    public function postUpdate(Request $request, $id)
    {
        $request->validateWithBag('update', [
            'name' => ['required', 'string', 'max:255', 'unique:topics,name,' . $id],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $topic = Topic::findOrFail($id);

        $path = $topic->image;
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($topic->image) {
                Storage::delete($topic->image);
            }
            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('topics', $request->file('image'), $filename);
        }

        $topic->name = $request->name;
        $topic->slug = Str::slug($request->name, '-');
        $topic->description = $request->description;
        $topic->image = $path ?? null;
        $topic->save();

        return redirect()->route('administrator.topics')->with('success', 'Updated topic successfully.');
    }

    public function getDelete($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        if (!empty($topic->image)) Storage::delete($topic->image);

        return redirect()->route('administrator.topics')->with('success', 'Deleted topic successfully.');
    }

    /*public function postImport(Request $request)
    {
        $request->validateWithBag('import', [
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        try {
            Excel::import(new TopicsImport, $request->file('file_excel'));
            return redirect()->route('administrator.topics')->with('success', 'Imported topics successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function getExport()
    {
        return Excel::download(new TopicsExport, 'topics-list.xlsx');
    }*/
}
