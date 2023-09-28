<?php

class DataRetriever {
    private $con;

    public function __construct($dbConnection) {
        $this->con = $dbConnection;
    }

    public function getRelejnaZastitaData($id, $typeOfZastita) {
        $arrayOfRelejnaZastitaId = [];
        $arrayOfRelejnaZastitaName = [];
        $arrayOfSticeniObjektiId = [];
        $arrayOfSticeniObjektiName = [];
        $arrayOfPeriferijaId = [];
        $arrayOfPeriferijaName = [];

        $sqlGetRelejnaZastita = "SELECT * FROM relejna_zastita WHERE polje_id ='$id' AND vrsta_zastite='$typeOfZastita'";
        $resultGetRelejnaZastita = mysqli_query($this->con, $sqlGetRelejnaZastita) or die(mysqli_error($this->con));

        while ($rowGetRelejnaZastita = mysqli_fetch_array($resultGetRelejnaZastita, MYSQLI_ASSOC)) {
            $arrayOfRelejnaZastitaId[] = $rowGetRelejnaZastita["id"];
            $arrayOfRelejnaZastitaName[] = $rowGetRelejnaZastita["name"];
        }

        $sqlGetSticeniObjekt = "SELECT * FROM sticeni_objekti WHERE polje_id ='$id' AND vrsta_zastite='$typeOfZastita'";
        $resultGetSticeniObjekt = mysqli_query($this->con, $sqlGetSticeniObjekt) or die(mysqli_error($this->con));

        while ($rowGetSticeniObjekt = mysqli_fetch_array($resultGetSticeniObjekt, MYSQLI_ASSOC)) {
            $arrayOfSticeniObjektiId[] = $rowGetSticeniObjekt["id"];
            $arrayOfSticeniObjektiName[] = $rowGetSticeniObjekt["name"];
        }

        $sqlGetPeriferija = "SELECT periferija.id as id, periferija.naziv as naziv, vrsta_periferije.name_periferija as name_periferija
        FROM periferija,vrsta_periferije WHERE vrsta_periferije.id = periferija.vrsta and periferija.id_polje = '$id'";

        $resultGetPeriferija = mysqli_query($this->con, $sqlGetPeriferija) or die(mysqli_error($this->con));

        while ($rowGetPeriferija = mysqli_fetch_array($resultGetPeriferija, MYSQLI_ASSOC)) {
            $arrayOfPeriferijaId[] = $rowGetPeriferija["id"];
            $arrayOfPeriferijaName[] = $rowGetPeriferija["naziv"] . " ($rowGetPeriferija[name_periferija])";
        }

        return [
            "arrayOfRelejnaZastitaId" => $arrayOfRelejnaZastitaId,
            "arrayOfRelejnaZastitaName" => $arrayOfRelejnaZastitaName,
            "arrayOfSticeniObjektiId" => $arrayOfSticeniObjektiId,
            "arrayOfSticeniObjektiName" => $arrayOfSticeniObjektiName,
            "arrayOfPeriferijaId" => $arrayOfPeriferijaId,
            "arrayOfPeriferijaName" => $arrayOfPeriferijaName,
        ];
    }
}

// Example usage:
$dbConnection = mysqli_connect("your_host", "your_username", "your_password", "your_database");
if (!$dbConnection) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET["val"];
$typeOfZastita = $_GET["type"];

$dataRetriever = new DataRetriever($dbConnection);
$result = $dataRetriever->getRelejnaZastitaData($id, $typeOfZastita);

echo json_encode($result);
?>
