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
    $sqlDocumenti = "SELECT * FROM DOCUMENTO WHERE ID = $userId";
} else {
    // Altrimenti, esegui la query per ottenere tutti gli utenti
    $sqlDocumenti = "SELECT * FROM DOCUMENTO";
}

$resultDocumento = $conn->query($sqlDocumenti);

// Controllo se la query ha prodotto risultati
if ($resultDocumento === false) {
    die("Errore nella query: " . $conn->error);
}

// Array per contenere i dati degli utenti
$documenti = array();

// Iterazione sui risultati della query per estrarre i dati degli documenti
while ($rowUtente = $resultDocumento->fetch_assoc()) {
    $id = $rowUtente["ID"];
    $nome = isset($rowUtente["NOME"]) ? $rowUtente["NOME"] : "";
    $tipodocumento = isset($rowUtente["TIPODOCUMENTO"]) ? $rowUtente["TIPODOCUMENTO"] : "";
    $tipoguasto = isset($rowUtente["TIPOGUASTO"]) ? $rowUtente["TIPOGUASTO"] : "";
    $datainvia = isset($rowUtente["DATA_INVIA"]) ? $rowUtente["DATA_INVIA"] : "";
    $manutentoreid = isset($rowUtente["MANUTENTORE_ID"]) ? $rowUtente["MANUTENTORE_ID"] : "";
    $operatoreid = isset($rowUtente["OPERATORE_ID"]) ? $rowUtente["OPERATORE_ID"] : "";
    $tipomanutenzione = isset($rowUtente["TIPO_MANUTENZIONE"]) ? $rowUtente["TIPO_MANUTENZIONE"] : ""; 
    $oremanutenzione = isset($rowUtente["ORE_MANUTENZIONE"]) ? $rowUtente["ORE_MANUTENZIONE"] : "";
    $descrizione = isset($rowUtente["DESCRIZIONE"]) ? $rowUtente["DESCRIZIONE"] : "";
    $datascrive = isset($rowUtente["DATA_SCRIVE"]) ? $rowUtente["DATA_SCRIVE"] : "";
    $macchinarioid = isset($rowUtente["MACCHINARIO_ID"]) ? $rowUtente["MACCHINARIO_ID"] : "";
    $guastoid = isset($rowUtente["GUASTO_ID"]) ? $rowUtente["GUASTO_ID"] : "";


    // Aggiungi i dati dell'utente all'array degli documenti
    $documento = array(
        "ID" => $id,
        "NOME" => $nome,
        "DESCRIZIONE" => $descrizione,
        "TIPODOCUMENTO" => $tipodocumento,
        "TIPOGUASTO" => $tipoguasto,
        "DATA_INVIA" => $datainvia,
        "MANUTENTORE_ID" => $manutentoreid,
        "OPERATORE_ID" => $operatore,
        "TIPO_MANUTENZIONE" => $tipomanutenzione,
        "ORE_MANUTENZIONE" => $oremanutenzione,
        "DATA_SCRIVE" => $datascrive,
        "MACCHINARIO_ID" => $macchinarioid,
        "GUASTO_ID" => $guastoid

    );

    // Aggiungi l'documento all'array degli documenti
    $documenti[] = $documento;
}

// 4. restituire i dati in formato JSON
header('Content-Type: application/json');
echo json_encode($documenti);

// 5. Chiudi la connessione
$conn->close();
?>