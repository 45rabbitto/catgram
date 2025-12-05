<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:500',
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $post_id = $comment->post_id;
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }
}
