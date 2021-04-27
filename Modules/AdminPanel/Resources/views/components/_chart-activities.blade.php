<div class="card">
    <div class="card-header text-white bg-kolombaris border-white"> <i class="fa fa-chart-line"></i> {{ __('This Year Activities') }}</div>
    <div class="card-body">
        <activity-chart
            url="{{ route('api.admin.user.all.activity.year') }}"
        >
        </activity-chart>
    </div>
</div>

@section("script")
@parent
@endsection