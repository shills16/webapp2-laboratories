<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Page</title>
    <style>
        @import url("https://fonts.google.com/specimen/Poppins?query=poppins");
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: url("1.jpg") no-repeat center / cover;
        }

        .posts-container {
            width: 50vw;
            margin: 50px auto;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(20px);
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            color: white;
            border-radius: 10px;
            padding: 30px 40px;
        }

        .posts-container h1 {
            font-size: 36px;
            text-align: center;
            color: white;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 20px 40px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 20px;
            background-color: #eceaec;
            cursor: pointer;
            font-size: 30px;
            color: black;
            transition: .9s;
            word-spacing: 10px;
        }

        li:hover {
            transform: scale(1.2);
            background-color: #ddd;
        }

        a {
            text-decoration: none;
            color: black;
        }
    </style>
</head>
<body>
    <div class="posts-container">
        <h1>Posts Page</h1>
        <ul id="postLists">
            <?php

            require "config.php";

            // echo '<pre>';
            // print_r($_SESSION);

            if (!isset($_SESSION['user_id'])) {
                header("Location: login.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    // echo "Connected successfully!";
                    $user_id = $_SESSION['user_id'];

                    $sql = "SELECT * FROM `posts` WHERE user_Id = :id";
                    $statement = $pdo->prepare($sql);
                    $statement->execute([':id' => $_SESSION['user_id']]);

                    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach($posts as $post) {
                        echo '<li><a href="post.php?id=' . $post['id'] . '">' . $post['title'] . '</li>';
                    };

                }
                
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            ?>
        </ul>
    </div>
</body>
</html>