@php
    $categories = ['All','Technology','Business','Politics','Science','Health','Sports'];
@endphp
<div class="filters">
    @foreach($categories as $cat)
        @php
            $isActive = ($genreName ?? 'All') === $cat;
            $url = $cat === 'All' ? route('home') : route('genre.show', $cat);
            if (!empty($search)) {
                $url .= (parse_url($url, PHP_URL_QUERY) ? '&' : '?') . 'q=' . urlencode($search);
            }
        @endphp
        <a href="{{ $url }}" class="{{ $isActive ? 'active' : '' }}">{{ $cat }}</a>
    @endforeach
</div>