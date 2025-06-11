<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function index()
    {
        if (auth()->user()->isSuperAdmin()) {
            $shortUrls = ShortUrl::with(['user', 'company'])->get();
        } elseif (auth()->user()->isAdmin()) {
            $shortUrls = ShortUrl::where('company_id', auth()->user()->company_id)
                ->with('user')
                ->get();
        } else {
            $shortUrls = auth()->user()->shortUrls;
        }

        return view('short_urls.index', compact('shortUrls'));
    }

    public function create()
    {
        return view('short_urls.create');
    }

public function store(Request $request)
{
    if (auth()->user()->isSuperAdmin()) {
        abort(403, 'SuperAdmin cannot create short URLs.');
    }
    
    $request->validate([
        'original_url' => 'required|url'
    ]);

    $shortCode = Str::random(6);

    ShortUrl::create([
        'original_url' => $request->original_url,
        'short_code' => $shortCode,
        'user_id' => auth()->id(),
        'company_id' => auth()->user()->company_id,
    ]);

    // Return success message with full short URL
    $shortUrl = url("/s/{$shortCode}");
    
    return redirect()->route('short-urls.index')
        ->with('success', 'Short URL created successfully.')
        ->with('short_url', $shortUrl);
}

    public function redirect($code)
    {
        $shortUrl = ShortUrl::where('short_code', $code)->firstOrFail();
        return redirect($shortUrl->original_url);
    }
}