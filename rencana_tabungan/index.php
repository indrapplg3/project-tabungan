<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/rencana_tabungan/assets/style.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">

        <h2>Login</h2>

        <?php if (isset($_GET['error'])) { ?>
            <div class="notif error">
                Email atau password salah!
            </div>
        <?php } ?>

        <form method="POST" action="auth/login.php">


            <input type="email" name="email" placeholder="Email" required>

            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Login</button>
        </form>

        <p style="margin-top:10px;">
            Belum punya akun? 
            <a href="auth/register.php">Daftar</a>
        </p>

    </div>
</div>

</body>
</html>