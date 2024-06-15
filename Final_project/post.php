<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Page</title>
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
            backdrop-filter: blur(5px);
        }

        .post-container {
            max-width: 600px;
            height: 490px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid black;
            margin: 50px auto;
            border: 2px solid rgba(255, 255, 255, .2);
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            color: black;
            border-radius: 10px;
            position: relative;
        }

        .post-container h1 {
            font-size: 36px;
            text-align: center;
            color: #fff; 
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        #postDetails {
            align-content: center;
            justify-content: center;
            padding: 50px;
            font-size: 20px;
            line-height: 30px;
            background-color: #F5DDE0; 
            border-radius: 10px;
            margin-top: 20px;
        }

        .return-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            position: absolute;
            right: 20px;
            margin-top: 15px;
            margin-right: 20px;
        }

        .return-button:hover {
            background-color: #45a049;
        }


    </style>
</head>

<body>
    <div class="post-container">
        <h1>Post Page</h1>
        <div id="postDetails">
            <?php

            require 'config.php';

            if (!isset($_SESSION['user_id'])) {
                header("Location: login.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];

                        $query = "SELECT * FROM `posts` WHERE id = :id";
                        $statement = $pdo->prepare($query);
                        $statement->execute([':id' => $id]);

                        $post = $statement->fetch(PDO::FETCH_ASSOC);

                        if ($post) {
                            echo '<h3>Title: ' . $post['title'] . '</h3>';
                            echo '<br>';
                            echo '<p>Body: ' . $post['body'] . '</p>';
                        } else {
                            echo "No post found with ID $id!";
                        }
                    } else {
                        echo "No post ID provided!";
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>

        </div>
        <form method="post" action="">
            <button type="submit" name="return" class="return-button">Return</button>
        </form>
        <?php
        if (isset($_POST['return'])) {
            header("Location: posts.php");
            exit;
        }
        ?>
    </div>
</body>

</html>