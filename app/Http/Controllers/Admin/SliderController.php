<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->paginate(5);
        return view('admin.slider.index',compact('sliders'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'link'  => 'required'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/sliders', $image->hashName());

        //save to DB
        $slider = Slider::create([
            'image' => $image->hashName(),
            'link'  => $request->link,
        ]);

        if ($slider) {
            // redirec dengan pesan sukses
            return redirect()->route('admin.slider.index')->with(['success' => 'Data Berhasil Dsimpan']);
        } else {
            return redirect()->route('admin.slider.index')->with(['error' => 'Data Gagal Dsimpan']);
        }
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $image = Storage::disk('local')->delete('public/slider/'.$slider->image);
        $slider->delete();

        if ($slider) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
        
    }
}
