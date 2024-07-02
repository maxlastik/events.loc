<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the admin's dashboard.
     */
    public function __invoke()
    {
        $recentUsers = User::where('role',2)->latest()->take(3)->get();
        $recentEvents = Event::latest()->take(3)->get();
        return view('admin.dashboard', compact('recentUsers','recentEvents'));
    }
}