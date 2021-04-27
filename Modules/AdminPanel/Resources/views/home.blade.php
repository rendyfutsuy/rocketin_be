@extends('adminPanel::layouts.app-with-sidebar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @component('adminPanel::components._home-statics')
            
        @endcomponent
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-5 px-0">
            <div class="col-md-12 mb-2">
                @component('adminPanel::components._chart-activities')
                
                @endcomponent
            </div>
        </div>

        <div class="col-md px-0">
            <div class="col-md-12">
                <div class="card pb-2 mb-2">
                    <div class="card-header text-white bg-kolombaris border-white"> <i class="fa fa-users"></i> {{ __('Recent Activities') }}</div>
                    <div class="card-body py-2">
                        <home-user-activity
                            url="{{ route('api.admin.user.activity.list') }}"
                            limit="3"
                        >
                        </home-user-activity>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-12 mb-2">
            @component('adminPanel::components._chart-posts')
            
            @endcomponent
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-12 mb-2">
            @component('adminPanel::components._recent-posts')
            
            @endcomponent
        </div>
    </div>    
</div>
@endsection

@section("script")
@parent

@endsection
