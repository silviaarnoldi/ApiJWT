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
    $sqlMacchinario = "SELECT * FROM MACCHINARIO WHERE ID = $userId";
} else {
    // Altrimenti, esegui la query per ottenere tutti gli utenti
    $sqlMacchinario = "SELECT * FROM MACCHINARIO";
}

$resultMacchinari = $conn->query($sqlMacchinario);

// Controllo se la query ha prodotto risultati
if ($resultMacchinari === false) {
    die("Errore nella query: " . $conn->error);
}

// Array per contenere i dati degli utenti
$macchinari = array();

// Iterazione sui risultati della query per estrarre i dati degli utenti
while ($rowUtente = $resultMacchinari->fetch_assoc()) {
    $id = $rowUtente["ID"];
    $nome = isset($rowUtente["NOME"]) ? $rowUtente["NOME"] : "";
    $stato = isset($rowUtente["STATO"]) ? $rowUtente["STATO"] : "";
    $schemaelect = isset($rowUtente["SCHEMA_ELECT"]) ? $rowUtente["SCHEMA_ELECT"] : "";
    $schemamec = isset($rowUtente["SCHEMA_MEC"]) ? $rowUtente["SCHEMA_MEC"] : "";
    $prossimamanutenzione = $rowUtente["PROSSIMA_MANUTENZIONE"];
    $ultimamanutenzione = isset($rowUtente["ULTIMA_MANUTENZIONE"]) ? $rowUtente["ULTIMA_MANUTENZIONE"] : "";
    $chiamatamanutentore = isset($rowUtente["CHIAMATA_MANUTENTORE"]) ? $rowUtente["CHIAMATA_MANUTENTORE"] : "";
    $schemaelect = isset($rowUtente["SCHEMA_ELECT"]) ? $rowUtente["SCHEMA_ELECT"] : "";
    $azienda = isset($rowUtente["AZIENDA_ID"]) ? $rowUtente["AZIENDA_ID"] : "";

    // Aggiungi i dati dell'utente all'array degli utenti
    $macchinario = array(
        "ID" => $id,
        "NOME" => $nome,
        "STATO" => $stato,
        "SCHEMA_ELECT" => $schemaelect,
        "SCHEMA_MEC" => $schemamec,
        "PROSSIMA_MANUTENZIONE" => $prossimamanutenzione,
        "ULTIMA_MANUTENZIONE" => $ultimamanutenzione,
        "CHIAMATA_MANUTENTORE" => $chiamatamanutentore,
        "AZIENDA_ID" => $azienda
    );

    // Aggiungi l'utente all'array degli utenti
    $macchinari[] = $macchinario;
}

// 4. restituire i dati in formato JSON
header('Content-Type: application/json');
echo json_encode($macchinari);

// 5. Chiudi la connessione
$conn->close();
?>