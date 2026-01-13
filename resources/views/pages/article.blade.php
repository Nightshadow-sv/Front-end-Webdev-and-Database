@extends('layouts.app')

@section('content')
    {{-- ✅ Back button only at top --}}
    <div style="margin-bottom:20px;">
        <button onclick="history.back()" 
                style="border:1.5px solid #000; background:#fff; padding:6px 12px; font-size:12px; font-weight:700;">
            &larr; BACK
        </button>
    </div>

    {{-- Genre tag --}}
    <x-tag :text="$article->genre->name" />

    {{-- Title --}}
    <h1 class="article-h1">{{ $article->title }}</h1>

    {{-- Meta info --}}
    <div class="meta-section">
        <hr class="meta-line">
        <span class="author-text">By {{ $article->author_name }}</span>
        <span class="date-text">{{ optional($article->published_at)->format('F j, Y') }}</span>
        <hr class="meta-line">
    </div>

    {{-- Featured image --}}
    @if($article->featured_image)
        <img src="{{ $article->featured_image }}" alt="Featured image"
             style="width:100%; max-height:380px; object-fit:cover; border:1.5px solid #000; margin-bottom:20px;">
    @endif

    {{-- Summary --}}
    <div class="summary-deck">
        {{ $article->summary }}
    </div>

    {{-- Body --}}
    <div class="body-main-wrapper">
        <div class="article-body">
            {!! $article->content !!}
        </div>
    </div>

    {{--  Save button only at bottom --}}
    <div class="save-row" style="margin-top:24px;">
        <form method="POST" action="{{ route('articles.toggleSave', $article->id) }}">
            @csrf
            <button class="save-btn" type="submit">Save</button>
            @if(session('status'))
                <span class="status-toast">{{ session('status') }}</span>
            @endif
        </form>
    </div>
@endsection