<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Methods:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");

// KRITIČNO: Dozvoljavanje svih headera, uključujući 'Content-Type'
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "../core/dbh.inc.php"; // Ovo je tvoj PDO konekcijski kod
include_once "../core/zadatak_db.php"; // Klasa Korisnik


	// Instanciraj klasu Korisnik i proslijedi PDO objekt
	$zadatak = new Zadatak($pdo);

	//
	$data = json_decode(file_get_contents("php://input"));


	$zadatak->naziv_zadatka 			= $data->naziv_zadatka;
	$zadatak->vrijeme 				    = date('Y-m-d H:i:s');
	$zadatak->zadatak_zavrsen 			= isset($data->zadatak_zavrsen) ? $data->zadatak_zavrsen : 0;



	 if($zadatak->zadatakPostoji()){
	 	echo json_encode(array('message'=> 'Zadani zadatak '. strtoupper($zadatak->naziv_zadatka) .' već postoji u sustavu!'));
	  	exit;
	  }
	 else{
	 		if ($zadatak->add_zadatak()){
	 			echo json_encode(array('message'=> 'Zadatak je kreiran!'));
			}
		
		
 		else{
 			echo json_encode(array('message'=> 'Greska kod kreiranja zadatka!'));
	 		}
     }

	
?>