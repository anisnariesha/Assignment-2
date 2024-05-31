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
</head>
<body>
    <!-- Login Form -->
    <div class="w3-container w3-padding">
        <div class="main">
            <h3 class="w3-center w3-padding"><span class="w3-tag w3-wide" style="background-color: slategrey; color: white;">Login</span></h3>
            <form>
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
                <button class="submit">Submit</button>
            </form>
            <div class="link">
                <a href="register.php">Don't have an account? Register</a>
            </div>
        </div>
    </div>
</body>
</html>