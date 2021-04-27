<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#{{ $identification }}"><i class="fas fa-times"></i></button>
<!-- Modal -->
<div class="modal fade" id="{{ $identification }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog p-5" role="document">
        <div class="modal-content">
        <div class="modal-header bg-kolombaris text-white">
            <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-trash"> </i> Warning</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-black">
            Are you sure want to delete this activity? <br>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary bg-kolombaris text-white">Delete</button>
        </div>
        </div>
    </div>
</div>

@section("script")
@parent
@endsection
