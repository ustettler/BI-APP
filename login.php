<?php
session_start();

// Harte kodiertes Benutzername und Passwort (ersetze dies mit einer sichereren Implementierung)
$valid_username = "test";
$valid_password = "12345";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Benutzername und Passwort aus dem Formular erhalten
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Überprüfe, ob Benutzername und Passwort korrekt sind
    if ($username === $valid_username && $password === $valid_password) {
        // Setze die Benutzer-ID in der Session
        $_SESSION["loggedin"] = true;
        // Weiterleitung zur index.php
        header("Location: index_admin.php");
        exit;
    } else {
        // Wenn die Anmeldeinformationen ungültig sind, zeige eine Fehlermeldung an
        $error = "Ungültige Anmeldeinformationen. Bitte versuchen Sie es erneut.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="./style.css">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
    <style>
        body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}
    </style>
  <div class="login-container">
    <h2>Login</h2>
    <br/>
    <?php if (isset($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="form-group">
        <label for="username">Benutzername &nbsp; </label>
        <input type="text" id="username" name="username" placeholder="test" required>
      </div>
<h3></h3>
      <div class="form-group">
        <label for="password">Passwort&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</label>
        <input type="password" id="password" name="password" placeholder="12345" required>
      </div>
      <button type="submit" class="btn">Einloggen</button>
    </form>
  </div>
</body>
</html>
