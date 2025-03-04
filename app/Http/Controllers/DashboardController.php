<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        $totalUsers = User::count();
        $recentUsers = User::latest()->take(5)->get();
        
        return view('dashboard', compact('users', 'totalUsers', 'recentUsers'));
    }
}