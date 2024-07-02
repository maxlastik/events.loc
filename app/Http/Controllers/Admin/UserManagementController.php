<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 2)->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User has been deleted');
    }

    /**
     * Ban/Unban user.
     */
    public function ban(User $user)
    {
        if ($user->status == 1) {
            $user->status = 0;
            $successMessage = 'User has been banned';
        } else {
            $user->status = 1;
            $successMessage = 'User is active now';
        }
        $user->save();

        return redirect()->route('admin.users.index')->with('success', $successMessage);
    }
}

