<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h3>✏️ Edit Fertilizer</h3>

<form id="editForm"
      method="post"
      action="<?= base_url('api/fertilizer/update/'.$fertilizer['id']) ?>"
      enctype="multipart/form-data">

    <div class="mb-3">
        <label>Name</label>
        <input type="text"
               name="name"
               value="<?= esc($fertilizer['name']) ?>"
               class="form-control"
               required>
    </div>

    <div class="mb-3">
        <label>Type</label>
        <select name="fertilizer_type" class="form-control">
            <option value="Organic" <?= $fertilizer['fertilizer_type'] == 'Organic' ? 'selected' : '' ?>>
                Organic
            </option>
            <option value="Chemical" <?= $fertilizer['fertilizer_type'] == 'Chemical' ? 'selected' : '' ?>>
                Chemical
            </option>
        </select>
    </div>

    <div class="mb-3">
        <label>Price</label>
        <input type="number"
               name="price"
               value="<?= esc($fertilizer['price']) ?>"
               class="form-control"
               required>
    </div>

    <!-- 🔹 OLD IMAGE -->
    <div class="mb-3">
        <label>Current Image</label><br>
        <img src="<?= base_url('uploads/fertilizer/'.$fertilizer['image']) ?>"
             width="100">
        <input type="hidden"
               name="old_image"
               value="<?= esc($fertilizer['image']) ?>">
    </div>

    <!-- 🔹 NEW IMAGE -->
    <div class="mb-3">
        <label>New Image</label>
        <input type="file"
               name="image"
               class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="<?= base_url('fertilizer') ?>" class="btn btn-secondary">Back</a>

</form>

<!-- ✅ jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$('#editForm').on('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "<?= base_url('api/fertilizer/update/'.$fertilizer['id']) ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
         headers: {
        "Authorization": "Bearer " + localStorage.getItem("token")
    },
        success: function(res){
            if(res.status){
                window.location.href = res.redirect;
            }
        }
    });
});
</script>

<?= $this->endSection() ?>
