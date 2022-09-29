<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Nice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // Post::latest()メソッドでcreated_atの降順
        // withメソッドを使用することで、関連するテーブルの情報を取得することが可能
        $posts = Post::with('user')->latest()->paginate(4);
        return view('meals.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = Category::all();
        return view('meals.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request) {
        $post = new Post($request->all());
        // ログインユーザーのIDを取得
        $post->user_id = $request->user()->id;
        // カテゴリーを取得
        $post->category_id = $request->category;
        // 画像を取得
        $file = $request->file('image');
        $post->image = self::createFileName($file);

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 登録
            $post->save();

            // 画像をアップロードする(Storage::putFileAs)
            // (保存先のパス, アップロードするファイル, アップロード後のファイル名)
            if (!Storage::putFileAs('images/posts', $file, $post->image)) {
                // 例外を投げてロールバックさせる
                throw new \Exception('画像ファイルの保存に失敗しました。');
            }

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()
            ->route('meals.show', $post)
            ->with('notice', '記事を登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, $id) {
        $postid = Post::find($id);

        if (Auth::check()) {
            $nice = Nice::where('post_id' ,$post->id)
                ->where('post_id', $post->id)
                ->where('user_id', auth()->user()->id)->first();
            return view('meals.show', compact('postid', 'post', 'nice'));
        } else {
            return view('meals.show', compact('postid', 'post'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $post = Post::find($id);
        $categories = Category::all();
        return view('meals.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id) {
        $post = Post::find($id);
        // $fillableの内容を変数として読み込む
        $post->fill($request->all());
        // カテゴリーを取得
        $post->category_id = $request->category;

        // (cannot)更新権限を確認するメソッド
        if ($request->user()->cannot('update', $post)) {
            return redirect()
                ->route('posts.show', $post)
                ->withErrors('自分の記事以外は更新できません');
        }

        $file = $request->file('image');
        if ($file) {
            // 更新前の画像ファイルのファイル名を保持
            $delete_file_path = $post->image_path;
            $post->image = self::createFileName($file);
        }

        // トランザクション開始
        // beginTransactionからDB::commit
        DB::beginTransaction();
        try {
            // 更新
            $post->save();

            if ($file) {
                // 画像をアップロードする
                if (!Storage::putFileAs('images/posts', $file, $post->image)) {
                    // 例外を投げてロールバックさせる
                    throw new \Exception('画像ファイルの保存に失敗しました。');
                }

                // 過去の画像ファイルを削除
                if (!Storage::delete($delete_file_path)) {
                    //アップロードした画像を削除する
                    Storage::delete($post->image_path);
                    //例外を投げてロールバックさせる
                    throw new \Exception('画像ファイルの削除に失敗しました。');
                }
            }

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('meals.show', $post)
            ->with('notice', '記事を更新しました');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $post = Post::find($id);

        // トランザクション開始
        DB::beginTransaction();
        try {
            $post->delete();

            // 画像削除
            if (!Storage::delete($post->image_path)) {
                // 例外を投げてロールバックさせる
                throw new \Exception('画像ファイルの削除に失敗しました。');
            }

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('meals.index')
            ->with('notice', '記事を削除しました');
    }

    // (getClientOriginalName)画像ファイル名を取得
    private static function createFileName($file) {
        return date('YmdHis') . '_' . $file->getClientOriginalName();
    }
}
