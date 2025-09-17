<?php
// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "Gpsbooking_system");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $user_type = $_POST['user_type'];
    $identifier = $_POST['identifier'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // encrypt password

    // Insert into database
    $sql = "INSERT INTO users (user_type, identifier, name, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $user_type, $identifier, $name, $password);

    if ($stmt->execute()) {
        $message = "<span style='color:green;'>Registration successful. <a href='index.php'>Login here</a></span>";
    } else {
        $message = "<span style='color:red;'>Error: " . $stmt->error . "</span>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="style_indexANDregis.css">
</head>
<body>
  <div class="form-box">
    <h2>Register</h2>

    <!-- Display message -->
    <?php if(!empty($message)) { echo "<p>$message</p>"; } ?>

    <form action="" method="POST">
      <select name="user_type" id="user_type" required>
        <option value="student">Student</option>
        <option value="driver">Driver</option>
      </select>

      <input type="text" name="identifier" id="identifier" placeholder="Student ID" required>

      <input type="text" name="name" placeholder="Name" required>

      <input type="password" name="password" placeholder="Password" required>

      <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="index.php">Login here</a></p>
  </div>

  <script>
    const userType = document.getElementById('user_type');
    const identifier = document.getElementById('identifier');

    userType.addEventListener('change', () => {
      if(userType.value === 'student') {
        identifier.placeholder = 'Student ID';
      } else {
        identifier.placeholder = 'Tricycle Number';
      }
    });
  </script>
</body>
</html>
