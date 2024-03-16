  <?php
  $database = "db.db";

  try {
      $conn = new PDO("sqlite:$database");
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
  } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
  }

  // Check if username and password are set in the POST request
  if (isset($_POST['username'], $_POST['password'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];

      // Prepare the SQL query using placeholders
      $sql = "SELECT * FROM members WHERE username = :username AND password = :password";
      $stmt = $conn->prepare($sql);

      // Bind parameters
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':password', $password);

      // Execute the query
      $stmt->execute();

      // Fetch the result set
      $result = $stmt->fetchAll();

      // Check if there is a matching row in the result set
      if (count($result) > 0) {
          echo "Login successful";
      } else {
          echo "Login failed. You might need to register. <br> <a href='register.php'>Register from here.</a> <br> <a href='forgot-password.php'>Forgot Password?</a>";

      }
  };

  // Close the database connection
  $conn = null;
  ?>
