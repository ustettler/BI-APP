<?php
// Fehlerausgabe für PHP aktivieren
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verbindung zur Datenbank herstellen
$host = "localhost";
$username = "root";
$password = "root";
$database = "power";

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Überprüfen, ob die ID des zu löschenden Datensatzes übergeben wurde
if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];

    // SQL-Befehl zum Löschen des Datensatzes mit der übergebenen ID
    $sql = "DELETE FROM bills WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Datensatz erfolgreich gelöscht, Redirect zu index_admin.php
        header("Location: ./index_admin.php");
        exit(); // sicherstellen, dass nach dem Redirect keine weiteren Ausgaben gemacht werden
    } else {
        echo "Fehler beim Löschen des Datensatzes: " . $conn->error;
    }
} else {
    echo "Keine ID zum Löschen übergeben.";
}

// Verbindung schließen
$conn->close();
?>
