<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::orderByDesc('published_at')->paginate(30);

        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.form', ['post' => null]);
    }

    public function store(Request $request)
    {
        BlogPost::create($this->validate($request));

        return redirect()->route('admin.blog.index')->with('status', 'Post creado.');
    }

    public function edit(BlogPost $post)
    {
        return view('admin.blog.form', compact('post'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $post->update($this->validate($request, $post));

        return redirect()->route('admin.blog.edit', $post)->with('status', 'Post actualizado.');
    }

    public function destroy(BlogPost $post)
    {
        $post->delete();

        return redirect()->route('admin.blog.index')->with('status', 'Eliminado.');
    }

    protected function validate(Request $request, ?BlogPost $post = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug'.($post ? ','.$post->id : ''),
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'category' => 'nullable|in:horoscopo,tarot,rituales,espiritualidad,noticias',
            'zodiac_sign' => 'nullable|in:aries,tauro,geminis,cancer,leo,virgo,libra,escorpio,sagitario,capricornio,acuario,piscis',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);
    }
}
