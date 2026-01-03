<!doctype html>
<html lang="en">
<head>
    <style>
        /* 🔥 Fire Glow Error Effect */
.fire-error {
    position: relative;
    animation: shake 0.4s ease-in-out,
               fireGlow 1.2s infinite alternate;
    border: 2px solid red;
}

/* 🔥 Glow animation */
@keyframes fireGlow {
    from {
        box-shadow:
            0 0 10px red,
            0 0 25px orange,
            0 0 50px darkred;
    }
    to {
        box-shadow:
            0 0 25px red,
            0 0 60px orange,
            0 0 100px darkred;
    }
}

/* ❗ Shake animation */
@keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-6px); }
    50% { transform: translateX(6px); }
    75% { transform: translateX(-6px); }
    100% { transform: translateX(0); }
}

    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h3 class="mb-4 text-center">Login</h3>

            <!-- Error Box -->
            <div id="errorBox" class="alert alert-danger d-none"></div>

            <form id="loginForm">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3 text-end">
                    <a href="<?= base_url('signup') ?>">Create account</a>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Login
                </button>
            </form>

        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    $('#loginForm').on('submit', function (e) {
        e.preventDefault();

        // Reset error box
        $('#errorBox').addClass('d-none').html('');

        // Remove old animation if any
        $('#loginForm').removeClass('fire-error');

        $.ajax({
            url: "<?= base_url('api/login') ?>",
            type: "POST",
            dataType: "json",
            data: $(this).serialize(),

            success: function (res) {

                if (res.status === true) {
                    // ✅ LOGIN SUCCESS
                    localStorage.setItem('token', res.token);
                    window.location.href = "<?= base_url('fertilizer') ?>";

                } else {
                    // ❌ WRONG USERNAME / PASSWORD
                    showFireError(res.message);
                }
            },

            error: function (xhr) {
                let res = xhr.responseJSON || {};
                let msg = '';

                if (typeof res.message === 'object') {
                    msg = Object.values(res.message).join('<br>');
                } else {
                    msg = res.message || 'Something went wrong';
                }

                showFireError(msg);
            }
        });
    });

    // 🔥 FIRE ERROR FUNCTION
    function showFireError(message) {

        $('#errorBox')
            .removeClass('d-none')
            .html(message);

        $('#loginForm').addClass('fire-error');

        // Remove animation after 2 seconds
        setTimeout(function () {
            $('#loginForm').removeClass('fire-error');
        }, 10000);
    }

});
</script>


</body>
</html>
