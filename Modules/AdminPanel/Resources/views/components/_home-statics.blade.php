<div class="col-md">
    <div class="card">
        <div class="card-header text-white bg-kolombaris border-white"> <i class="fa fa-users"></i> {{ __('All User') }}</div>
        <div class="card-body">
            <span><i class="fas fa-user-tie"></i> {{ __('Admin User') }}</span> <strong id="user_admin"></strong> <br>
            <span><i class="fa fa-user-times"></i> {{ __('Banned User') }}</span> <strong id="user_banned"></strong> <br>
            <span><i class="fa fa-user-plus"></i> {{ __('Registered User') }}</span> <strong id="user_registered"></strong> <br>
            <span><i class="fas fa-users"></i> {{ __('All User') }}</span> <strong id="user_total"></strong> <br>
        </div>
    </div>
</div>

<div class="col-md">
    <div class="card">
        <div class="card-header text-white bg-kolombaris border-white"> <i class="fa fa-chart-line"></i> {{ __('User\'s Activities') }} <span id="activities_total"></span></div>
        <div class="card-body">
            <span><i class="fas fa-calendar-day"></i> {{ __('Per-Today') }}</span> <strong id="activities_today"></strong> <br>
            <span><i class="fa fa-calendar-week"></i> {{ __('Per-Week') }}</span> <strong id="activities_week"></strong> <br>
            <span><i class="fa fa-calendar-alt"></i> {{ __('Per-Month') }}</span> <strong id="activities_month"></strong> <br>
            <span><i class="fa fa-calendar"></i> {{ __('Per-Year') }}</span> <strong id="activities_year"></strong> <br>
        </div>
    </div>
</div>

<div class="col-md">
    <div class="card">
        <div class="card-header text-white bg-kolombaris border-white"> <i class="fa fa-file"></i> {{ __('All Post') }} <span id="post_total"></span></div>
        <div class="card-body">
            <span><i class="fas fa-calendar-day"></i> {{ __('Per-Today') }}</span> <strong id="post_today"></strong> <br>
            <span><i class="fa fa-calendar-week"></i> {{ __('Per-Week') }}</span> <strong id="post_week"></strong> <br>
            <span><i class="fa fa-calendar-alt"></i> {{ __('Per-Month') }}</span> <strong id="post_month"></strong> <br>
            <span><i class="fa fa-calendar"></i> {{ __('Per-Year') }}</span> <strong id="post_year"></strong> <br>
        </div>
    </div>
</div>

@section("script")
@parent
<script>
    $( document ).ready(function() {
        axios.get("{{ route('api.admin.site.static') }}", 
                {
                    headers: {
                        Accept: "application/json",
                        Authorization: "Bearer " + sessionStorage.getItem("adminToken")
                    }
                }
            ).then(response => {
                $static = response.data;
                $("#user_total").html($static.all_users);
                $("#user_admin").html($static.admin_users);
                $("#user_registered").html($static.registered_users)
                $("#user_guest").html($static.guest_users)

                $("#activities_today").html($static.users_activities_today);
                $("#activities_week").html($static.users_activities_week);
                $("#activities_month").html($static.users_activities_month)
                $("#activities_year").html($static.users_activities_year)

                $("#post_today").html($static.post_today);
                $("#post_week").html($static.post_week);
                $("#post_month").html($static.post_month)
                $("#post_year").html($static.post_year)
            }).catch(function (error) {
                alert("Gagal Ambil Static");
                console.log(error);
            });
    });
</script>
@endsection