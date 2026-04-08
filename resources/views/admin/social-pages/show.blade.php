@extends('layouts.app')

@section('content')
<div class="container">
    <h1>تفاصيل الصفحة #{{ $page->id }}</h1>

    <ul>
        <li>المنصة: {{ $page->platform }}</li>
        <li>الرابط: <a href="{{ $page->page_url }}" target="_blank">{{ $page->page_url }}</a></li>
        <li>الاسم: {{ $page->page_name }}</li>
        <li>المتابعين: {{ $page->followers_count }}</li>
        <li>الفئة: {{ $page->page_category }}</li>
        <li>الهاتف: {{ $page->phone_number }}</li>
        <li>مكان النشاط: {{ $page->activity_location }}</li>
        <li>الحالة: {{ $page->status }}</li>
    </ul>

    <form method="POST" action="{{ route('admin.social-pages.reject', $page) }}">
        @csrf
        <div class="mb-3">
            <label>سبب الرفض</label>
            <textarea name="rejection_reason" class="form-control"></textarea>
        </div>
        <button class="btn btn-danger">رفض الصفحة</button>
    </form>
</div>
@endsection
