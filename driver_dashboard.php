<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'driver') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Driver Dashboard</title>
  <style>
    body.dashboard {
      font-family: Arial, sans-serif;
      margin: 0;
      height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #28a745;
      color: white;
      padding: 15px 30px;
      font-size: 18px;
      font-weight: bold;
      position: relative;
    }

    .settings {
      position: relative;
      display: inline-block;
    }

    .settings-btn {
      background: #007bff;
      color: white;
      padding: 8px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .settings-btn:hover {
      background: #0056b3;
    }

    .dropdown {
      display: none;
      position: absolute;
      top: 40px;
      right: 0;
      background: white;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
      border-radius: 5px;
      min-width: 120px;
      z-index: 1000;
    }

    .dropdown a {
      display: block;
      padding: 10px;
      text-decoration: none;
      color: black;
    }

    .dropdown a:hover {
      background: #f1f1f1;
    }

    .main-content {
      flex: 1;
      display: flex;
      padding: 20px;
      gap: 20px;
      background: #f2f2f2;
    }

    .queue-section {
      width: 30%;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      overflow-y: auto;
    }

    .queue-section h3 {
      margin-top: 0;
    }

    .queue-list {
      list-style: none;
      padding: 0;
    }

    .queue-list li {
      padding: 10px;
      background: #e8e8e8;
      margin-bottom: 8px;
      border-radius: 5px;
    }

    .map-section {
      flex: 1;
      background: #e0e0e0;
      border-radius: 10px;
      border: 2px solid #999;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #555;
      font-weight: bold;
      font-size: 20px;
    }
  </style>
</head>
<body class="dashboard">
  <!-- Top bar -->
  <div class="top-bar">
    <div><?php echo htmlspecialchars($_SESSION['user_name']); ?> (Driver)</div>
    <div class="settings">
      <button class="settings-btn">⚙ Settings</button>
      <div class="dropdown">
        <a href="logout.php">Logouts</a>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <div class="main-content">
    <div class="queue-section">
      <h3>Queueing List</h3>
      <ul class="queue-list">
        <li>Student A - Waiting</li>
        <li>Student B - Waiting</li>
        <li>Student C - Waiting</li>
        <li>Student D - Waiting</li>
      </ul>
    </div>

    <div class="map-section">
      GPS Map Space
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const settingsBtn = document.querySelector(".settings-btn");
      const dropdown = document.querySelector(".dropdown");

      settingsBtn.addEventListener("click", () => {
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
      });

      window.addEventListener("click", function(e) {
        if (!settingsBtn.contains(e.target) && !dropdown.contains(e.target)) {
          dropdown.style.display = "none";
        }
      });
    });
  </script>
</body>
</html>
