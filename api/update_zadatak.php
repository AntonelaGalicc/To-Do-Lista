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
	$data = json_decode(file_get_contents("php://input"));

  	$zadatak->id 						= $data->id;
	// $zadatak->naziv_zadatka 			= $data->naziv_zadatka;
	// $zadatak->vrijeme 				    = $data->vrijeme;
	$zadatak->zadatak_zavrsen 			= $data->zadatak_zavrsen;


    if ($zadatak->update_zadatak()){
			echo json_encode(array('message'=> 'Zadatak je izmjenjen!'));
			}
	else{
			echo json_encode(array('message'=> 'Greška kod update zadatka!'));
			}
    
	
?>