<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\CategoryPost;
use App\Components\Recursive;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Post;
use App\Traits\StorageImageTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Validator;

class AdminPostController extends Controller
{
    use StorageImageTrait;
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $kind = $request->kind;
        $count_active = Post::count();
        $count_trash = Post::onlyTrashed()->count();
        $count_pending = Post::where('status', 0)->count();
        $count_public = Post::where('status', 1)->count();
        $count = [$count_active, $count_trash, $count_pending, $count_public];

        $list_field = [
            'id' => 'ID',
            'title' => 'Tiêu đề',
            'category_id' => 'Danh mục',
        ];

        if ($kind == 'trash') {
            $posts = Post::onlyTrashed()->paginate(5);
            $list_act =
                [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
        } else {
            $posts = Post::latest()->paginate(5);
            $list_act = [
                'delete' => 'Xóa tạm thời'
            ];
            if ($kind == 'pending') {
                $posts = Post::where('status', 0)->paginate(5);
            }
            if ($kind == 'public') {
                $posts = Post::where('status', 1)->paginate(5);
            }
            $field = $request->field;
            $keyword = $request->input('keyword');
            if ($keyword) {
                if ($field == 'category_id') {
                    $get_id = CategoryPost::where('name', 'like', '%' . $keyword . '%')->get();
                    if (count($get_id) > 0) {
                        foreach ($get_id as $item) {
                            $ids[] = $item->id;
                        }
                    } else {
                        $ids[] = 0;
                    }
                    $posts = Post::whereIn($field, $ids)->paginate(5);
                } else {
                    $posts = Post::where($field, 'like', '%' . $keyword . '%')->paginate(5);
                }
            }

            $keyword1 = $request->input('keyword1');

            if ($keyword1) {
                if ($field == 'category_id') {
                    $get_id = CategoryPost::where('name', 'like', '%' . $keyword1 . '%')->get();
                    if (count($get_id) > 0) {
                        foreach ($get_id as $item) {
                            $ids[] = $item->id;
                        }
                    } else {
                        $ids[] = 0;
                    }
                    $posts = Post::whereIn($field, $ids)->onlyTrashed()->paginate(5);
                } else {
                    $posts = Post::where($field, 'like', '%' . $keyword1 . '%')->onlyTrashed()->paginate(5);
                }
                
                $list_act = [
                    'restore' => 'Khôi phục',
                    'forceDelete' => 'Xóa vĩnh viễn'
                ];
                return view('admin.posts.list-trash', compact('posts', 'count', 'list_field', 'list_act'));
            }
        }

        return view('admin.posts.list', compact('posts', 'list_act', 'count', 'list_field'));
    }

    function getCategory($parentId)
    {
        $data = CategoryPost::all();
        $recursive = new Recursive();
        $htmlOption = $recursive->itemRecursive($parentId, 0, '', $data);
        return $htmlOption;
    }

    function add(Request $request)
    {
        $htmlOption = $this->getCategory('');
        return view('admin.posts.add', compact('htmlOption'));
    }

    function store(PostRequest $request)
    {
        $dataUploadTrait = $this->uploadImageTrait($request->post_image_path, 'post');
        Post::create([
            'title' => $request->title,
            'desc' => $request->desc,
            'content' => $request->content,
            'slug' => Str::slug($request->title, '-'),
            'post_image_name' => $dataUploadTrait['file_name'],
            'post_image_path' => $dataUploadTrait['file_path'],
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'status' => $request->status
        ]);
        return redirect()->route('post.list')->with('status', 'Thêm bài viết thành công');
    }

    function edit($id)
    {
        $post = Post::find($id);
        $htmlOption = $this->getCategory('');

        return view('admin.posts.edit', compact('htmlOption', 'post'));
    }

    function update(PostUpdateRequest $request, $id)
    {
        $post = Post::find($id);
        $dataUpdate = [
            'title' => $request->title,
            'desc' => $request->desc,
            'content' => $request->content,
            'slug' => Str::slug($request->title, '-'),
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'status' => $request->status
        ];

        if ($request->hasFile('post_image_path')) {
            $path = Str::of($post->post_image_path)->replace('/storage' . "/", "/");
            Storage::disk('public')->delete($path); // mục đích để xóa ảnh cũ sau khi update
            $dataUploadTrait = $this->uploadImageTrait($request->post_image_path, 'post');
            $dataUpdate['post_image_name'] = $dataUploadTrait['file_name'];
            $dataUpdate['post_image_path'] = $dataUploadTrait['file_path'];
        }

        $post->update($dataUpdate);

        return redirect()->route('post.list')->with('status', 'Cập nhật bài viết thành công');
    }

    function delete($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('post.list')->with('status', 'Xóa tạm thời bài viết thành công');
    }

    function action(Request $request)
    {
        $listCheck = $request->input('listCheck');
        if ($listCheck) {
            $act = $request->input('act');
            if ($act) {
                if ($act == 'delete') {
                    Post::destroy($listCheck);
                    return redirect()->route('post.list')->with('status', 'Xóa tạm thời bài viết thành công');
                }
                if ($act == "restore") {
                    Post::onlyTrashed()->whereIn('id', $listCheck)->restore();
                    return redirect()->route('post.list')->with('status', 'Khôi phục bài viết thành công');
                }
                if ($act == "forceDelete") {
                    foreach ($listCheck as $id) {
                        $post = Post::onlyTrashed()->find($id);
                        $path = Str::of($post->post_image_path)->replace('/storage' . "/", "/");
                        Storage::disk('public')->delete($path);
                        $post->forceDelete();
                    }
                    return redirect()->route('post.list')->with('status', 'Xóa vĩnh viễn bài viết thành công');
                }
            } else {
                return redirect()->back()->with('error', 'Bạn cần chọn tác vụ để thực hiện');
            }
        } else {
            return redirect()->back()->with('error', 'Bạn chưa chọn bản ghi để thực hiện');
        }
    }

    function convertStatus($id)
    {
        $post = Post::find($id);
        $post->update([
            'status' => !$post->status
        ]);
        return redirect()->route('post.list')->with('status', 'Cập nhật trạng thái bài viết thành công');
    }
}
