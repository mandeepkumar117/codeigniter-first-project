<!doctype html>
<html lang="en">
<head>
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
$('#loginForm').on('submit', function(e){
    e.preventDefault();

    $('#errorBox').addClass('d-none').html('');

    $.ajax({
        url: "<?= base_url('api/login') ?>",
        type: "POST",
        dataType: "json",
        data: $(this).serialize(),

        success: function(res){
            if(res.status){
                localStorage.setItem('token', res.token);
                window.location.href = "<?= base_url('fertilizer') ?>";
            } else {
                $('#errorBox')
                    .removeClass('d-none')
                    .html(res.message);
            }
        },

        error: function(xhr){
            let res = xhr.responseJSON;
            let msg = typeof res.message === 'object'
                ? Object.values(res.message).join('<br>')
                : res.message;

            $('#errorBox').removeClass('d-none').html(msg);
        }
    });
});
</script>

</body>
</html>
