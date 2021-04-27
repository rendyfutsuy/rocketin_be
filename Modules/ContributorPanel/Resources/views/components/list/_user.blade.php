<full-user-list-page
    url="{{ route('api.admin.all.user') }}"
    :page="{{ request('page') ?? 1 }}"
></full-user-list-page>