<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        
        $data = [
            'suppliers' => Supplier::all()
        ];
        return view('supplier/index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {                
        /* Validate toma tres parametros como Array, el primero es cada uno de los input y sus validaciones, 
        el segundo es un array de los errores personalizados 'name.required' ejemplo
        el tercero es un array con los nombres personalizados de cada campo. */
        $request->validate([
            'name' => ['required','regex:/^(?!^\d+$)[\p{L}\p{N}_\- ]+$/u','max:30'],
        ],[
            'name.regex' => 'El campo :attribute debe contener solo letras, números, guiones, guiones bajos y espacios.'
        ],[            
            'name' => 'nombre'            
        ]);
        
        Supplier::create([
            'name' => $request->name
        ]);
        return redirect('suppliers')->with('banner',['type' => 'success','message' => 'El proveedor se ha agregado exitosamente.']);


    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {        
        $data = [
            'supplier' => Supplier::find($supplier->id)
        ];
        return view('supplier.edit',$data)->with('banner',['type' => 'success','message' => 'El proveedor se ha guardado.']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => ['required','regex:/^(?!^\d+$)[\p{L}\p{N}_\- ]+$/u','max:30'],
        ],[
            'name.regex' => 'El campo :attribute debe contener solo letras, números, guiones, guiones bajos y espacios.'
        ],[            
            'name' => 'nombre'            
        ]);
        $supplier->name = $request->name;
        $supplier->saveOrFail();
        return redirect()->route('suppliers.index')->with('banner',['type' => 'success','message' => 'El proveedor se ha actualizado.'])->withInput();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect('suppliers')->with('banner',['type' => 'success','message' => 'El proveedor se ha borrado exitosamente.']);
    }
}
