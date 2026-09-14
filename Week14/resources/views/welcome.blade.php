@extends('layouts.app')

@section('title', 'หน้าแรกของเว็บไซต์')

@section('content')
    <h2>บทความล่าสุด</h2>
    <hr>
    <div class="row g-4">
        @forelse ($blogs as $item)
            <div class="col-12 col-md-6 col-lg-4">
                <article class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h2 class="h5">{{ $item->title }}</h2>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}</p>
                        <a href="{{ route('blogs.detail', $item->id) }}" class="btn btn-outline-primary mt-auto align-self-start">อ่านเพิ่มเติม</a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">ยังไม่มีบทความที่เผยแพร่</p>
            </div>
        @endforelse
    </div>
@endsection
