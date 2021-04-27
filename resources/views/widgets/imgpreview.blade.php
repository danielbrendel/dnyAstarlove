{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

<div class="imgpreview" id="imgpreview">
    <div class="imgpreview-header">
        <div class="imgpreview-name" id="imgpreview-name"></div>

        <div class="imgpreview-action">
            <i class="fas fa-times fa-2x is-pointer" onclick="document.getElementById('imgpreview').style.display = 'none';"></i>
        </div>
    </div>

    <div class="imgpreview-body">
        <img src="{{ asset('gfx/avatars/default.png') }}" id="imgpreview-image">
    </div>
</div>