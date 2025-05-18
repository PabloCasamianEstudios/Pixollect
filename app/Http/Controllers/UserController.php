<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller {

    //  principal user
    public function show(User $user){
    $gamesCount = $user->games()->count();
    $userGames = $user->games()->withPivot('state','mastered','user_score','comment','progress','achievements_unlocked','hours_played','start_date','end_date')->get();



    return Inertia::render('User/Profile', [
        'user' => $user,
        'gamesCount' => $gamesCount,
        'userGames' => $userGames,
    ]);

}


// Sacar los juegos del usuario
public function games(User $user) {
    $games = $user->games()->with(['genres', 'platforms', 'themes'])->get();

    return Inertia::render('User/Games', [
        'user' => $user,
        'games' => $games,
    ]);
}

    // sacar todas las collections
    public function collections() {
        $users = User::with('games')->select('id','name','avatar_url')->get();
        return Inertia::render('Collections', [
            'users' => $users,
        ]);
    }

    // user achievements (los de Pixollect)
    public function achievements(User $user){
    return Inertia::render('User/Achievements', [
        'user' => $user,
    ]);
}

/**
 * Cambiar foto de perfil de un usuario
 */
public function updateAvatar(Request $request, User $user) {
    $validated = $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
        unlink(public_path($user->avatar_url));
    }

    $filename = time().'.'.$request->avatar->extension();
    $request->avatar->move(public_path('avatars'), $filename);

    $user->update([
        'avatar_url' => '/avatars/'.$filename
    ]);

    return back()->with('success', 'Updated profile picture.');
}

// setting del usuario
public function editSettings(User $user)
{
    if (Auth::id() !== $user->id) {
        abort(403);
    }

    return Inertia::render('User/Settings', [
        'user' => $user,
    ]);
}

public function updateSettings(Request $request, User $user)
{
    if (Auth::id() !== $user->id) {
        abort(403);
    }

    $request->validate([
        'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
        'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        'current_password' => ['required'],
        'password' => ['nullable', 'confirmed', 'min:8'],
    ]);

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Incorrect current password.']);
    }

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return back()->with('success', 'Account settings updated.');
}
}
