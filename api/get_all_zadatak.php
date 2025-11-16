<?php
header('Access-Control-Allow-Origin:*'); //dozvola da front moze pristupit apiju
header('Content-Type: application/json'); //u json formatu
 
include_once "../core/dbh.inc.php"; // Ovo je tvoj PDO konekcijski kod
include_once "../core/zadatak_db.php"; // Klasa Korisnik
 
 
// Instanciraj klasu Korisnik i proslijedi PDO objekt
$zadatak = new Zadatak($pdo);
 
// Pozovi metodu read() za dohvat podataka
$rezultat = $zadatak->read();
 
// Broj rezultata tj broji koliko redaka je baza vratila
$broj_rezultata = $rezultat->rowCount();
 
if ($broj_rezultata > 0) {
    $zadatak_niz = array();
    $zadatak_niz['response'] = array();
 
    // Iteriraj kroz rezultate
    while ($red = $rezultat->fetch(PDO::FETCH_ASSOC)) {
        if ($red) { // Provjeravamo je li $red validan
            extract($red); // Samo ako $red nije null, onda Ä‡emo ekstraktirati podatke
            // Kreiraj niz s podacima korisnika
            $zadatak_red = array(
                'id'                => $id,
                'naziv_zadatka'     => $naziv_zadatka,
                'vrijeme'           => $vrijeme,
                'zadatak_zavrsen'   => $zadatak_zavrsen,
 
            );
 
            // Dodaj korisnika u odgovor
            array_push($zadatak_niz['response'], $zadatak_red);
        }
    }
 
        // PoĹˇaljemo JSON odgovor
    echo json_encode($zadatak_niz);
} else {
    // Ako nema podataka
    echo json_encode(array('message' => 'Nema podataka'));
}
 
?>