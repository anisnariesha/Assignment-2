<?php
    session_start();
    require_once "database.php";

    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST["username"]); // Trim to remove any leading/trailing spaces
        $password = $_POST["password"];

        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            // Verify the entered password with the hashed password from the database
            if (password_verify($password, $row["password"])) {
                $_SESSION["username"] = $username;
                $_SESSION["name"] = $row["name"];
                header("Location: dashboard.php");
                exit();
            } else {
                $errors[] = "Incorrect password!";
            }
        } else {
            $errors[] = "Username not found!";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <link rel='stylesheet' href='style.css'>
    <style>
        .alert-danger {
            color: red;
        }

        .alert-success {
            color: green;
        }

        /* Add this style for responsiveness */
        @media only screen and (max-width: 768px) {
            .credentials div {
                width: 100%;
            }
        }

        @media only screen and (max-width: 480px) {
            .credentials input {
                padding: 12px 10px 12px 35px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Login Form -->
    <div class="w3-container w3-padding">
        <div class="main">
            <h3 class="w3-center w3-padding"><span class="w3-tag w3-wide" style="background-color: slategrey; color: white;">Login</span></h3>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="credentials">
                    <div class="username">
                        <span class='bx bxs-user'></span>
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="password">
                        <span class='bx bxs-lock-alt'></span>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                </div>
                <button class="submit" type="submit">Submit</button>
            </form>
            <div class="link">
                <a href="register.php">Don't have an account? Register</a>
            </div>
        </div>
    </div>
</body>
</html>