<?php
$database = "db.db";

try {
    $conn = new PDO("sqlite:$database");
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Validate email and password
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
        $password = $_POST["password"];

        // Check if the email is already registered
        $sql = "SELECT * FROM members WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if (count($result) > 0) {
            echo "You are already registered";
        } else {
            // Insert new user into database
            $sql = "INSERT INTO members (username, password, email) VALUES (:username, :password, :email)"; // Fix parentheses and parameter order
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            echo "You are registered";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
      body {
          text-align: center;
          zoom: 2.5;
          background-color: mintcream;
      }
      form {
          margin: auto;
          padding-top:20px;
          background-color : lightblue;
          height: 150px;
          width: 200px;
      }
      .btn {
          cursor: pointer;
      }
    </style>
</head>
<body>
    <h2>Register</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button class="btn" type="submit">Register</button>
    </form>
</body>
</html>
