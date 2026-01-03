<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Agriculture Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

<!-- 🔍 Search Bar (Outside Navbar) -->
<div class="container-fluid bg-light py-2 border-bottom">
    <form class="d-flex justify-content-center" role="search">
        <input
            class="form-control w-25 me-2"
            type="search"
            placeholder="Search"
        />
        <button class="btn btn-success" type="submit">
            Search
        </button>
    </form>
</div>

<!-- 🌿 Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">
            🌾 Agri System
        </a>

        <!-- Toggle -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#agriNavbar"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="agriNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">                
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="<?= base_url('/') ?>"
                        role="button"
                    >
                        Home
                    </a>
                    <ul class="dropdown-menu bg-success">
                        <li><a class="dropdown-item" href="<?= base_url('/overview') ?>">Overview</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/updates') ?>">Updates</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="<?= base_url('fertilizer') ?>"
                        role="button"
                    >
                        Fertilizer
                    </a>
                    <ul class="dropdown-menu bg-success">
                        <li><a class="dropdown-item" href="<?= base_url('/fertilizer/organic') ?>">Organic</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/fertilizer/chemical') ?>">Chemical</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="<?= base_url('seeds') ?>"
                        role="button"
                    >
                        Seeds
                    </a>
                    <ul class="dropdown-menu bg-success">
                        <li><a class="dropdown-item" href="<?= base_url('/myseeds/wheat') ?>">Wheat</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/mysseds/Rice') ?>">Rice</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/mysseds/vegetble') ?>">Vegetable</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="<?= base_url('crops') ?>"
                        role="button"
                    >
                        Crops
                    </a>
                    <ul class="dropdown-menu bg-success">
                        <li><a class="dropdown-item" href="<?= base_url('/crops/foodcrops') ?>">Wheat</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/crops/foragecrops') ?>">Forage Crops</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/crops/Oilseedcrops') ?>">Oilseed Crops</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/crops/Fiber') ?>">Fiber Crops</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/crops/industrialcrops') ?>">Industril Crops</a></li>
                    </ul>                    
                </li>                
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a id="loginLink" class="nav-link fw-semibold text-white" href="<?= base_url('login') ?>">
                        🔐 Login
                    </a>
                </li>            
                <li class="nav-item">
                    <a id="logoutBtn" class="nav-link fw-semibold text-white d-none" href="#">
                        🚪 Logout
                    </a>
                </li>
            </ul>
            <li class="nav-item">
              <a class="nav-link text-white position-relative" href="<?= base_url('cart') ?>">
                    <i class="bi bi-cart-plus fs-5"></i>
                    <!-- <i class="bi bi-cart-plus"></i>         -->
                    <!-- <i class="bi bi-cart"></i>             
                    <i class="bi bi-cart-check"></i>       Added -->


                    <!-- cart count badge (optional) -->
                    <span id="cartCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        0
                    </span>
              </a>
            </li>
        </div>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    /* =========================
       LOGIN / LOGOUT TOGGLE
    ========================= */
    const token = localStorage.getItem('token');

    const loginLink = document.getElementById('loginLink');
    const logoutBtn = document.getElementById('logoutBtn');

    if (loginLink && logoutBtn) {
        if (token) {
            loginLink.classList.add('d-none');
            logoutBtn.classList.remove('d-none');
        } else {
            loginLink.classList.remove('d-none');
            logoutBtn.classList.add('d-none');
        }

        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            localStorage.removeItem('token');
            window.location.href = "<?= base_url('login') ?>";
        });
    }

    /* =========================
       NAVBAR HOVER DROPDOWN
    ========================= */
    if (window.innerWidth > 992) {

        document.querySelectorAll('.navbar .dropdown').forEach(function (dropdown) {

            const toggle = dropdown.querySelector('.dropdown-toggle');
            if (!toggle) return;

            const instance = bootstrap.Dropdown.getOrCreateInstance(toggle);

            dropdown.addEventListener('mouseenter', function () {
                instance.show();
            });

            dropdown.addEventListener('mouseleave', function () {
                instance.hide();
            });
        });
    }

});

function updateCartCount()
{
    const token = localStorage.getItem('token');
    if (!token) return;

    $.ajax({
        url: "<?= base_url('api/cart/count') ?>",
        headers: {
            Authorization: "Bearer " + token
        },
        success: function (res) {
            $('#cartCount').text(res.count);
        }
    });
}

$(function () {
    updateCartCount();
});
</script>

</body>