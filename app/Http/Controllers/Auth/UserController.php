<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
         $users = User::paginate(5);

        return view('admin.pages.user.index', compact('users'));
    }
    public function destroy($user_id)
    {
        $user = User::findOrFail($user_id);

        if ($user->role == 1) {
            return back()->with('error', 'Prohibited Action.');
        }

        $user->delete();
        return back()->with('success', 'Successfull User Removed.');
    }
    public function toggleRole($user_id)
    {
        $user = User::findOrFail($user_id);

        if ($user->id == auth()->id()) {
            return back()->with('error', 'Prohibited Action.');
        }

        $user->role = $user->role == 1 ? 0 : 1;
        $user->save();

        return back()->with('success', 'Successful Role changed.');
    }
}
