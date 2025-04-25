<?php
  session_start();
  
  if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
  }
  $error = null;

  $credentials = require 'credentials.php';
  $storedUsername = $credentials['username'];
  $storedPasswordHash = $credentials['password_hash'];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = $_POST['username'] ?? '';
    $inputPassword = $_POST['password'] ?? ''; 
    if ($inputUsername == $storedUsername && password_verify($inputPassword, $storedPasswordHash)) {
      $_SESSION['user'] = $username;
      header('Location: dashboard.php');
      exit;
    } else {
      $error = "Nieprawidłowe dane logowania";
    }
  }

?>
<h2>Zaloguj się</h2>
<?php if($error): ?>
  <p style='color:red'><?php echo htmlspecialchars($error) ?></p>
<?php endif ?>

<form action="login.php" method="post">
  <label>Login:<input type="text" name="username" required></label><br>
  <label>Hasło:<input type="password" name="password" required></label><br>
  <button type="submit">Zaloguj się</button>
</form>