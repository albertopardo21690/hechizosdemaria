<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderByDesc('featured')->orderBy('sort')->paginate(30);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.form', ['testimonial' => null]);
    }

    public function store(Request $request)
    {
        Testimonial::create($this->validate($request));

        return redirect()->route('admin.testimonials.index')->with('status', 'Testimonio creado.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $testimonial->update($this->validate($request));

        return redirect()->route('admin.testimonials.edit', $testimonial)->with('status', 'Actualizado.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('status', 'Eliminado.');
    }

    protected function validate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:120',
            'location' => 'nullable|string|max:120',
            'text' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'service_type' => 'nullable|in:lectura,ritual,producto,curso,otro',
            'featured' => 'nullable|boolean',
            'approved' => 'nullable|boolean',
            'sort' => 'nullable|integer',
        ]) + ['featured' => $request->boolean('featured'), 'approved' => $request->boolean('approved')];
    }
}
