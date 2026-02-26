<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSectionController extends Controller
{
    public function index()
    {
        $sections = HomeSection::with('category')
            ->ordenadas()
            ->get();

        $hero = \App\Models\HomeHero::first();
        $about = \App\Models\HomeAbout::first();
        $contact = \App\Models\HomeContact::first();
        
        return view('admin.home-sections.index', compact('sections', 'hero', 'about', 'contact'));
    }

    public function create()
    {
        $categories = Category::activos()->orderBy('nombre')->get();
        $iconos = $this->getIconosDisponibles();
        $colores = $this->getColoresDisponibles();
        
        return view('admin.home-sections.create', compact('categories', 'iconos', 'colores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'nullable|string|max:255',
            'descripcion' => 'required|string|max:500',
            'badge_texto' => 'nullable|string|max:50',
            'badge_color' => 'required|string|max:50',
            'icono' => 'required|string|max:100',
            'orden' => 'required|integer|min:0',
            'max_productos' => 'required|integer|min:1|max:10',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['activo'] = $request->has('activo');

        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('home-sections', 'public');
        }

        $section = HomeSection::create($validated);

        ActivityLog::log('create_home_section', "Sección home '{$section->titulo}' creada", HomeSection::class, $section->id);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Sección de home creada exitosamente');
    }

    public function show(HomeSection $homeSection)
    {
        $homeSection->load('category', 'productosDestacados');
        return view('admin.home-sections.show', compact('homeSection'));
    }

    public function edit(HomeSection $homeSection)
    {
        $categories = Category::activos()->orderBy('nombre')->get();
        $iconos = $this->getIconosDisponibles();
        $colores = $this->getColoresDisponibles();
        
        return view('admin.home-sections.edit', compact('homeSection', 'categories', 'iconos', 'colores'));
    }

    public function update(Request $request, HomeSection $homeSection)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'titulo' => 'required|string|max:255',
            'subtitulo' => 'nullable|string|max:255',
            'descripcion' => 'required|string|max:500',
            'badge_texto' => 'nullable|string|max:50',
            'badge_color' => 'required|string|max:50',
            'icono' => 'required|string|max:100',
            'orden' => 'required|integer|min:0',
            'max_productos' => 'required|integer|min:1|max:10',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['activo'] = $request->has('activo');

        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($homeSection->imagen) {
                Storage::disk('public')->delete($homeSection->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('home-sections', 'public');
        }

        $homeSection->update($validated);

        ActivityLog::log('update_home_section', "Sección home '{$homeSection->titulo}' actualizada", HomeSection::class, $homeSection->id);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Sección de home actualizada exitosamente');
    }

    public function destroy(HomeSection $homeSection)
    {
        $titulo = $homeSection->titulo;

        // Eliminar imagen si existe
        if ($homeSection->imagen) {
            Storage::disk('public')->delete($homeSection->imagen);
        }

        $homeSection->delete();

        ActivityLog::log('delete_home_section', "Sección home '{$titulo}' eliminada");

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Sección de home eliminada exitosamente');
    }

    public function toggleStatus(HomeSection $homeSection)
    {
        $homeSection->update(['activo' => !$homeSection->activo]);

        $status = $homeSection->activo ? 'activada' : 'desactivada';
        ActivityLog::log('toggle_home_section_status', "Sección home '{$homeSection->titulo}' {$status}", HomeSection::class, $homeSection->id);

        return redirect()->back()->with('success', "Sección {$status} exitosamente");
    }

    public function updateOrden(Request $request)
    {
        $request->validate([
            'secciones' => 'required|array',
            'secciones.*.id' => 'required|exists:home_sections,id',
            'secciones.*.orden' => 'required|integer|min:0',
        ]);

        foreach ($request->secciones as $seccion) {
            HomeSection::where('id', $seccion['id'])->update(['orden' => $seccion['orden']]);
        }

        ActivityLog::log('reorder_home_sections', "Orden de secciones home actualizado");

        return response()->json(['success' => true, 'message' => 'Orden actualizado exitosamente']);
    }

    // Helpers privados
    private function getIconosDisponibles()
    {
        return [
            'bi-star' => 'Estrella',
            'bi-gem' => 'Diamante',
            'bi-gift' => 'Regalo',
            'bi-award' => 'Premio',
            'bi-heart' => 'Corazón',
            'bi-fire' => 'Fuego',
            'bi-lightning' => 'Rayo',
            'bi-cup' => 'Copa',
            'bi-trophy' => 'Trofeo',
            'bi-box-seam' => 'Caja',
        ];
    }

    private function getColoresDisponibles()
    {
        return [
            'danger' => 'Rojo (danger)',
            'primary' => 'Azul (primary)',
            'warning' => 'Amarillo (warning)',
            'success' => 'Verde (success)',
            'info' => 'Celeste (info)',
            'dark' => 'Negro (dark)',
            'secondary' => 'Gris (secondary)',
        ];
    }
}
