<div class="wrapper">
    <!-- Sidebar -->
    <button class="position-fixed d-block btn text-white bg-kolombaris sidebarCollapse rounded-0"
        style="z-index: 999;"
        type="button"
    >
        <i class="fas fa-align-justify"></i>
    </button>
    
    <nav id="sidebar" class="bg-light border-right h-100">
        <div class="mr-0 h-100 p-0" style="z-index: 99; border-color: #ffa800;">
            <div class="list-group list-group-flush">
                <a class="navbar-brand p-2" href="{{ route('contributor.home') }}">
                    <img src="https://kolombaris.com/wp-content/uploads/2020/10/kolombaris-logo-2-horizontal.png" height="35px">
                </a> 

                <button class="btn text-white bg-kolombaris m-1 pull-right sidebarCollapse"
                    style="z-index: 999;"
                    type="button"
                >
                    <i class="fas fa-align-justify"></i>
                </button>

                <a href="{{ route('super.admin.home') }}" class="list-group-item list-group-item-action {{ url()->current() == route('super.admin.home') ? 'active bg-kolombaris border-white' :  'bg-light'}}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ route('super.admin.list.user') }}" class="list-group-item list-group-item-action {{ url()->current() == route('super.admin.list.user') ? 'active bg-kolombaris border-white' :  'bg-light'}}"><i class="fas fa-address-book"></i> User List</a>
                <a href="{{ route('super.admin.list.activity') }}" class="list-group-item list-group-item-action {{ url()->current() == route('super.admin.list.activity') ? 'active bg-kolombaris border-white' :  'bg-light'}}"><i class="fas fa-chart-line"></i> Activity List</a>
                {{-- <a href="{{ route('super.admin.list.media') }}" class="list-group-item list-group-item-action {{ url()->current() == route('super.admin.list.media') ? 'active bg-kolombaris border-white' :  'bg-light'}}"><i class="fas fa-images"></i> Media List</a>                                 --}}
                <a href="{{ route('super.admin.list.post') }}" class="list-group-item list-group-item-action {{ url()->current() == route('super.admin.list.post') || url()->current() == route('super.admin.create.post') ? 'active bg-kolombaris border-white' :  'bg-light'}}"><i class="fas fa-list"></i> Post List</a>                
                <a href="{{ route('super.admin.list.post.wait') }}" class="list-group-item list-group-item-action {{ url()->current() == route('super.admin.list.post.wait') ? 'active bg-kolombaris border-white' :  'bg-light'}}"><i class="fas fa-paste"></i> Post Wait List</a>                
                <a href="{{ route('super.admin.list.post.rejected') }}" class="list-group-item list-group-item-action {{ url()->current() == route('super.admin.list.post.rejected') ? 'active bg-kolombaris border-white' :  'bg-light'}}"><i class="fas fa-trash"></i> Post Rejected List</a>                
                <a href="{{ route('super.admin.list.category') }}" class="list-group-item list-group-item-action {{ url()->current() == route('super.admin.list.category') ? 'active bg-kolombaris border-white' :  'bg-light'}}"><i class="fas fa-list-alt"></i> Category List</a>
                <a href="{{ route('super.admin.list.tag') }}" class="list-group-item list-group-item-action {{ url()->current() == route('super.admin.list.tag') ? 'active bg-kolombaris border-white' :  'bg-light'}}"><i class="fas fa-tags"></i> Tag List</a>                                
            </div>
        </div>
    </nav>
</div>

@section("script")
@parent
<script type="text/javascript">
    $(document).ready(function () {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('.sidebarCollapse').on('click', function () {
            $('#sidebar, #content').toggleClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>
@endsection