@extends('layouts.app')

@section('title', $blog->title)

@section('content')
    <article>
        <h1>{{ $blog->title }}</h1>
        <hr>
        <div style="white-space: pre-wrap; overflow-wrap: anywhere;">{{ $blog->content }}</div>
    </article>
    <a href="{{ route('welcome') }}" class="btn btn-outline-secondary mt-4">กลับหน้าแรก</a>
@endsection
