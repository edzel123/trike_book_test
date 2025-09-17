<?php
session_start(); // Start session to track user
include 'db.php'; // Use your db.php connection file

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_type = $_POST['user_type'];
    $identifier = $_POST['identifier'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE user_type=? AND identifier=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_type, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Login successful, save session info
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_type'] = $user['user_type'];

            // Redirect to respective dashboard
            if ($user['user_type'] === 'student') {
                header("Location: student_dashboard.php");
            } else {
                header("Location: driver_dashboard.php");
            }
            exit;
        } else {
            $message = "<span style='color:red;'>Incorrect password.</span>";
        }
    } else {
        $message = "<span style='color:red;'>User not found.</span>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="style_indexANDregis.css">
</head>
<body>
  <div class="form-box">
    <h2>Login</h2>

    <!-- Display login messages -->
    <?php if(!empty($message)) { echo "<p>$message</p>"; } ?>

    <form action="" method="POST">
      <select name="user_type" id="user_type" required>
        <option value="student">Student</option>
        <option value="driver">Driver</option>
      </select>

      <input type="text" name="identifier" id="identifier" placeholder="Student ID" required>

      <input type="password" name="password" placeholder="Password" required>

      <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
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
