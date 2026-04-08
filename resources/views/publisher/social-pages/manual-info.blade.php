@extends('layouts.app')

@section('content')
<div class="container">
    <h1>المعلومات اليدوية للصفحة</h1>

    <form method="POST" action="{{ route('publisher.social-pages.manual-info.update', $page) }}">
        @csrf
        @method('PUT')

        <div class="mb-3"><label>رقم الهاتف</label><input name="phone_number" class="form-control" value="{{ old('phone_number', $page->phone_number) }}"></div>
        <div class="mb-3"><label>مكان النشاط</label><input name="activity_location" class="form-control" value="{{ old('activity_location', $page->activity_location) }}"></div>
        <div class="mb-3"><label>عدد المتابعين</label><input type="number" name="followers_count" class="form-control" value="{{ old('followers_count', $page->followers_count) }}"></div>
        <div class="mb-3"><label>مجالات الصفحة (مفصولة بفاصلة)</label><input name="page_topics[]" class="form-control"></div>
        <div class="mb-3"><label>معدل الوصول %</label><input type="number" step="0.01" name="audience_reach_rate" class="form-control" value="{{ old('audience_reach_rate', $page->audience_reach_rate) }}"></div>

        <button class="btn btn-success">حفظ</button>
    </form>
</div>
@endsection
