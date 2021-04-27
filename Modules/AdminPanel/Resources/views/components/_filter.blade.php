<div class="row justify-content-center p-0">
    <div class="col-md">
        <div class="card">
            <div class="card-header text-white bg-kolombaris border-white"> <i class="fas fa-filter"></i> {{ __('Filter') }}</div>
            <div class="card-body">
                <form id={{ $formName }}>
                    {{ $options }}
                    <div class="form-group px-3">
                        <button id="submitForm" type="button" class="btn bg-kolombaris border-white text-white float-right col-md-2"><i class="fas fa-search"></i> Submit</button>
                        <button id="submitForm" type="button" class="btn bg-kolombaris border-white text-white float-right col-md-2"><i class="fas fa-sync"></i> Refresh</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>