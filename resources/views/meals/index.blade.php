<x-app-layout>

    {{-- flash-message.blade.php読み込み --}}
    {{-- フラッシュメッセージ --}}
    <x-flash-message :message="session('notice')" />

    <div class="container max-w-7xl mx-auto px-4 md:px-12 pb-3 mt-3">
        <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-4">

            @foreach ($posts as $post)
                <div class="main">
                    <div class="main_box">
                        <a href="{{ route('meals.show', $post) }}">
                            <h2>{{ $post->title }}</h2>
                            <p>ALEXANDER</p>
                            <p>カテゴリー：{{ $post->category->name }}</p>
                            <p class="current_time">現在時刻：{{ date('Y-d H:i:s') }}</p>
                            <p>記事作成日:{{ date('Y-d H:i:s', strtotime('-1 day')) < $post->created_at ?: '' }}{{ $post->created_at }}
                            </p>
                            <img src="{{ $post->image_url }}" alt="" class="mb-4">
                            <p>{{ $post->body }}</p>
                        </a>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
    <a href="{{ route('meals.create') }}" class="btn">新規作成</a>
    {{ $posts->links() }}

</x-app-layout>
