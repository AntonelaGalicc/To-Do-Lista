<?php 
//ukljucuje datoteku u kojoj se naaziveza s bazom podataka
include_once "../core/dbh.inc.php";


class Zadatak{
    public $id;
    public $naziv_zadatka;
    public $vrijeme;
    public $zadatak_zavrsen;
    private $conn; //interno svojstvo koje sprema konekciju na bazu (objekt $pdo)

    public function __construct($pdo){
        $this->conn = $pdo; //u konstruktor se salje konekcija
    }


        public function read(){
        //priprema upita
        $query = "SELECT id
                        ,naziv_zadatka
                        ,vrijeme
                        ,zadatak_zavrsen
                    FROM zadatak";

        //priprema konekcije prema bazi i upitu
        $stmt = $this->conn->prepare($query);
        //izvrsili upit u bazu i spremili rezultat u varijablu
        $stmt->execute();
        return $stmt;
    }

    function add_zadatak(){
			$query = 'INSERT INTO zadatak (id,naziv_zadatka, vrijeme, zadatak_zavrsen)
													 VALUES (:id,:naziv_zadatka, :vrijeme, :zadatak_zavrsen)';
			
			$stmt = $this->conn->prepare($query);
			
			$this->id 						= htmlspecialchars(strip_tags($this->id));
			$this->naziv_zadatka			= htmlspecialchars(strip_tags($this->naziv_zadatka));
			$this->vrijeme 				    = htmlspecialchars(strip_tags($this->vrijeme));
			$this->zadatak_zavrsen 		    = htmlspecialchars(strip_tags($this->zadatak_zavrsen));

			$stmt->bindParam(':id',	 					$this->id);
			$stmt->bindParam(':naziv_zadatka',	 		$this->naziv_zadatka);
			$stmt->bindParam(':vrijeme',	 			$this->vrijeme);
			$stmt->bindParam(':zadatak_zavrsen', 		$this->zadatak_zavrsen);

			if($stmt->execute()){
				return true;
			}
			else{
				printf("Greška prilikom unosa zadatka. " , $stmt->error);
				return false;
			}


	}
    	function zadatakPostoji(){

		$query                  = 'SELECT id FROM zadatak WHERE upper(naziv_zadatka) = UPPER(:naziv_zadatka)';

		$stmt 		            = $this->conn->prepare($query);
		$this->naziv_zadatka    = htmlspecialchars(strip_tags($this->naziv_zadatka));
		$stmt->bindParam(':naziv_zadatka', $this->naziv_zadatka);

		if($stmt->execute()){
			if($stmt->rowCount()>0){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			printf('Greška prilikom provjere postoji li zadatak!', $stmt->error);
			return false;
		}
	}	

    function delete_zadatak() {
        $query       = 'DELETE  FROM zadatak WHERE (id) = (:id)';

        $stmt 		 = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
		$stmt->bindParam(':id', $this->id);

		if($stmt->execute()){
			if($stmt->rowCount()>0){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			printf('Greška prilikom brisanja zadatka!', $stmt->error);
			return false;
		}
    }

        function update_zadatak(){
			$query = 'UPDATE zadatak 
			             SET  zadatak_zavrsen    = :zadatak_zavrsen
								 WHERE id           = :id';
			
			$stmt = $this->conn->prepare($query);
			
			$this->id 						= htmlspecialchars(strip_tags($this->id));
			$this->zadatak_zavrsen      	= htmlspecialchars(strip_tags($this->zadatak_zavrsen));
			
			$stmt->bindParam(':id',	 						$this->id);
			$stmt->bindParam(':zadatak_zavrsen', 			$this->zadatak_zavrsen);

			if($stmt->execute()){
				return true;
			}
			else{
				printf("Greška prilikom izmjene zadatka. " , $stmt->error);
				return false;
			}


	}
}