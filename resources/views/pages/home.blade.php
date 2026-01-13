@extends('layouts.app')

@section('content')
    <h1 class="page-title">THE FEED</h1>
    <p class="sub">News from around the world</p>
    <hr class="title-divider">

    {{-- Featured --}}
    @include('partials.featured', ['featured' => $featured])

    {{-- Trending --}}
    <div style="margin-top:32px;">
        @include('partials.trending', ['trending' => $trending])
    </div>

    {{-- Filters --}}
    <div style="margin-top:40px;">
        @include('partials.filters', ['genreName' => $genreName, 'search' => $search ?? ''])
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('home') }}" class="search-row">
        @if(($genreName ?? 'All') !== 'All')
            <input type="hidden" name="genre" value="{{ $genreName }}">
        @endif
        <input class="search-input" type="text" name="q"
               placeholder="Search articles by title, author, or keyword ..."
               value="{{ $search ?? '' }}">
    </form>

    {{-- Article grid --}}
    <div style="margin: 0 auto; max-width: 1200px; padding: 0 24px;">
        <div style="
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 32px;
            padding-top: 24px;
            padding-bottom: 24px;
        ">
            @foreach($articles as $article)
                <a href="{{ route('articles.show', $article->id) }}" style="text-decoration:none; color:inherit;">
                    <x-article-card :article="$article" />
                </a>
            @endforeach
        </div>
    </div>
@endsection