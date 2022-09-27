@props(['message'])
{{-- フラッシュメッセージ --}}
@if (session('notice'))
    <div class="flash">
        {{ session('notice') }}
    </div>
@endif
