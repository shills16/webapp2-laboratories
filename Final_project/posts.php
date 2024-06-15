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
            backdrop-filter: blur(5px);
        }

        .posts-container {
            width: 40vw;
            height: 97vh;
            margin: auto;
            margin-top: 10px;
            border: 2px solid rgba(255, 255, 255, .2);
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            color: white;
            border-radius: 10px;
            padding: 27px 40px;
            position: relative;
        }

        .posts-container h1 {
            font-size: 36px;
            text-align: center;
            color: white;
            margin-bottom: 10px;
        }

        ul {
            list-style-type: none;
            /* padding: 20px; */
        }

        li {
            margin-bottom: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9ff;
            cursor: pointer;
            transition: .5s;
        }

        a {
            text-decoration: none;
            color: black;
        } 

        li:hover {
            transform: scale(1.1);
            background-color: #F5DDE0;
            border: solid 1px #F5DDE0;
        }

        .logout-button {
            background-color: #ff4b5c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            position: absolute;
            right: 20px;
            margin-right: 20px;
        }

        .logout-button:hover {
            background-color: #ff1c3c;
        }

    </style>
</head>
<body>
    <div class="posts-container">
        <h1>Posts Page</h1>
        <ul id="postLists">
            <?php

            require "config.php";

            if (!isset($_SESSION['user_id'])) {
                header("Location: login.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
            
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

        <form action="logout.php" method="post">
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>
</body>
</html>