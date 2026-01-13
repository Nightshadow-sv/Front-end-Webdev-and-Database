@if ($featured)
    <div class="featured-wrap" style="position:relative; padding-bottom:30px;">
        <div class="featured-title" style="color:#fff; background:#c00; padding:4px 8px; font-weight:700; font-size:12px; display:inline-block;">
            FEATURED
        </div>

        <div style="margin-top:10px;">
            <a href="{{ route('articles.show', $featured->id) }}" style="text-decoration:none; color:inherit;">
                <h3 style="margin:0; font-family:'Source Serif 4'; font-size:18px; line-height:28px; font-weight:700;">
                    {{ $featured->title }}
                </h3>
                <div class="summary-preview">{{ $featured->summary }}</div>
            </a>
            <div style="font-size:12px; line-height:16px; color:#888; font-weight:700; margin-top:6px;">
                By {{ $featured->author_name }}
                {{ optional($featured->published_at)->format('d/m/Y') }}
                @if($featured->views)
                    • {{ number_format($featured->views) }} views
                @endif
            </div>
        </div>
    </div>
@else
    <p>No featured article available.</p>
@endif