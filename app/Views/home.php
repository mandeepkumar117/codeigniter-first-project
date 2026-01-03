<?= view('layout/header') ?>

<div class="container mt-5 text-center">
    <h1>🌾 Agriculture Management System</h1>
    <p class="mt-3">Welcome to Agri System</p>

    <a href="<?= base_url('login') ?>" class="btn btn-success mt-3">
        Login
    </a>

    <hr class="my-4">

    <h2>🌾 Krishi AI Salah</h2>

    <textarea id="question" rows="4" cols="50"
        class="form-control mt-3"
        placeholder="Apna sawal likhiye..."></textarea>

    <button id="askBtn" onclick="askAI()" class="btn btn-primary mt-3">
        Sawal Poochho
    </button>

    <pre id="answer" class="mt-3 text-start"></pre>
</div>

<script>
function askAI() {
    const question = document.getElementById('question').value;
    const ans = document.getElementById('answer');
    const btn = document.getElementById('askBtn');

    if (question.trim() === '') {
        ans.innerText = '❌ Sawal likhiye';
        return;
    }

    ans.innerText = '⏳ AI soch raha hai...';
    btn.disabled = true;

    const formData = new FormData();
    formData.append('question', question);

    fetch("<?= base_url('api/gemini-test') ?>", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);

        if (data.status === false) {
            ans.innerText = '❌ ' + data.answer;
        } else {
            ans.innerText = data.answer ?? '❌ AI ne jawab nahi diya';
        }
    })
    .catch(err => {
        ans.innerText = '❌ Network error';
        console.error(err);
    })
    .finally(() => {
        btn.disabled = false;
    });
}
</script>

<?= view('layout/footer') ?>
