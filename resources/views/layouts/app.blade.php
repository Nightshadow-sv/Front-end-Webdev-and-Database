<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'THE FEED' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Space+Mono:wght@400;700&family=Source+Serif+4:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">

    <style>
        :root {
            --black:#000; --gray-900:#1a1a1a; --gray-700:#444; --gray-600:#666;
            --gray-500:#888; --red:#ff0000; --yellow:#FFFF00; --white:#fff;
        }

        body {
            font-family: 'DM Sans', Arial, sans-serif;
            background: var(--white);
            color: var(--gray-900);
            margin: 0;
        }

        .page {
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
            position: relative; /* Needed for SAVED button positioning */
        }

        /* ✅ SAVED button style */
        .saved-button {
            position: absolute;
            top: 24px;
            right: 24px;
            background-color: #fff;
            border: 2px solid #333;
            border-radius: 6px;
            padding: 6px 12px;
            font-weight: bold;
            font-size: 14px;
            text-decoration: none;
            color: #333;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        /* Page Title */
        .page-title { font-size: 30px; line-height: 36px; font-weight: 700; margin: 0; text-transform: uppercase; }
        .sub { font-size: 14px; line-height: 20px; color: var(--gray-600); margin-top: 5px; }
        .title-divider { border: 0; border-top: 1.5px solid var(--black); margin: 10px 0 25px 0; }

        /* Filters / chips */
        .filters { margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 10px; }
        .filters a {
            text-decoration: none; color: var(--black); font-weight: 700;
            font-size: 12px; line-height: 16px; text-transform: uppercase;
            padding: 8px 14px; border: 1.5px solid var(--black);
        }
        .filters a.active { background-color: var(--red); color: var(--white); border-color: var(--red); }

        /* Search */
        .search-row { margin: 15px 0 25px 0; }
        .search-input {
            width: 100%; max-width: 480px; padding: 10px 12px; border: 1.5px solid var(--black);
            font-size: 14px; line-height: 20px;
        }

        /* Grid */
        .grid { display: flex; flex-wrap: wrap; gap: 20px; }

        /* Card */
        .card {
            border: 1.5px solid var(--black); width: 320px; padding: 20px;
            cursor: pointer; display: flex; flex-direction: column; background: var(--white);
        }
        .card .genre-tag {
            background: var(--yellow); font-size: 12px; line-height: 16px; font-weight: 700;
            text-transform: uppercase; padding: 3px 8px; margin-bottom: 12px; align-self: flex-start;
        }
        .card h3 {
            font-family: 'Source Serif 4', 'Times New Roman', Times, serif;
            font-size: 18px; line-height: 28px; font-weight: 700; margin: 0 0 10px 0; color: var(--black);
        }
        .summary-preview {
            font-family: 'Source Serif 4', 'Times New Roman', Times, serif;
            font-size: 14px; line-height: 20px; color: var(--gray-700); margin-bottom: 15px;
        }
        .card-hr { border: 0; border-top: 1.5px solid var(--black); margin: 10px 0; }
        .card-footer {
            display: flex; justify-content: space-between;
            font-size: 14px; line-height: 20px; color: var(--gray-500); font-weight: 700;
        }
        .date { font-size: 12px; line-height: 16px; font-weight: 400; }

        /* Featured section */
        .featured-wrap { border: 1.5px solid var(--black); padding: 16px; margin-bottom: 25px; }
        .featured-title { font-weight: 700; text-transform: uppercase; font-size: 14px; line-height: 20px; }
        .featured-controls { display: flex; justify-content: space-between; font-size: 12px; line-height: 16px; margin-top: 10px; }
        .featured-controls button {
            border: 1.5px solid var(--black); background: var(--white); padding: 6px 10px;
            cursor: pointer; font-weight: 700; text-transform: uppercase;
        }

        /* Trending section */
        .trending-wrap { margin-top: 20px; }
        .trending-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .trend-item { border: 1.5px solid var(--black); padding: 12px; }
        .trend-rank { font-size: 12px; line-height: 16px; font-weight: 700; text-transform: uppercase; }
        .trend-genre { font-size: 12px; line-height: 16px; font-weight: 700; text-transform: uppercase; color: var(--black); }
        .trend-title {
            font-family: 'Source Serif 4'; font-size: 14px; line-height: 20px;
            font-weight: 700; margin: 6px 0; color: var(--black);
        }
        .trend-meta { font-size: 12px; line-height: 16px; color: var(--gray-500); }

        /* Article page */
        .back-btn {
            background: var(--white); border: 1.5px solid var(--black); padding: 8px 16px;
            font-size: 12px; line-height: 16px; font-weight: 700; cursor: pointer;
            text-transform: uppercase;
        }
        .tag {
            background: var(--yellow); padding: 4px 10px; font-size: 12px; line-height: 16px;
            font-weight: 700; text-transform: uppercase; display: inline-block;
        }
        .article-h1 {
            font-family: 'Source Serif 4', 'Times New Roman', Times, serif;
            font-size: 30px; line-height: 36px; font-weight: 700; margin: 20px 0; color: var(--black);
        }
        .meta-section { margin: 30px 0; }
        .meta-line { border: 0; border-top: 1.5px solid var(--black); margin: 12px 0; }
        .author-text {
            font-family: 'Source Serif 4', 'Times New Roman', Times, serif;
            font-size: 14px; line-height: 20px; color: var(--gray-500); display: block; font-weight: 700;
        }
        .date-text {
            font-family: 'Source Serif 4', 'Times New Roman', Times, serif;
            font-size: 12px; line-height: 16px; color: var(--gray-500); display: block; margin-top: 2px;
        }
        .summary-deck {
            font-family: 'Source Serif 4', 'Times New Roman', Times, serif;
            font-size: 24px; line-height: 32px; color: var(--gray-900); margin-bottom: 30px;
        }
        .body-main-wrapper { border-left: 5px solid var(--red); padding-left: 25px; margin-top: 25px; }
        .article-body {
            font-family: 'Source Serif 4', 'Times New Roman', Times, serif;
            font-size: 16px; line-height:

    </style>
</head>
<body>
    <div class="page">
        {{-- SAVED button in top-right corner --}}
        <a href="{{ route('saved.index') }}" class="saved-button">SAVED</a>

        {{-- Main content from child views --}}
        @yield('content')
    </div>
</body>
</html>