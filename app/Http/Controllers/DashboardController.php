<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class DashboardController extends Controller
{


public function dashboard()
{
    $usersCount = User::count();
    $activeUsers = User::where('is_active', 1)->count();
    $adminCount = User::where('role', 'admin')->count();
    $postsCount = Post::count(); // if you have posts table

    return view('dashboard', compact(
        'usersCount',
        'activeUsers',
        'adminCount',
        'postsCount'
    ));
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
