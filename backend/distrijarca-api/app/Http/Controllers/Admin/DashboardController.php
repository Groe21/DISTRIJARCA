<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Mensaje;
use App\Models\Newsletter;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_productos' => Product::where('activo', true)->count(),
            'total_categorias' => Category::count(),
            'mensajes_pendientes' => Mensaje::where('leido', false)->count(),
            'suscriptores' => Newsletter::where('activo', true)->count(),
        ];

        $mensajes_recientes = Mensaje::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $productos_recientes = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'mensajes_recientes', 'productos_recientes'));
    }
}
