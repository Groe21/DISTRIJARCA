<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('orden')
            ->orderBy('nombre')
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:categories',
            'descripcion' => 'nullable|string',
            'orden' => 'nullable|integer|min:0',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $request->has('activo');

        $category = Category::create($validated);

        ActivityLog::log('create_category', "Categoría '{$category->nombre}' creada");

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría creada exitosamente');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:categories,nombre,' . $category->id,
            'descripcion' => 'nullable|string',
            'orden' => 'nullable|integer|min:0',
            'activo' => 'boolean',
        ]);

        $validated['activo'] = $request->has('activo');

        $category->update($validated);

        ActivityLog::log('update_category', "Categoría '{$category->nombre}' actualizada");

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría actualizada exitosamente');
    }

    public function destroy(Category $category)
    {
        $categoryName = $category->nombre;
        $productsCount = $category->products()->count();

        if ($productsCount > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', "No se puede eliminar la categoría '{$categoryName}' porque tiene {$productsCount} producto(s) asociado(s)");
        }

        $category->delete();

        ActivityLog::log('delete_category', "Categoría '{$categoryName}' eliminada");

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría eliminada exitosamente');
    }

    public function toggleStatus(Category $category)
    {
        $category->activo = !$category->activo;
        $category->save();

        $status = $category->activo ? 'activada' : 'desactivada';
        ActivityLog::log('toggle_category_status', "Categoría '{$category->nombre}' {$status}");

        return response()->json([
            'success' => true,
            'activo' => $category->activo,
            'message' => "Categoría {$status} exitosamente"
        ]);
    }
}
