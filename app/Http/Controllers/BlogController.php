<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function publicIndex(Request $request)
    {
        $categories = Category::withCount([
            'blogs' => function ($query) {
                $query->where('status', 'published');
            }
        ])
        ->having('blogs_count', '>', 0)
        ->orderBy('name')
        ->get();

        $blogs = Blog::with(['user', 'category'])
            ->where('status', 'published')
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('blogs.public-index', compact('blogs', 'categories'));
    }


    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $blogs = Blog::with(['user', 'category'])
                ->latest()
                ->paginate(9);
        } else {
            $blogs = Blog::with(['user', 'category'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(9);
        }

        return view('blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,pending',
        ]);

        $blog = new Blog();

        $blog->title = $validated['title'];
        $blog->slug = $this->generateUniqueSlug($validated['title']);
        $blog->content = $validated['content'];
        $blog->user_id = Auth::id();
        $blog->category_id = $validated['category_id'];
        $blog->status = $validated['status'];

        if ($request->hasFile('image')) {
            $blog->image = $request
                ->file('image')
                ->store('blogs', 'public');
        }

        $blog->save();

        return redirect()
            ->route('blogs.index')
            ->with('success', 'Blog created successfully.');
    }

    public function show(Blog $blog)
    {
        $blog->load(['user', 'category']);

        if ($blog->status !== 'published') {
            if (!Auth::check()) {
                abort(404);
            }

            if (
                Auth::user()->role !== 'admin' &&
                Auth::id() !== $blog->user_id
            ) {
                abort(404);
            }
        }

        return view('blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $this->authorizeBlogAccess($blog);

        $categories = Category::orderBy('name')->get();

        return view('blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $this->authorizeBlogAccess($blog);

        $user = Auth::user();

        $statusRule = $user->role === 'admin'
            ? 'required|in:draft,pending,published,rejected'
            : 'required|in:draft,pending';

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => $statusRule,
        ]);

        $oldTitle = $blog->title;

        $blog->title = $validated['title'];

        if ($oldTitle !== $validated['title']) {
            $blog->slug = $this->generateUniqueSlug(
                $validated['title'],
                $blog->id
            );
        }

        $blog->content = $validated['content'];
        $blog->category_id = $validated['category_id'];
        $blog->status = $validated['status'];

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }

            $blog->image = $request
                ->file('image')
                ->store('blogs', 'public');
        }

        $blog->save();

        return redirect()
            ->route('blogs.show', $blog)
            ->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $this->authorizeBlogAccess($blog);

        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()
            ->route('blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }

    public function approve(Blog $blog)
    {
        $this->authorizeAdmin();

        if ($blog->status !== 'pending') {
            return back()
                ->with('error', 'Only pending blogs can be approved.');
        }

        $blog->status = 'published';
        $blog->save();

        return back()
            ->with('success', 'Blog approved and published successfully.');
    }

    public function reject(Blog $blog)
    {
        $this->authorizeAdmin();

        if ($blog->status !== 'pending') {
            return back()
                ->with('error', 'Only pending blogs can be rejected.');
        }

        $blog->status = 'rejected';
        $blog->save();

        return back()
            ->with('success', 'Blog rejected successfully.');
    }

    private function authorizeBlogAccess(Blog $blog): void
    {
        $user = Auth::user();

        if (
            $user->role !== 'admin' &&
            $user->id !== $blog->user_id
        ) {
            abort(403);
        }
    }

    private function authorizeAdmin(): void
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }
    }

    private function generateUniqueSlug(
        string $title,
        ?int $ignoreId = null
    ): string {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (
            Blog::where('slug', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}