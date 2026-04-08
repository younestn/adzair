@extends('layouts.app')

@section('content')
<div class="container">
    <h1>تعليمات التحقق</h1>
    <p>أضف الكود التالي في وصف الصفحة أو الـ Bio:</p>
    <pre>{{ $page->verification_code }}</pre>

    <a class="btn btn-primary" href="{{ route('publisher.social-pages.manual-info.edit', $page) }}">إكمال المعلومات اليدوية</a>
</div>
@endsection
