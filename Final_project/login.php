<?php 

require "config.php";

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        // echo "Connected successfully!";
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = strtolower($_POST['username']);
            $password = $_POST['password'];

            $sql = "SELECT * FROM `users` WHERE username = :username";
            $statement = $pdo->prepare($sql);
            $statement->execute(['username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if($password === "secret123") {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['username'] = $user['username'];

                    header('Location: posts.php');
                    exit;
                } else {
                    $_SESSION['error'] = "Invalid password. Please try again.";
                }
            } else{
                $_SESSION['error'] = "User not found. Please try again.";
            }
        }
    }   
    
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login Page</title>
    <style>
        @import url("https://fonts.google.com/specimen/Poppins?query=poppins");
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url("1.jpg") no-repeat center / cover;
            background-position: center;
        }

        .login-page {
            width: 420px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(20px);
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            color: white;
            border-radius: 10px;
            padding: 30px 40px;
            position: relative;
        }

        .error-message {
            color: red;
            position: absolute;
            margin-left: 55px;
            top: 70px;
            padding: 10px;
            font-size: 14px;
        }

        .login-page h1 {
            font-size: 36px;
            text-align: center;
        }

        .login-page .input-box {
            position: relative;
            width: 100%;
            height: 50px;
            margin: 30px 0;
        }

        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            border: 2px solid rgba(255, 255, 255, .2);
            border-radius: 40px;
            font-size: 16px;
            color: white;
            padding: 20px 45px 20px 20px;
        }

        .input-box input::placeholder {
            color: #fff;
        }

        .input-box i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
        }

        .login-page #submit {
            width: 100%;
            height: 45px;
            background-color: #fff;
            border: none;
            outline: none;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            cursor: pointer;
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }

        .login-page #submit:hover {
            background-color: #e4c4e2;
        }
    </style>

</head>
<body>
    <div id="login-form" class="login-page">
        <form method= "POST" action= <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> >
            <h1>Login</h1>

            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>

            <div class="input-box">
                <input type="text" name="username" id="username" class="box" placeholder="Enter username" required="">
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" id="password" class="box" placeholder="Enter pasword" required="">
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button id="submit">Login</button>
        </form>
    </div>
</body>

</html>