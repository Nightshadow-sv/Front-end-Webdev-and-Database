<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Genre;
use App\Models\SavedArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Home: Feed + Featured + Trending + Filters + Search
     */
    public function index(Request $request)
    {
        $search = trim($request->get('q', ''));
        $genreName = $request->get('genre', 'All');

        $genres = Genre::orderBy('name')->get();

        // Base query: only live articles, ordered by published date
        $baseQuery = Article::with('genre')
            ->live()
            ->orderByDesc('published_at')
            ->distinct('id');

        // Filter by genre if not "All"
        if ($genreName !== 'All') {
            $genre = Genre::where('name', $genreName)->first();
            if ($genre) {
                $baseQuery->where('genre_id', $genre->id);
            }
        }

        // Search filter
        if ($search !== '') {
            $baseQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%");
            });
        }

        // Paginate articles
        $articles = $baseQuery->paginate(12);

        // Add is_saved flag for each article
        $sessionId = $this->sessionId($request);
        $savedIds = SavedArticle::where('session_id', $sessionId)->pluck('article_id')->toArray();

        foreach ($articles as $article) {
            $article->is_saved = in_array($article->id, $savedIds);
        }

        // Featured: most recent published article
        $featured = Article::live()
    ->orderByDesc('published_at')
    ->first(); // returns a single Article model

        // Trending: top 5 latest, excluding featured
        $trending = Article::live()
            ->orderByDesc('published_at')
            ->where('id', '!=', $featured?->id)
            ->take(5)
            ->get();

        return view('pages.home', compact(
            'articles',
            'genres',
            'featured',
            'trending',
            'genreName',
            'search'
        ));
    }

    /**
     * Genre page (same layout; locked to genre)
     */
    public function genre(Request $request, string $genreName)
    {
        $request->merge(['genre' => $genreName]); // reuse index logic
        return $this->index($request);
    }

    /**
     * Show single article
     */
    public function show(string $id)
    {
        $article = Article::with('genre')->live()->findOrFail($id);

        // Add is_saved flag for single article
        $sessionId = $this->sessionId(request());
        $savedIds = SavedArticle::where('session_id', $sessionId)->pluck('article_id')->toArray();
        $article->is_saved = in_array($article->id, $savedIds);

        return view('pages.article', compact('article'));
    }

    /**
     * Saved articles page
     */
    public function saved(Request $request)
    {
        $sessionId = $this->sessionId($request);

        $saved = SavedArticle::where('session_id', $sessionId)
            ->with(['article' => function ($q) {
                $q->live();
            }])
            ->latest()
            ->get()
            ->filter(fn($s) => $s->article !== null);

        // Add is_saved flag for saved articles
        foreach ($saved as $s) {
            $s->article->is_saved = true;
        }

        return view('pages.saved', compact('saved'));
    }

    /**
     * Toggle save/unsave
     */
    public function toggleSave(Request $request, string $articleId)
    {
        $article = Article::live()->findOrFail($articleId);
        $sessionId = $this->sessionId($request);

        $existing = SavedArticle::where('session_id', $sessionId)
            ->where('article_id', $article->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('status', 'Removed from Saved');
        } else {
            SavedArticle::create([
                'session_id' => $sessionId,
                'article_id' => $article->id,
            ]);
            return back()->with('status', 'Saved');
        }
    }

    /**
     * Generate unique session ID for visitor
     */
    private function sessionId(Request $request): string
    {
        if (!$request->session()->has('visitor_session')) {
            $request->session()->put('visitor_session', Str::uuid()->toString());
        }
        return $request->session()->get('visitor_session');
    }
}