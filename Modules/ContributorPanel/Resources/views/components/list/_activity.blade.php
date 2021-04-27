<div class="card">
    <div class="card-header text-white bg-kolombaris border-white"> <i class="fa fa-users-cog"></i> {{ __('List User') }}</div>
    <div class="card-body">
        <full-activity-list-page
            url="{{ route('api.admin.user.activity.list')}}"
        ></full-activity-list-page>
    </div>
</div>