<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedArticle;

class SavedController extends Controller
{
    /**
     * Toggle save/unsave for an article based on session.
     */
    public function toggle($id)
    {
        $sessionId = session()->getId();

        $existing = SavedArticle::where('session_id', $sessionId)
            ->where('article_id', $id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('status', 'Removed from Saved');
        }

        SavedArticle::create([
            'session_id' => $sessionId,
            'article_id' => $id,
        ]);

        return back()->with('status', 'Saved');
    }
}