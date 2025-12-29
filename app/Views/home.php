<?= view('layout/header') ?>

<div class="container mt-5 text-center">
    <h1>🌾 Agriculture Management System</h1>
    <p class="mt-3">Welcome to Agri System</p>

    <a href="<?= base_url('login') ?>" class="btn btn-success mt-3">
        Login
    </a>
</div>
<h2>🌾 Krishi AI Salah</h2>

<textarea id="question" rows="4" cols="50"
  placeholder="Apna sawal likhiye..."></textarea>
<br><br>

<button onclick="askAI()">Sawal Poochho</button>

<pre id="answer"></pre>

<script>
function askAI() {
    const question = document.getElementById('question').value;
    const ans = document.getElementById('answer');

    if (question.trim() === '') {
        ans.innerText = '❌ Sawal likhiye';
        return;
    }

    ans.innerText = '⏳ AI soch raha hai...';

    const formData = new FormData();
    formData.append('question', question);

    fetch("<?= base_url('api/gemini-test') ?>", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // 🔥 DEBUG

        if (data.answer) {
            ans.innerText = data.answer;
        } else {
            ans.innerText = '❌ Undefined response de raha hai';
        }
    })
    .catch(err => {
        ans.innerText = '❌ Network error';
        console.error(err);
    });
}
</script>







<?= view('layout/footer') ?>
