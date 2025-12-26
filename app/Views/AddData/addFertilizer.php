<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Fertilizer</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

<div class="container martop">
    <div class="col-md-8 center_div">

        <!-- Validation Errors -->
        <?php if (isset($validation)) : ?>
            <div class="alert alert-danger">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

        <!-- Success Message -->
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <h3 class="mb-4 text-center text-success">
            <!-- ➕ -->
             Add Fertilizer</h3>

        <form action="<?= base_url('api/fertilizer/add') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <?php if (isset($validation)) : ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <input type="text" name="name" class="form-control" placeholder="Fertilizer Name">

    <input type="text" name="nutrients" class="form-control mt-2" placeholder="Nutrients">

    <input type="text" name="usage_details" class="form-control mt-2" placeholder="Usage">

    <input type="text" name="application_method" class="form-control mt-2" placeholder="Application Method">

    <select name="fertilizer_type" class="form-control mt-2">
        <option value="">Select Type</option>
        <option value="Organic">Organic</option>
        <option value="Chemical">Chemical</option>
    </select>

    <input type="text" name="dosage" class="form-control mt-2" placeholder="Dosage">

    <input type="text" name="suitablecrop" class="form-control mt-2" placeholder="Suitable Crop">

    <input type="text" name="manufacturer" class="form-control mt-2" placeholder="Manufacturer">

    <input type="number" name="price" class="form-control mt-2" placeholder="Price">

    <input type="file" name="image" class="form-control mt-2">

    <button type="submit" class="btn btn-success mt-3">Save Fertilizer</button>
</form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
