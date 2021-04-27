<div class="card">
    <div class="card-header text-white bg-kolombaris border-white"> <i class="fa fa-users-cog"></i> {{ __('List User') }}</div>
    <div class="card-body">
        <full-progress-list-page
            url="{{ route('api.admin.verse.log.list') }}"
        ></full-progress-list-page>
    </div>
</div>