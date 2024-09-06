<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Image;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'galleries' => Gallery::with('images.supplier')->latest()->get()
        ];
        
        return view('galleries.index',$data);
    }

    public function select(){
        $data = [
            'galleries' => Gallery::with('images.supplier')->latest()->get()
        ];
        return view('galleries.select',$data);
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
        return redirect('galleries')->with('banner',['type' => 'success','message' => 'La galería se ha agregado exitosamente.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return $gallery;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {        
        $data = [            
            'gallery' => $gallery->load('images.supplier'),
            'suppliers' => Supplier::all()
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
            'images.*' => ['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ],[
            'code.regex' => 'El campo :attribute debe contener solo letras, números, guiones, guiones bajos y espacios.'
        ],[            
            'code' => 'código',
            'images.*' => 'imagen'
        ]);        
        
        
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $file) {
                //$path = Storage::disk('public')->put('pictures',$file);
                $path = $file->store('images','public');
                Image::create([
                    'gallery_id' => $gallery->id,
                    'supplier_id' => $request->supplier_id,
                    'subcategory' => $request->subcategory,
                    'url' => $path
                ]);
            }
        }
        
        $gallery->code = $request->code;
        $gallery->saveOrFail();


        return redirect()->back()->with('banner',['type' => 'success','message' => 'La galería se ha actualizado.'])->withInput();        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect('galleries')->with('banner',['type' => 'success','message' => 'La galería se ha borrado exitosamente.']);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        return $request->all();

        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $file) {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('images'), $name);
            }
        }

        return redirect('galleries')->with('banner',['type' => 'success','message' => 'Las imágenes se han agregado exitosamente.']);
    }
}
