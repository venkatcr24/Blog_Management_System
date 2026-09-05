<?php namespace App\Http\Controllers;
use App\Models\Blog;
class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
    public function admin()
    {
        $pendingBlogs = Blog::with(['user', 'category'])->where('status', 'pending')
            ->latest()
            ->get();
        return view('admin.dashboard', compact('pendingBlogs'));
    }
} ?>
