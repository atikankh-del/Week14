<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::where('status', 'active')->latest()->orderByDesc('id')->get();

        return view('welcome', compact('blogs'));
    }

    public function show(string $id): View
    {
        return $this->detail($id);
    }

    public function detail(string $id): View
    {
        $blog = Blog::where('status', 'active')->findOrFail($id);

        $config = \HTMLPurifier_Config::createDefault();
        $config->set('Cache.DefinitionImpl', null);
        $config->set('URI.AllowedSchemes', [
            'http' => true, 'https' => true, 'mailto' => true, 'data' => true,
        ]);
        $config->set('HTML.SafeIframe', true);
        $config->set('URI.SafeIframeRegexp', '~^(?:https:)?//(?:www\.)?(?:youtube\.com/embed/|youtube-nocookie\.com/embed/|player\.vimeo\.com/video/)[A-Za-z0-9_-]+(?:[?][^\\s]*)?$~D');
        $blog->content = (new \HTMLPurifier($config))->purify($blog->content);

        return view('detail', compact('blog'));
    }
}
