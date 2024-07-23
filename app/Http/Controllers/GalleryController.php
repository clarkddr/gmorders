<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'galleries' => Gallery::latest()->get()
        ];
        
        return view('galleries.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {       
        Gallery::create();
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
        return view('galleries.edit',['gallery'=>$gallery]);
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
