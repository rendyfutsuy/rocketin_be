<button type="button" class="btn bg-kolombaris text-white" data-toggle="modal" data-target="#{{ $identification }}"><i class="fas fa-user-edit"></i></button>
<!-- Modal -->
<div class="modal fade" id="{{ $identification }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-kolombaris text-white">
            <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-user-plus"> </i> Edit User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-black">
            <div class="form-group">
                <input
                    id="name"
                    type="name"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name') }}"
                    autocomplete="name"
                    autofocus
                    placeholder="Name"
                >
            </div>

            <div class="form-group">    
                <input
                    id="username"
                    type="username"
                    class="form-control @error('username') is-invalid @enderror"
                    name="username" value="{{ old('username') }}"
                    autocomplete="username"
                    autofocus
                    placeholder="Nick Name"
                >
            </div>

            <div class="form-group">  
                <input
                    id="email"
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}"
                    autocomplete="email"
                    autofocus
                    placeholder="Email"
                >
            </div>

            <div class="form-group">  
                <input
                    id="password"
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password" value="{{ old('password') }}"
                    autocomplete="password"
                    autofocus
                    placeholder="Password"
                >
            </div>

            <div class="form-group">  
                <input
                    id="password-confirmation"
                    type="password-confirmation"
                    class="form-control @error('password-confirmation') is-invalid @enderror"
                    name="password-confirmation" value="{{ old('password-confirmation') }}"
                    autocomplete="password-confirmation"
                    autofocus
                    placeholder="Re-enter Password"
                >
            </div>

            <div class="form-group">  
                <div class="form-control @error('codes[]') is-invalid @enderror">
                    <input type="radio"> <span> {{ __('Banned') }} </span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary bg-kolombaris text-white">Save</button>
        </div>
        </div>
    </div>
</div>

@section("script")
@parent
@endsection
