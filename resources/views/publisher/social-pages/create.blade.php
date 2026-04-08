@extends('layouts.app')

@section('content')
<div class="container">
    <h1>إضافة صفحة سوشيال</h1>

    <form method="POST" action="{{ route('publisher.social-pages.store') }}">
        @csrf
        <div class="mb-3">
            <label>المنصة</label>
            <select name="platform" class="form-control" required>
                <option value="facebook">Facebook</option>
                <option value="instagram">Instagram</option>
                <option value="tiktok">TikTok</option>
                <option value="youtube">YouTube</option>
                <option value="twitter">Twitter</option>
                <option value="snapchat">Snapchat</option>
            </select>
        </div>
        <div class="mb-3">
            <label>رابط الصفحة</label>
            <input type="url" name="page_url" class="form-control" required>
        </div>
        <button class="btn btn-success">حفظ</button>
    </form>
</div>
@endsection
