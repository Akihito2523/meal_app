<x-app-layout>

    {{-- flash-message.blade.php読み込み --}}
    {{-- フラッシュメッセージ --}}
    <x-flash-message :message="session('notice')" />

    {{-- validation-errors.blade.php読み込み --}}
    {{-- エラーメッセージ --}}
    <x-validation-errors :errors="$errors" />

    <div class="main">
        <article class="mb-2">
            <h2>{{ $post->title }}</h2>

            <p>カテゴリー：{{ $post->category->name }}</p>

            <p>ALEXANDER</p>

            <p class="current_time">現在時刻：{{ date('Y-d H:i:s') }}</p>

            <p>記事作成日:{{ date('Y-d H:i:s', strtotime('-1 day')) < $post->created_at ?: '' }}{{ $post->created_at }}</p>

            <img src="{{ $post->image_url }}" alt="" class="mb-4">

            <p>{{ $post->body }}</p>

            <div class="btn_flex">

                {{-- (認可の制御)自分が投稿した記事の場合のみ、編集ボタンと削除ボタンを表示 --}}
                @can('update', $post)
                    <a href="{{ route('meals.edit', $post) }}" class="btn">編集</a>
                @endcan

                @can('delete', $post)
                    <form action="{{ route('meals.destroy', $post) }}" id="form_recipe" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="削除" id="btn" class="btn btn_red">
                    </form>
                @endcan

            </div>
        </article>
    </div>
    <script src="{{ asset('/js/index.js') }}"></script>
</x-app-layout>
