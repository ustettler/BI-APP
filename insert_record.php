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

// Daten aus dem Formular abrufen
$periode = $_POST['periode'];
$total_kwh = $_POST['total_kwh'];
$money = $_POST['money'];


// SQL-Befehl zum Einfügen eines neuen Datensatzes
$sql = "INSERT INTO bills (periode, total_kwh, money, doc) VALUES ('$periode', $total_kwh, $money, 'pdf')";

// Einfügen des Datensatzes
if ($conn->query($sql) === TRUE) {
    // Erfolgreich eingefügt, weiterleiten zur index_admin.php
    header("Location: index_admin.php");
    exit(); // sicherstellen, dass das Skript nach der Weiterleitung beendet wird
} else {
    echo "Fehler beim Einfügen des Datensatzes: " . $conn->error;
}


// Verbindung schließen
$conn->close();
?>