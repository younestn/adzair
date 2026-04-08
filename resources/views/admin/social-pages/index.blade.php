@extends('layouts.app')

@section('content')
<div class="container">
    <h1>الصفحات الاجتماعية المعلقة</h1>

    <table class="table">
        <thead><tr><th>#</th><th>المنصة</th><th>الاسم</th><th>الحالة</th><th>إجراءات</th></tr></thead>
        <tbody>
        @forelse($pages as $page)
            <tr>
                <td>{{ $page->id }}</td>
                <td>{{ $page->platform }}</td>
                <td>{{ $page->page_name }}</td>
                <td>{{ $page->status }}</td>
                <td>
                    <a href="{{ route('admin.social-pages.show', $page) }}" class="btn btn-sm btn-info">عرض</a>
                    <form method="POST" action="{{ route('admin.social-pages.verify', $page) }}" style="display:inline">@csrf <button class="btn btn-sm btn-success">تحقق</button></form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">لا يوجد بيانات.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $pages->links() }}
</div>
@endsection
