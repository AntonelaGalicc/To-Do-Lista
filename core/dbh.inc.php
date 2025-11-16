<?php
//povezivanje s bazom podataka
    //$dns = "mysql:host=localhost;dbname=tekica";
   $dns = "mysql:host=127.0.0.1;port=3307;dbname=todolist";
    //msqli - baza
    //host_localhost - baza je na lokalnom racunalu
    //dbname=it_obuka - ime baze na phpmyadmin

    //login podatci za prijavu 
    $dbusername = "root";
    $dbpassword = "";

//pokusaj spajanja na bazu (PDO->PHP Data Objects) -univerzalni nacin za spajanje na bauz
    try{
        // pokusava se stvorit nova veza na bazu pomocu unesenih podataka
        $pdo = new PDO($dns, $dbusername, $dbpassword);
        //ako je sve ok objekt $po postaje objekt za rad s bazom
        $pdo -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "Povezivanje nije uspjelo." . $e->getMessage();
    }

        //ugl ovo je uvijek isto
?>