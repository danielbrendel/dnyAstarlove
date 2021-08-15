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

    <div class="imgpreview-body" id="imgpreview-body">
        <div class="imgpreview-switch">
            <div onclick="window.vue.displayNextPhoto('left');"><i class="fas fa-chevron-left fa-5x is-color-white is-pointer"></i></div>
        </div>

        <div>
            <img src="{{ asset('gfx/avatars/default.png') }}" id="imgpreview-image">
        </div>

        <div class="imgpreview-switch">
            <div onclick="window.vue.displayNextPhoto('right');"><i class="fas fa-chevron-right fa-5x is-color-white is-pointer"></i></div>
        </div>
    </div>
</div>