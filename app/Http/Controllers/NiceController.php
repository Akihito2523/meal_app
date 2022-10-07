<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nice;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class NiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($post)
    {
        $nice = new Nice();
        // ユーザーidをナイスuser_idに置き換える
        $nice->user_id = Auth::user()->id;
        // $nice->user_id = Auth::id;
        // $nice->user_id = $request->user()->id;
        // ポストidをナイスpost_idに置き換える
        $nice->post_id = $post;
        // niceのidとuser_idを紐付ける
        $nice->save();
        // 紐付けた情報を渡す
        return redirect()
            ->route('meals.show', $post)
            ->with('notice', 'ナイスを登録しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($post, Nice $nice)
    {
        // niceを削除し紐付いているuser_idも削除
        $nice->delete();
        return redirect()
            ->route('meals.show', $post)
            ->with('notice', 'ナイスを削除しました');
    }
}
