<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{

    public function store(User $user)
    {
        $follower = Auth::user();

        if ($follower->isFollowing($user)) {
            return back();
        }

        if ($follower->id === $user->id) {
            return back();
        }

        $follower->following()->attach($user->id);

        return back()->with('success', 'Berhasil mengikuti ' . $user->name);
    }

    public function destroy(User $user)
    {
        $follower = Auth::user();

        $follower->following()->detach($user->id);

        return back()->with('success', 'Berhenti mengikuti ' . $user->name);
    }
}
