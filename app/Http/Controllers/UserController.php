<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $trashed = User::onlyTrashed()->count();
        return view('modules.usuarios', compact('users', 'trashed'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('eliminar', 'ok');
    }

    public function trashed_users()
    {

        $trashed = User::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.usertrashed", [
            "trashed" => $trashed
        ]);
    }

    public function do_restore()
{
    $user = User::withTrashed()->find(request()->id);
    if ($user == null)
    {
        abort(404);
    }
 
    $user->restore();
    return redirect()->back();
}

public function delete_permanently()
{
    $user = User::withTrashed()->find(request()->id);
    if ($user == null)
    {
        abort(404);
    }
 
    $user->forceDelete();
    return redirect()->back();
}
}
