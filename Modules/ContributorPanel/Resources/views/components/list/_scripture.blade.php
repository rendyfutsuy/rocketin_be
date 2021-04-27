<div class="card">
    <div class="card-header text-white bg-kolombaris border-white"> <i class="fa fa-book"></i> {{ __('List Scriptures') }}</div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <span class="nav-link active text-kolombaris" id="old-tab" data-toggle="tab" href="#old" role="tab" aria-controls="old" aria-selected="true">Old Testament</span>
            </li>
            <li class="nav-item">
                <span class="nav-link text-kolombaris" id="new-tab" data-toggle="tab" href="#new" role="tab" aria-controls="new" aria-selected="false">New Testament</span>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="old" role="tabpanel" aria-labelledby="old-tab">
                <full-scripture-list
                    url="{{ route('api.admin.list.testament.ajax', 1) }}"
                >
                </full-scripture-list>
            </div>
            <div class="tab-pane fade" id="new" role="tabpanel" aria-labelledby="new-tab">
                <full-scripture-list
                    url="{{ route('api.admin.list.testament.ajax', 2) }}"
                >
                </full-scripture-list>
            </div>
        </div>
    </div>
</div>