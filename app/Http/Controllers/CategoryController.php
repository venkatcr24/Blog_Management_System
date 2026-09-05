<?php namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('blogs')->orderBy('name')
            ->get();
        return view('categories.index', compact('categories'));
    }
    public function create()
    {
        return view('categories.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:255|unique:categories,name', ]);
        Category::create(['name' => $validated['name'], 'slug' => $this->generateUniqueSlug($validated['name']) , ]);
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate(['name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id, ], ]);
        if ($category->name !== $validated['name'])
        {
            $category->slug = $this->generateUniqueSlug($validated['name'], $category->id);
        }
        $category->name = $validated['name'];
        $category->save();
        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }
    public function destroy(Category $category)
    {
        if ($category->blogs()
            ->exists())
        {
            return redirect()
                ->route('categories.index')
                ->with('error', 'This category cannot be deleted because it contains blogs.');
        }
        $category->delete();
        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
    private function generateUniqueSlug(string $name, ? int $ignoreId = null) : string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;
        while (Category::where('slug', $slug)->when($ignoreId, function ($query) use ($ignoreId)
        {
            $query->where('id', '!=', $ignoreId);
        })->exists())
        {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }
} ?>