@extends('layouts.app')

@section('title', 'เขียนบทความ')

@section('content')

    <h2>เขียนบทความใหม่</h2>

    <form action="/author/insert" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">ชื่อบทความ</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="ชื่อบทความ"
                value="{{ old('title') }}" required>
        </div>

        @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="content" class="form-label">เนื้อหา</label>
            <textarea id="content" name="content" class="form-control" placeholder="เนื้อหาบทความ" rows="3" required>{{ old('content') }}</textarea>
        </div>

        @error('content')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button type="submit" name="status" value="active" class="btn btn-success">เผยแพร่</button>
        <button type="submit" name="status" value="inactive" class="btn btn-warning">บันทึกฉบับร่าง</button>
        <a class="btn btn-danger" href="/author/blog">บทความทั้งหมด</a>

    </form>

@endsection
