<div class="card">
    <div class="card-header text-white bg-kolombaris border-white"> <i class="fa fa-archive"></i> {{ __('This Year Posts') }}</div>
    <div class="card-body">
        <post-chart
            url="{{ route('api.admin.all.post.year') }}"
        >
        </post-chart>
    </div>
</div>

@section("script")
@parent
@endsection