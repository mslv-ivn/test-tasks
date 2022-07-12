<?php
session_start();
if (!isset($_SESSION["LOGIN"])) { ?>
    <form action="7_1.php" method="post">
        <label>Авторизация</label>
        <input type="text" name="login" value="login">
        <input type="password" name="password" value="password">
        <button type="submit">Отправить</button>
    </form>
<?php } else {
    echo "Привет, LOGIN";
} ?>

<script>
    document.addEventListener("submit", (e) => {
        e.preventDefault();
        const form = e.target;

        fetch(form.action, {
            method: form.method,
            body: new FormData(form),
        })
        document.location.reload();
    });
</script>