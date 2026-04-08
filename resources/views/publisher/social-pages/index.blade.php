@extends('layouts.app')

@section('content')
<div class="container">
    <h1>صفحاتي الاجتماعية</h1>
    <a href="{{ route('publisher.social-pages.create') }}" class="btn btn-primary">إضافة صفحة</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>المنصة</th>
                <th>الرابط</th>
                <th>الحالة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pages as $page)
                <tr>
                    <td>{{ $page->platform }}</td>
                    <td><a href="{{ $page->page_url }}" target="_blank">{{ $page->page_url }}</a></td>
                    <td>{{ $page->status }}</td>
                    <td>
                        <a href="{{ route('publisher.social-pages.verify-instructions', $page) }}">تعليمات التحقق</a> |
                        <a href="{{ route('publisher.social-pages.manual-info.edit', $page) }}">المعلومات اليدوية</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">لا توجد صفحات بعد.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $pages->links() }}
</div>
@endsection
