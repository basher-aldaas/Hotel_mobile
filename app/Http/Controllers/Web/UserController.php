<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index' , compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role == 1) {
            return redirect()->route('users.index')->with('error', 'Cannot delete admin.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('status', 'User deleted successfully.');
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:0,1',
            'phone' => 'required',
            'wallet' => 'required'
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('status', 'User updated successfully.');
    }


}
