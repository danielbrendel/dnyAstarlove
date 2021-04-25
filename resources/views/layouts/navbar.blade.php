<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="https://bulma.io">
        <strong>{{ env('APP_NAME') }}</strong>
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start"></div>

    <div class="navbar-end">
        @auth
        <a class="navbar-item">
            Home
        </a>

        <a class="navbar-item">
            Documentation
        </a>
        @endauth

        <div class="navbar-item">
            <div class="buttons">
                <a class="button is-light is-outlined is-hover-black">
                    <strong>Sign up</strong>
                </a>
            </div>
        </div>

        <a class="navbar-item is-underline">
            Log in
        </a>
    </div>
  </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {

    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Check if there are any navbar burgers
    if ($navbarBurgers.length > 0) {

    // Add a click event on each of them
    $navbarBurgers.forEach( el => {
        el.addEventListener('click', () => {

            // Get the target from the "data-target" attribute
            const target = el.dataset.target;
            const $target = document.getElementById(target);

            // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
            el.classList.toggle('is-active');
            $target.classList.toggle('is-active');

        });
    });
    }

    });
</script>