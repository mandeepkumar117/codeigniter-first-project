<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Signup</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h3 class="mb-3">Signup</h3>

            <div id="errorBox" class="alert alert-danger d-none"></div>

            <form id="signupForm">

                <div class="mb-3">
                    <label>First Name</label>
                    <input type="text" name="firstname" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Last Name</label>
                    <input type="text" name="lastname" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirm" class="form-control">
                </div>

                <button class="btn btn-primary w-100">Register</button>
            </form>

            <div class="mt-3 text-center">
                <a href="<?= base_url('/') ?>">Signin</a>
            </div>

        </div>
    </div>
</div>

<script>
$('#signupForm').on('submit', function(e){
    e.preventDefault();

    $.ajax({
    url: "<?= base_url('api/signup') ?>",
    type: "POST",
    dataType: "json",
    data: $(this).serialize(),
    success: function(res){
        if(res.status){
            alert('Signup successful');
            window.location.href = "<?= base_url('/') ?>";
        } else {
            $('#errorBox')
                .removeClass('d-none')
                .html(Object.values(res.message).join('<br>'));
        }
    },
    error: function(xhr){
        let res = xhr.responseJSON;
        $('#errorBox')
            .removeClass('d-none')
            .html(Object.values(res.message).join('<br>'));
    }
});

});
</script>

</body>
</html>
