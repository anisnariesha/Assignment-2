<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
    <div class="w3-container w3-padding">
        <div class="main">
        <?php
            if (isset($_POST["submit"])) {
                $fullName = $_POST["name"];
                $userName = $_POST["username"];
                $password = $_POST["password"];
                $email = $_POST["email"];
                $confirm_password = $_POST["confirm_password"];
                $phoneNumber = $_POST["phone_number"];
                $address = $_POST["address"];
                            
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $errors = array();

                if (empty($fullName) || empty($userName) || empty($password) || empty($email) || empty($confirm_password) || empty($phoneNumber) || empty($address)) {
                    array_push($errors, "All fields are required!");
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email is not valid!");
                }
                if (strlen($password) < 6) {
                    array_push($errors, "Password must be at least 6 characters long!");
                }
                if ($password !== $confirm_password) {
                    array_push($errors, "Passwords do not match!");
                }
                if (strlen($phoneNumber) > 11) {
                    array_push($errors, "Phone number must be 10/11 digits!");
                }

                if (count($errors) > 0) {
                    foreach ($errors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    require_once "database.php";
                    // Check if email already exists
                    $sql = "SELECT * FROM users WHERE email = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        echo "<div class='alert alert-danger'>Email already registered!</div>";
                    } else {
                        // Insert new user
                        $sql = "INSERT INTO users (name, username, password, email, phone_number, address) VALUES (?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        if ($stmt) {
                            $stmt->bind_param("ssssss", $fullName, $userName, $passwordHash, $email, $phoneNumber, $address);
                            $stmt->execute();
                            echo "<div class='alert alert-success'>Successfully registered!</div>";
                        } else {
                            die("Something went wrong: " . $conn->error);
                        }
                    }
                }
            }
        ?>

            <h3 class="w3-center w3-padding"><span class="w3-tag w3-wide" style="background-color: slategrey; color: white;">Register</span></h3>
            <form action="register.php" method="post">
                <div class="credentials">
                    <div class="name">
                        <span class='bx bxs-user'></span>
                        <input type="text" name="name" placeholder="Full Name" required>
                    </div>
                    <div class="username">
                        <span class='bx bxs-user'></span>
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="email">
                        <span class='bx bxs-envelope'></span>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="phone_number">
                        <span class='bx bxs-phone'></span>
                        <input type="text" name="phone_number" placeholder="Phone Number" required>
                    </div>
                    <div class="password">
                        <span class='bx bxs-lock-alt'></span>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="confirmpassword">
                        <span class='bx bxs-lock-alt'></span>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    </div>
                    <div class="address">
                        <span class='bx bxs-map'></span>
                        <input type="text" name="address" placeholder="Address" required>
                    </div>
                </div>
                <button type="submit" name="submit" class="submit">Register</button>
            </form>
            <div class="link">
                <a href="login.php">Already have an account? Login</a>
            </div>
        </div>
    </div>
</body>
</html>