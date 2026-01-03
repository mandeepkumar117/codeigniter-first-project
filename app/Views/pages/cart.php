<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h3>My Cart</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="cartData"></tbody>
</table>

<h4 class="text-end">
    Total ₹ <span id="grandTotal">0</span>
</h4>

<!-- ✅ jQuery REQUIRED -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(function () {

    const token = localStorage.getItem('token');
    if (!token) {
        window.location.href = "<?= base_url('login') ?>";
        return;
    }

    $.ajax({
        url: "<?= base_url('api/cart/list') ?>",
        headers: {
            Authorization: "Bearer " + token
        },
        success: function (res) {

            let html = '';
            let total = 0;
            const imgPath = "<?= base_url('uploads/fertilizer/') ?>";

            res.data.forEach(row => {

                let rowTotal = row.price * row.qty;
                total += rowTotal;

                html += `
                    <tr>
                        <td>
                            <img src="${imgPath}${row.image}" width="60">
                        </td>
                        <td>${row.name}</td>
                        <td>₹${row.price}</td>
                        <td>${row.qty}</td>
                        <td>₹${rowTotal}</td>
                        <td>
                            <button class="btn btn-danger btn-sm"
                                onclick="removeItem(${row.id})">
                                X
                            </button>
                        </td>
                    </tr>
                `;
            });

            $('#cartData').html(html);
            $('#grandTotal').text(total);
        }
    });
});

/* =========================
   REMOVE ITEM
========================= */
function removeItem(id)
{
    const token = localStorage.getItem('token');

    $.ajax({
        url: "<?= base_url('api/cart/remove') ?>/" + id,
        type: "DELETE",
        headers: {
            Authorization: "Bearer " + token
        },
        success: function () {
            location.reload();
        }
    });
}
</script>

<?= $this->endSection() ?>
