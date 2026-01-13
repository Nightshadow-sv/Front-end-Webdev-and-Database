@extends('layouts.app')

@section('content')
    <h1 class="page-title">SAVED</h1>
    <p class="sub">THE FEED</p>
    <hr class="title-divider">

    <div style="margin-bottom:20px;">
        <div class="featured-title">SAVED ARTICLES {{ $saved->count() }}</div>
    </div>

    <div class="grid">
        @forelse($saved as $item)
            <x-article-card :article="$item->article" />
        @empty
            <div>You haven’t saved any articles yet.</div>
        @endforelse
    </div>

    <hr class="title-divider">

    <h3 style="font-family:'Source Serif 4'; font-size:24px; line-height:32px; font-weight:700; margin:0 0 10px 0;">
        THE FEED
    </h3>
    <p class="sub">News from around the world</p>
@endsection