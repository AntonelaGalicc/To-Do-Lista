<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods:PUT');
header('Access-Control-Allow-Methods:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

include_once "../core/dbh.inc.php"; // Ovo je tvoj PDO konekcijski kod
include_once "../core/zadatak_db.php"; // Klasa Korisnik


	// Instanciraj klasu Korisnik i proslijedi PDO objekt
	$zadatak = new Zadatak($pdo);

	//
	if (isset($_GET['id']) && !empty($_GET['id'])) {
        $zadatak->id = $_GET['id'];
    } 
    // AKO GA NEMA U URL-u, PROVJERI JSON TIJELO (Body)
    else {
        $data = json_decode(file_get_contents("php://input"));
        $zadatak->id = isset($data->id) ? $data->id : null;
    }

    // PROVJERA: Ako ID nije postavljen niotkud, vrati grešku.
    if (empty($zadatak->id)) {
        echo json_encode(array('message' => 'Greška: ID zadatka za brisanje nije poslan!'));
        exit;
    }
	// $korisnik->naziv_zadatka 			= isset($data->naziv_zadatka)?$data->naziv_zadatka:null;
	// $korisnik->vrijeme 				    = isset($data->vrijeme)?$data->vrijeme:null;
	// $korisnik->zadatak_zavrsen 			= isset($data->zadatak_zavrsen)?$data->zadatak_zavrsen:null;

    if ($zadatak->delete_zadatak()){
			echo json_encode(array('message'=> 'Zadatak je obrisan!'));
			}
	else{
			echo json_encode(array('message'=> 'Greška kod brisanja zadatka!'));
			}
    
	
?>