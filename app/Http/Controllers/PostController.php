<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function dashboard()
    {
        $user = Auth::user();
        
        $following_ids = $user->following()->pluck('users.id')->toArray();
        
        $following_ids[] = $user->id;

        $posts = Post::whereIn('user_id', $following_ids)
            ->with(['user', 'comments.user', 'likes'])
            ->latest()
            ->paginate(10);

        return view('dashboard', [
            'posts' => $posts,
            'user' => $user,
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'caption' => 'nullable|string|max:2000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image_path = $request->file('image')->store('posts', 'public');

        Post::create([
            'user_id' => Auth::id(),
            'caption' => $validated['caption'] ?? null,
            'image_path' => $image_path,
        ]);

        return redirect()->route('dashboard')->with('success', 'Postingan berhasil dibuat!');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'likes']);

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    public function destroy(Post $post)
    {
        // Check if user is authorized to delete
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Anda tidak diizinkan untuk menghapus postingan ini.');
        }

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()->back()->with('success', 'Postingan berhasil dihapus!');
    }


    public function edit(Post $post)
    {
        
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Anda tidak diizinkan untuk mengedit postingan ini.');
        }

        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, Post $post)
    {
       
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Anda tidak diizinkan untuk mengubah postingan ini.');
        }

        $validated = $request->validate([
            'caption' => 'nullable|string|max:2000',
        ]);

        $post->update([
            'caption' => $validated['caption'] ?? null,
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'Postingan berhasil diperbarui!');
    }

    public function profile(User $user)
    {
        $posts = $user->posts()->latest()->paginate(12);
        $followers_count = $user->followers()->count();
        $following_count = $user->following()->count();
        $is_following = Auth::check() ? Auth::user()->isFollowing($user) : false;

        return view('profile.show', [
            'user' => $user,
            'posts' => $posts,
            'followers_count' => $followers_count,
            'following_count' => $following_count,
            'is_following' => $is_following,
        ]);
    }

    public function explore(Request $request)
    {
        $search = $request->get('search');
        $currentUser = Auth::user();

        $query = User::where('id', '!=', $currentUser->id);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(12);

        return view('explore', [
            'users' => $users,
            'search' => $search,
        ]);
    }
}
