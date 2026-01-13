<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Models\Article;
use App\Models\Genre;

// Homepage
Route::get('/', [ArticleController::class, 'index'])->name('home');

// Genre route (e.g., /genre/Technology)
Route::get('/genre/{name}', [ArticleController::class, 'genre'])->name('genre.show');

// Article detail
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

// Saved articles page
Route::get('/saved', [ArticleController::class, 'saved'])->name('saved.index');

// ✅ Toggle save/unsave (used by your article-card.blade.php)
Route::post('/articles/{id}/toggle-save', [ArticleController::class, 'toggleSave'])
    ->name('articles.toggleSave');

// --- Test route to quickly add an article ---
Route::get('/add-test-article', function () {
    $genre = Genre::first(); // pick the first genre for now

    Article::create([
        'genre_id'      => $genre->id,
        'title'         => 'Test Article',
        'summary'       => 'This is a test summary.',
        'content'       => '<p>This is the full test content.</p>',
        'status'        => 'Published',
        'published_at'  => now(),
        'author_name'   => 'Test Author',
        'featured_image'=> '/assets/images/sample.jpg',
    ]);

    return 'Article added!';
});