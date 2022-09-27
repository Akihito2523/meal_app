@props(['errors'])

{{-- エラーメッセージの表示 --}}
    @if ($errors->any())
        <div class="error">
            <p>{{ count($errors) }}件のエラーがあります。</p>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
