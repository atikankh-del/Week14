@extends('layouts.app')

@section('title')
    แก้ไขบทความ
@endsection

@section('content')
    <h2>แก้ไขบทความ</h2>

    
    <form action="{{ route('book.update', $blog->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">ชื่อบทความ</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}">

            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">เนื้อหาบทความ</label>
            <textarea name="content" class="form-control" rows="6">{{ old('content', $blog->content) }}</textarea>

            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">สถานะ</label>
            <select name="status" class="form-select">
                <option value="active" {{ old('status', $blog->status) == 'active' ? 'selected' : '' }}>
                    เผยแพร่
                </option>
                <option value="inactive" {{ old('status', $blog->status) == 'inactive' ? 'selected' : '' }}>
                    ไม่เผยแพร่
                </option>
            </select>

            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">บันทึกการแก้ไข</button>
        <a href="/author/blog" class="btn btn-secondary">บทความทั้งหมด</a>
    </form>
@endsection
