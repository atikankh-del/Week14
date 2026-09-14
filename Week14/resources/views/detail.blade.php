@extends('layouts.app')

@section('title', $blog->title)

@section('content')
    <article>
        <h1>{{ $blog->title }}</h1>
        <hr>
        <div class="article-content" style="overflow-wrap: anywhere;">{!! $blog->content !!}</div>
    </article>
    <a href="{{ route('welcome') }}" class="btn btn-outline-secondary mt-4">กลับหน้าแรก</a>
    <style>
        .article-content img {
            max-width: min(100%, 480px) !important;
            height: auto !important;
        }
        .article-content iframe, .article-content video {
            display: block;
            width: min(100%, 560px) !important;
            max-width: 100%;
            aspect-ratio: 16 / 9;
            height: auto !important;
            border: 0;
            margin: 1rem 0;
        }
        .article-content { overflow-x: auto; }
    </style>
@endsection
