@if($trending->count() > 0)
<div class="trending-wrap">
    <div class="featured-title">TRENDING</div>
    <div class="trending-grid">
        @foreach($trending as $i => $t)
            <div class="trend-item">
                <div class="trend-rank">#{{ $i+1 }}</div>
                <div class="trend-genre">{{ strtoupper($t->genre->name) }}</div>
                <div class="trend-title">{{ $t->title }}</div>
                <div class="trend-meta">
                    {{ optional($t->published_at)->format('d/m/Y') }} • By {{ $t->author_name }}
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif