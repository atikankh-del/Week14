@extends('layouts.app')

@section('title')
    เกี่ยวกับเรา
@endsection

@section('content')
    <h2>เกี่ยวกับเรา</h2>
    <p>ข้อมูลเกี่ยวกับเรา</p>
    <p>ผู้พัฒนาระบบ: {{ $name }}</p>
    <p>วันที่: {{ date('Y-m-d') }}</p>
    <p>จังหวัด: {{ $city }}</p>
@endsection
