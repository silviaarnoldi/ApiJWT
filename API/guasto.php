<?php
// 1. connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "MaintHelp";

$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// 2. verifica se viene richiesto l'elenco completo degli utenti o solo uno specifico
$id = ltrim($_SERVER['PATH_INFO'], "/");
if($id!=""){ 
    // Se è specificato un ID, esegui la query per ottenere solo l'utente specificato
    $userId = $id;
    $sqlGuasti = "SELECT * FROM GUASTO WHERE ID = $userId";
} else {
    // Altrimenti, esegui la query per ottenere tutti gli utenti
    $sqlGuasti = "SELECT * FROM GUASTO";
}

$resultGuasto = $conn->query($sqlGuasti);

// Controllo se la query ha prodotto risultati
if ($resultGuasto === false) {
    die("Errore nella query: " . $conn->error);
}

// Array per contenere i dati degli utenti
$guasti = array();

// Iterazione sui risultati della query per estrarre i dati degli guasti
while ($rowUtente = $resultGuasto->fetch_assoc()) {
    $id = $rowUtente["ID"];
    $tipoGuasto = isset($rowUtente["TIPOGUASTO"]) ? $rowUtente["TIPOGUASTO"] : "";
    // Aggiungi i dati dell'utente all'array degli guasti
    $guasto = array(
        "ID" => $id,
        "TIPOGUASTO" => $tipoGuasto,
    );

    // Aggiungi l'guasto all'array degli guasti
    $guasti[] = $guasto;
}

// 4. restituire i dati in formato JSON
header('Content-Type: application/json');
echo json_encode($guasti);

// 5. Chiudi la connessione
$conn->close();
?>