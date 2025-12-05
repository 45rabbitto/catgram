<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function editProfile()
    {
        $user = Auth::user();

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('profile.show', $user)->with('success', 'Profil berhasil diperbarui!');
    }


    public function followers(User $user)
    {
        
        $followers = $user->followers()->paginate(12);

        return view('profile.followers', [
            'user' => $user,
            'followers' => $followers,
        ]);
    }


    public function following(User $user)
    {
        
        $following = $user->following()->paginate(12);

        return view('profile.following', [
            'user' => $user,
            'following' => $following,
        ]);
    }
}
