<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a href="/<?php echo home; ?>"><img src="/<?php echo STATIC_URL ?>/view/assets/img/logo1copy.png" class="img-fluid" width="280px" height="45px" alt="" srcset=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-danger" type="submit">Search</button>
            </form>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/<?php echo home; ?>/user-dashboard">My Account</a>
                    </li>
                <?php
                if (authenticate() == true) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/<?php echo home; ?>/logout">Logout</a>
                    </li>

                <?php
                } else {
                ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/<?php echo home; ?>/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/<?php echo home; ?>/register">Signup</a>
                    </li>
                <?php
                }
                ?>
                
                
                <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/<?php echo home; ?>/cart"><i class="bi bi-cart-fill"><sup><?php echo $GLOBALS['cart_cnt']; ?></sup></i></a>
                    </li>
            </ul>

        </div>
    </div>
</nav>