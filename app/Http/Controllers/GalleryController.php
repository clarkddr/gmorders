<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Supplier;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'galleries' => Gallery::with('suppliers')->latest()->get()
        ];        
        return view('galleries.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'suppliers' => Supplier::orderBy('name')->get()
        ];        
        return view('galleries.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $gallery = Gallery::create();
        if($suppliers = $request->suppliers) {
            foreach ($suppliers as $supplier){
                $gallery->supplier($supplier);
            }
        }

        return redirect('galleries')->with('banner',['type' => 'success','message' => 'La galería se ha agregado exitosamente.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {        
        $data = [
            'gallery' => $gallery = $gallery->load('suppliers'),
            'suppliers' => Supplier::orderBy('name')->get()
        ];
        
        return view('galleries.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {        
        $request->validate([
            'code' => ['required','regex:/^(?!^\d+$)[\p{L}\p{N}_\- ]+$/u','max:30'],
        ],[
            'code.regex' => 'El campo :attribute debe contener solo letras, números, guiones, guiones bajos y espacios.'
        ],[            
            'code' => 'código'            
        ]);
        $gallery->code = $request->code;
        $gallery->saveOrFail();
        // Obtener los IDs de los suppliers actuales
        $currentSuppliers = $gallery->suppliers->pluck('id')->toArray();

        // Obtener los IDs de los suppliers enviados en la request
        $newSuppliers = $request->suppliers ?: [];

        // Calcular los suppliers que deben ser agregados
        $suppliersToAdd = array_diff($newSuppliers, $currentSuppliers);

        // Calcular los suppliers que deben ser eliminados
        $suppliersToRemove = array_diff($currentSuppliers, $newSuppliers);

        // Agregar los nuevos suppliers
        if (!empty($suppliersToAdd)) {
            foreach ($suppliersToAdd as $supplierId) {
                $gallery->suppliers()->attach($supplierId);
            }
        }

        // Eliminar los suppliers que ya no están seleccionados
        if (!empty($suppliersToRemove)) {
            foreach ($suppliersToRemove as $supplierId) {
                $gallery->suppliers()->detach($supplierId);
            }
        }

        return redirect()->route('galleries.index')->with('banner',['type' => 'success','message' => 'La galería se ha actualizado.'])->withInput();        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect('galleries')->with('banner',['type' => 'success','message' => 'La galería se ha borrado exitosamente.']);
    }
}
