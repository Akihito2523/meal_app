<x-app-layout>

    <h1>食事記事投稿</h1>

    {{-- validation-errors.blade.php読み込み --}}
    {{-- エラーメッセージ --}}
    <x-validation-errors :errors="$errors" />

    <form action="{{ route('meals.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="title">タイトル</label>
            <input type="text" id="title" name="title" placeholder="タイトル" value="{{ old('title') }}">
        </div>

        <div>
            <label for="category">カテゴリー</label>
            @foreach ($categories as $category)
                <label><input type="radio" name="category" id='category' value="{{ $category->id }}"
                        {{ old('category') == $category->id ? 'checked' : '' }}>
                    {{ $category->name }} </label>
            @endforeach
        </div>

        <div>
            <label for="body">詳細</label>
            <textarea name="body" class="body" id="body">{{ old('body') }}</textarea>
        </div>

        <div>
            <label for="image">食事の画像</label>
            <input type="file" id="image" name="image">
        </div>

        <input type="submit" class="submit" value="登録">
    </form>

</x-app-layout>
