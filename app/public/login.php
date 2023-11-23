<?php
$errors = [];

$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (empty($login)) {
        $errors['login'] = 'Введите корректное имя';
    }

    if (empty($password)) {
        $errors['password'] = 'Введите правильно пароль';
    }
}
if (empty($errors)) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $pdo = new PDO("pgsql:host=db;dbname=postgres", "dbuser", "dbpwd");
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
    $stmt->execute(['email' => $login]);

    $data = $stmt->fetch();
    if (empty($data)) {
        $errors['login'] = 'Логин или пароль введен неверно';
    } else {
        if ($password === $data['password']) {
            echo 'login ok!';
        } else {
            $errors['login'] = 'Логин или пароль введен неверно';
        }
    }
}

?>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<body>
<div class="wrapper">
    <form action="login.php" method="POST">
        <h1>Login</h1>
        <div class="input-box">
            <?php if (isset($errors['login'])): ?>
                <label style="color: red"><?php echo $errors['login']; ?></label>
            <?php endif; ?>
            <input type="text" placeholder="Username" name="login" required>
            <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
            <?php if (isset($errors['password'])): ?>
                <label style="color: red"><?php echo $errors['password']; ?></label>
            <?php endif; ?>
            <input type="password" placeholder="password" name="password" required>
            <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="remember-forgot">
            <label><input type="checkbox">Remember me</label>
            <a href="#">Forgot password?</a>
        </div>
        <button type="submit" class="btn">Login</button>
        <div class="register-link">
            <p>Don't have an account? <a href="#">Register</a></p>
        </div>
    </form>
</div>
</body>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

    *
    {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;

    }
    body{
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background:url(https://img.playbook.com/GkXdxuPUJybZqdTcLNt124xUnMD_bK19dxy4Z8SczhE/Z3M6Ly9wbGF5Ym9v/ay1hc3NldHMtcHVi/bGljLzJhNWYxODk1/LTE0ZWMtNGNjMi1h/ZGZlLTRkMzQxYWYw/Zjk1OQ);
        background-size: cover;
        background-position: center;
    }
    .wrapper {
        width: 420px;
        background: transparent;
        border:2px solid rgba(255, 255, 255, .2);
        backdrop-filter:blur(20px);
        box-shadow: 0 0 10px rgba(0 , 0 , 0 , .2);
        color: #fff;
        border-radius: 10px;
        padding: 30px 40px;

    }
    .wrapper h1{
        font-size: 36px;
        text-align: center;
    }
    .wrapper .input-box {
        position: relative;
        width: 100%;
        height: 50px;
        margin: 30px 0;
    }

    .input-box input{
        width: 100%;
        height: 100%;
        background: transparent;
        border: none;
        outline: none;
        border: 2px solid rgba(255, 255, 255, .2);
        border-radius: 40px;
        font-size: 16px;
        color: #fff;
        padding: 20px 45px 20px 20px;
    }
    .input-box input::placeholder{
        color: #fff;
    }
    .input-box i{
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;

    }
    .wrapper .remember-forgot{
        display: flex;
        justify-content: space-between;
        font-size: 14.5px;
        margin: -15px 0 15px;
    }
    .remember-forgot label input{
        accent-color: #fff;
        margin-right: 3px;
    }
    .remember-forgot a{
        color: #fff;
        text-decoration: none;

    }
    .remember-forgot a:hover{
        text-decoration: underline;
    }
    .wrapper .btn{
        width: 100%;
        height: 45px;
        border-radius: 40px;
        border: none;
        outline: none;
        background: #fff;
        box-shadow: 0 0 10px rgba(0 , 0 , 0 , .1);
        cursor: pointer;
        font-size: 16px;
        color: #333;
        font-weight: 600;
    }
    .wrapper .register-link{
        text-align: center;
        font-size: 14.5px;
        margin:20px 0 15px;
    }
    .register-link p a{
        color: #fff;
        text-decoration: none;
        font-weight: 600;

    }
    .register-link p a:hover{
        text-decoration: underline;
    }
</style>