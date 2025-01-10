<?php
  // phpinfo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Landing Page</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    .navbar {
      overflow: hidden;
      background-color: #333;
    }
    .navbar a {
      float: left;
      display: block;
      color: #f2f2f2;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }
    .navbar a:hover {
      background-color: #ddd;
      color: black;
    }
    .content {
      padding: 20px;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
  </div>
  <div class="content">
    <h1>Welcome to Our Landing Page</h1>
    <p>This is the landing page of our website.</p>
  </div>

  <button onclick="location.reload();">Refresh Page</button>
  <button onclick="history.back();">Back</button>
</body>
</html>