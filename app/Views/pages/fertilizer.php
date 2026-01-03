<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h3>Fertilizer List</h3>

<div class="row" id="fertilizerData"></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(function () {

    $.ajax({
        url: "<?= base_url('api/fertilizer/list') ?>",
        type: "GET",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token")
        },
        success: function (res) {

            let html = '';
            const imgPath = "<?= base_url('uploads/fertilizer/') ?>";

            res.data.forEach(row => {
                html += `
                <div class="col-md-4 mb-4">
                    <div class="card shadow h-100">
                        <img src="${imgPath}${row.image}"
                             class="card-img-top"
                             style="height:200px; object-fit:cover;">

                        <div class="card-body">
                            <h5 class="card-title">${row.name}</h5>

                            <p class="card-text mb-1">
                                <strong>Type:</strong> ${row.fertilizer_type}
                            </p>

                            <p class="card-text">
                                <strong>Price:</strong> ₹${row.price}
                            </p>
                        </div>

                        <div class="card-footer bg-white text-end">
                            <button class="btn btn-sm btn-primary"
                                onclick="handleEdit(${row.id})">
                                Edit
                            </button>

                            <button class="btn btn-sm btn-danger ms-1"
                                onclick="deleteFertilizer(${row.id})">
                                Delete
                            </button>
                            <button class="btn btn-sm btn-success me-1"
                                onclick="addToCart(${row.id})">
                                <i class="bi bi-cart-plus"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
                `;
            });

            $('#fertilizerData').html(html);
        }
    });

});

/* =========================
   EDIT FUNCTION
========================= */
function handleEdit(id)
{
    const token = localStorage.getItem('token');

    if (!token) {
        if (confirm('Please login first')) {
            window.location.href = "<?= base_url('login') ?>";
        }
        return;
    }

    window.location.href = "<?= base_url('fertilizer/edit') ?>/" + id;
}

/* =========================
   DELETE FUNCTION
========================= */
function deleteFertilizer(id)
{
    const token = localStorage.getItem('token');

    if (!token) {
        if (confirm('Please login first')) {
            window.location.href = "<?= base_url('login') ?>";
        }
        return;
    }

    if (!confirm('Are you sure you want to delete this item?')) return;

    $.ajax({
        url: "<?= base_url('api/fertilizer/delete') ?>/" + id,
        type: "DELETE",
        headers: {
            "Authorization": "Bearer " + token
        },
        success: function () {
            alert('Deleted successfully');
            location.reload();
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            alert('Delete failed');
        }
    });
}
function addToCart(id)
{
    const token = localStorage.getItem('token');

    // login check
    if (!token) {
        if (confirm('Please login first')) {
            window.location.href = "<?= base_url('login') ?>";
        }
        return;
    }

    $.ajax({
        url: "<?= base_url('api/cart/add') ?>",
        type: "POST",
        headers: {
            "Authorization": "Bearer " + token
        },
        data: {
            fertilizer_id: id,
            quantity: 1
        },
        success: function (res) {
            alert('Item added to cart');
            if (typeof updateCartCount === 'function') {
                updateCartCount(); // navbar cart count
            }
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            console.log(xhr.status);
            alert('Failed to add item to cart');
        }
    });
}
</script>

<?= $this->endSection() ?>
