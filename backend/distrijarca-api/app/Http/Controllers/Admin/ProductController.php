<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::activos()->orderBy('nombre')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unidad_medida' => 'required|string',
            'caracteristicas' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Normalizar el precio
        $validated['precio'] = str_replace(',', '.', $validated['precio']);
        
        $validated['activo'] = $request->has('activo');
        $validated['destacado'] = $request->has('destacado');

        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('products', 'public');
        }

        $product = Product::create($validated);

        ActivityLog::log('create_product', "Producto '{$product->nombre}' creado", Product::class, $product->id);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto creado exitosamente');
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::activos()->orderBy('nombre')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unidad_medida' => 'required|string',
            'caracteristicas' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Normalizar el precio
        $validated['precio'] = str_replace(',', '.', $validated['precio']);
        
        $validated['activo'] = $request->has('activo');
        $validated['destacado'] = $request->has('destacado');

        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($product->imagen) {
                Storage::disk('public')->delete($product->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('products', 'public');
        }

        $product->update($validated);

        ActivityLog::log('update_product', "Producto '{$product->nombre}' actualizado", Product::class, $product->id);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Product $product)
    {
        $productName = $product->nombre;

        // Eliminar imagen si existe
        if ($product->imagen) {
            Storage::disk('public')->delete($product->imagen);
        }

        $product->delete();

        ActivityLog::log('delete_product', "Producto '{$productName}' eliminado");

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente');
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['activo' => !$product->activo]);

        $status = $product->activo ? 'activado' : 'desactivado';
        ActivityLog::log('toggle_product_status', "Producto '{$product->nombre}' {$status}", Product::class, $product->id);

        return redirect()->back()->with('success', "Producto {$status} exitosamente");
    }

    public function toggleFeatured(Product $product)
    {
        $product->update(['destacado' => !$product->destacado]);

        $status = $product->destacado ? 'marcado como destacado' : 'desmarcado como destacado';
        ActivityLog::log('toggle_product_featured', "Producto '{$product->nombre}' {$status}", Product::class, $product->id);

        return redirect()->back()->with('success', "Producto {$status} exitosamente");
    }
}
