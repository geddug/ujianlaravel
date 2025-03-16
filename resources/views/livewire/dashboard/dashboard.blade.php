@section('title')
    Dashboard
@endsection
<div>
    @if (Auth::user()->role == 'siswa')
        @include('components.dashboard-siswa')
    @else
        @include('components.dashboard-admin')
    @endif
</div>
