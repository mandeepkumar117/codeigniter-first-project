<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h3>Fertilizer List</h3>

<table class="table table-bordered">
    <thead class="table-success">
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Price</th>
            <th>Image</th>
            <th width="180">Action</th>
        </tr>
    </thead>
    <tbody id="fertilizerData"></tbody>
</table>

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
                    <tr>
                        <td>${row.name}</td>
                        <td>${row.fertilizer_type}</td>
                        <td>${row.price}</td>
                        <td>
                            <img src="${imgPath}${row.image}" width="70">
                        </td>
                        <td>
                            <a href="#"
                               class="btn btn-sm btn-primary"
                               onclick="handleEdit(${row.id})">
                               Edit
                            </a>

                            <button class="btn btn-sm btn-danger ms-1"
                                onclick="deleteFertilizer(${row.id})">
                                Delete
                            </button>
                        </td>
                    </tr>
                `;
            });

            $('#fertilizerData').html(html);
        }
    });
});

// 🔹 Edit handler (LOGIN CHECK)
function handleEdit(id)
{
    const token = localStorage.getItem('token');

    if (!token) {

        const goLogin = confirm('Please login first');

        if (goLogin) {
            window.location.href = "<?= base_url('login') ?>";
        }

        return;
    }

    window.location.href = "<?= base_url('fertilizer/edit') ?>/" + id;
}


// 🔹 Delete
function deleteFertilizer(id)
{
    const token = localStorage.getItem('token');

    // 🔐 Login check
    if (!token) {
        const goLogin = confirm('Please login first');

        if (goLogin) {
            window.location.href = "<?= base_url('login') ?>";
        }
        return;
    }

    // ❗ Delete confirmation
    if (!confirm('Are you sure you want to delete this item?')) return;

    $.ajax({
        url: "<?= base_url('api/fertilizer/delete') ?>/" + id,
        type: "DELETE",
        headers: {
            "Authorization": "Bearer " + token
        },
        success: function () {
            location.reload();
        },
        error: function () {
            alert('Delete failed');
        }
    });
}

</script>

<?= $this->endSection() ?>
