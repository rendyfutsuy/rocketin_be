<div style="padding: 5px 15px 55px;max-width: 575px;margin: auto;border: 1px #f0f0f0 solid">
    <h4 style="color: #000;"> <img src="https://kolombaris.com/wp-content/uploads/2020/10/kolombaris-logo-2-horizontal.png" width="150px" height="auto"></h4>

    @yield('content')

    <div>
        {!! __('auth::email.layout.footer_1', [], $lang) !!}
        <div style="padding: 5px 10px 35px; background: #B6C2D8; border-radius: 5px;">
            <p>
                {!! __('auth::email.layout.footer_2', [], $lang) !!}
            </p>
        </div>
    </div>
</div>