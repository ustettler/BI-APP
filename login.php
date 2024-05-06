<?php
session_start();


// db_credentials.php
$host = "localhost";
$username = "root";
$password = "root";
$database = "power";

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Benutzername und Passwort aus dem Formular erhalten
    $username = $_POST["username"];
    $password = $_POST["password"];

    // SQL-Abfrage, um Benutzerdaten abzurufen
    $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Benutzer gefunden, setze die Benutzer-ID in der Session
        $_SESSION["loggedin"] = true;
        // Weiterleitung zur index.php
        header("Location: index_admin.php");
        exit;
    } else {
        // Wenn die Anmeldeinformationen ungültig sind, zeige eine Fehlermeldung an
        $error = "Ungültige Anmeldeinformationen. Bitte versuchen Sie es erneut.";
    }
}

// Datenbankverbindung schließen
$conn->close();
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
          display: flex;
          flex-direction: column;
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

#login-btn {
    margin-top: 50px;
    color: white;
}

a {
    color: white;
}

a:hover {
    color: brown;
}

    </style>
 <div class="login-container">
    <h2>Login</h2>
    <br/>
    <h1></h1>
    <?php if (isset($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="username">Benutzername &nbsp; </label>
            <input type="text" id="username" name="username" placeholder="Benutzername" required>
        </div>
        <div class="form-group">
            <label for="password">Passwort&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;</label>
            <input type="password" id="password" name="password" placeholder="Passwort" required>
        </div>
        <button type="submit" class="btn">Einloggen</button>
    </form>
</div>

<button id="login-btn" class="btn"><a href="index.php" class="button">Zurück</a></button>
</body>
</html>
