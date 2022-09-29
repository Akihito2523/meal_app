<x-app-layout>

    {{-- flash-message.blade.php読み込み --}}
    {{-- フラッシュメッセージ --}}
    <x-flash-message :message="session('notice')" />

    {{-- validation-errors.blade.php読み込み --}}
    {{-- エラーメッセージ --}}
    <x-validation-errors :errors="$errors" />

    <div class="main">
        <article class="mb-2">
            <h2>{{ $postid->title }}</h2>

            <p>カテゴリー：{{ $postid->category->name }}</p>

            <p>ALEXANDER</p>

            <p class="current_time">現在時刻：{{ date('Y-d H:i:s') }}</p>

            <p>記事作成日:{{ date('Y-d H:i:s', strtotime('-1 day')) < $postid->created_at ?: '' }}{{ $postid->created_at }}
            </p>

            <img src="{{ $postid->image_url }}" alt="" class="mb-4">

            <p>{{ $postid->body }}</p>

            {{-- お気に入りボタン --}}
            <div>
                @auth
                    @if ($nice)
                        <form action="{{ route('meals.nice.destroy', [$postid, $nice]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn_blue" value="お気に入り削除">
                        </form>
                    @else
                        <form action="{{ route('meals.nice.store', $postid) }}" method="post">
                            @csrf
                            <input type="submit" class="btn btn_blue" value="お気に入りに登録">
                        </form>
                    @endif
                @endauth
            </div>

            <div>
                お気に入り数:{{ $postid->nices->count() }}
            </div>

            <div class="btn_flex">

                {{-- (認可の制御)自分が投稿した記事の場合のみ、編集ボタンと削除ボタンを表示 --}}
                @can('update', $postid)
                    <a href="{{ route('meals.edit', $postid) }}" class="btn">編集</a>
                @endcan

                @can('delete', $postid)
                    <form action="{{ route('meals.destroy', $postid) }}" id="form_recipe" method="postid">
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
