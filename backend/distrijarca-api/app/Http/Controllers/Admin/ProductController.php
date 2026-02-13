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
            'marca' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'codigo_barras' => 'nullable|string|max:50',
            'precio_caja' => 'required|numeric|min:0',
            'precio_unidad' => 'nullable|numeric|min:0',
            'precio_mayoreo' => 'nullable|numeric|min:0',
            'unidades_por_caja' => 'required|integer|min:1',
            'peso_caja' => 'nullable|numeric|min:0',
            'peso_unidad' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'cantidad_minima_pedido' => 'required|integer|min:1',
            'cantidad_mayoreo' => 'nullable|integer|min:1',
            'stock_alerta' => 'required|integer|min:0',
            'unidad_medida' => 'required|string',
            'caracteristicas' => 'nullable|string',
            'origen' => 'nullable|string|max:100',
            'fecha_vencimiento' => 'nullable|date',
            'dias_caducidad' => 'nullable|integer|min:1',
            'temperatura_almacenamiento' => 'nullable|string|max:100',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Normalizar precios
        $validated['precio_caja'] = str_replace(',', '.', $validated['precio_caja']);
        if (isset($validated['precio_unidad'])) {
            $validated['precio_unidad'] = str_replace(',', '.', $validated['precio_unidad']);
        }
        if (isset($validated['precio_mayoreo'])) {
            $validated['precio_mayoreo'] = str_replace(',', '.', $validated['precio_mayoreo']);
        }
        
        $validated['activo'] = $request->has('activo');
        $validated['destacado'] = $request->has('destacado');

        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('products', 'public');
        }

        $product = Product::create($validated);

        ActivityLog::log('create_product', "Producto '{$product->nombre}' creado (SKU: {$product->sku})", Product::class, $product->id);

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
            'marca' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'sku' => 'nullable|string|max:50|unique:products,sku,' . $product->id,
            'codigo_barras' => 'nullable|string|max:50',
            'precio_caja' => 'required|numeric|min:0',
            'precio_unidad' => 'nullable|numeric|min:0',
            'precio_mayoreo' => 'nullable|numeric|min:0',
            'unidades_por_caja' => 'required|integer|min:1',
            'peso_caja' => 'nullable|numeric|min:0',
            'peso_unidad' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'cantidad_minima_pedido' => 'required|integer|min:1',
            'cantidad_mayoreo' => 'nullable|integer|min:1',
            'stock_alerta' => 'required|integer|min:0',
            'unidad_medida' => 'required|string',
            'caracteristicas' => 'nullable|string',
            'origen' => 'nullable|string|max:100',
            'fecha_vencimiento' => 'nullable|date',
            'dias_caducidad' => 'nullable|integer|min:1',
            'temperatura_almacenamiento' => 'nullable|string|max:100',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Normalizar precios
        $validated['precio_caja'] = str_replace(',', '.', $validated['precio_caja']);
        if (isset($validated['precio_unidad'])) {
            $validated['precio_unidad'] = str_replace(',', '.', $validated['precio_unidad']);
        }
        if (isset($validated['precio_mayoreo'])) {
            $validated['precio_mayoreo'] = str_replace(',', '.', $validated['precio_mayoreo']);
        }
        
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

        ActivityLog::log('update_product', "Producto '{$product->nombre}' actualizado (SKU: {$product->sku})", Product::class, $product->id);

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
