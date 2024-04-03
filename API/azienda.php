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
    $sqlAzienda = "SELECT * FROM AZIENDA WHERE ID = $userId";
} else {
    // Altrimenti, esegui la query per ottenere tutti gli utenti
    $sqlAzienda = "SELECT * FROM AZIENDA";
}

$resultAzienda = $conn->query($sqlAzienda);

// Controllo se la query ha prodotto risultati
if ($resultAzienda === false) {
    die("Errore nella query: " . $conn->error);
}

// Array per contenere i dati degli utenti
$aziende = array();

// Iterazione sui risultati della query per estrarre i dati degli aziende
while ($rowUtente = $resultAzienda->fetch_assoc()) {
    $id = $rowUtente["ID"];
    $tipoGuasto = isset($rowUtente["NOME"]) ? $rowUtente["NOME"] : "";
    // Aggiungi i dati dell'utente all'array degli aziende
    $azienda = array(
        "ID" => $id,
        "NOME" => $tipoGuasto,
    );

    // Aggiungi l'guasto all'array degli aziende
    $aziende[] = $azienda;
}

// 4. restituire i dati in formato JSON
header('Content-Type: application/json');
echo json_encode($aziende);

// 5. Chiudi la connessione
$conn->close();
?>