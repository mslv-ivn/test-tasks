<form action="6_1.php" method="post">
    <label>Поиск</label>
    <input type="text" name="text">
    <button type="submit">Отправить</button>
    <div id="form_response"></div>
</form>

<script>
    document.addEventListener("submit", (e) => {
        e.preventDefault();
        const form = e.target;

        fetch(form.action, {
            method: form.method,
            body: new FormData(form),
        })
            .then((res) => res.text())
            .then((text) => new DOMParser().parseFromString(text, "text/html"))
            .then((doc) => {
                const result = document.getElementById("form_response");
                result.innerHTML = doc.body.innerHTML;
            })
    });
</script>