@extends('layouts.app')

@section('title')
    Book Management
@endsection

@section('content')
    <div class="header">
        <h2>📚 Book Management System</h2>
        <p class="mb-0">ระบบจัดการข้อมูลหนังสือ</p>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">➕ เพิ่มข้อมูลหนังสือ</h4>
                    <form method="POST" action="/books">
                        @csrf
                        <div class="mb-3">
                            <label>ชื่อหนังสือ</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="mb-3">
                            <label>ผู้แต่ง</label>
                            <input type="text" class="form-control" name="author">
                        </div>
                        <div class="mb-3">
                            <label>หมวดหมู่</label>
                            <input type="text" class="form-control" name="category">
                        </div>
                        <div class="mb-3">
                            <label>ราคา</label>
                            <input type="number" class="form-control" name="price">
                        </div>
                        <button class="btn btn-primary w-100">💾 บันทึกข้อมูล</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3">📖 รายชื่อหนังสือ</h4>
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ชื่อหนังสือ</th>
                                <th>ผู้แต่ง</th>
                                <th>หมวดหมู่</th>
                                <th>ราคา</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $book['title'] }}</td>
                                    <td>{{ $book['author'] }}</td>
                                    <td>{{ $book['category'] }}</td>
                                    <td>{{ $book['price'] }} บาท</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm">แก้ไข</button>
                                        <button class="btn btn-danger btn-sm">ลบ</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
