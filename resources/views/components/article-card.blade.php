@props(['article'])

<div style="
    position: relative;
    background: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-radius: 8px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    font-family: 'Inter', sans-serif;
">

    {{-- Save Button Square --}}
    <form method="POST" action="{{ route('articles.toggleSave', $article->id) }}" style="
        position: absolute;
        top: 12px;
        right: 12px;
    ">
        @csrf
        <button type="submit" style="
            background-color: {{ $article->is_saved ? '#E63946' : '#fff' }};
            border: 2px solid #333;
            border-radius: 4px;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            color: {{ $article->is_saved ? '#fff' : '#333' }};
        ">
            {{ $article->is_saved ? '✔' : '▢' }}
        </button>
    </form>

    {{-- Category Tag --}}
    <div style="
        background-color: #FFD700;
        color: black;
        font-weight: bold;
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        width: fit-content;
    ">
        {{ strtoupper($article->genre->name) }}
    </div>

    {{-- Title --}}
    <h2 style="
        font-size: 18px;
        font-weight: 600;
        margin: 0;
        color: #222;
    ">
        {{ $article->title }}
    </h2>

    {{-- Summary --}}
    <p style="
        font-size: 14px;
        color: #555;
        margin: 0;
    ">
        {{ $article->summary }}
    </p>

    {{-- Author + Date --}}
    <div style="
        font-size: 12px;
        color: #888;
        margin-top: auto;
    ">
        {{ \Carbon\Carbon::parse($article->published_at)->format('d/m/Y') }} • By {{ $article->author_name }}
    </div>
</div>