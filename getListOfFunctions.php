<?php

class FunctionListManager {
    private $con;
    private $globalTypeOfIzvjesce;

    public function __construct($dbConnection, $globalTypeOfIzvjesce) {
        $this->con = $dbConnection;
        $this->globalTypeOfIzvjesce = $globalTypeOfIzvjesce;
    }

    public function getListOfFunctions() {
        $arrayOfFunctionsNameForIzvjesce = [];
        $arrayOfFunctionsIdForIzvjesce = [];
        $arrayOfFunctionsIdPrikazForIzvjesce = [];

        $sqlGetListOfFunctions = "SELECT * FROM list_of_functions WHERE id_group_of_security='" . $this->globalTypeOfIzvjesce . "' ORDER BY function_id_view ASC";
        $resultGetListOfFunctions = mysqli_query($this->con, $sqlGetListOfFunctions) or die(mysqli_error($this->con));

        while ($rowListOfFunctions = mysqli_fetch_array($resultGetListOfFunctions, MYSQLI_ASSOC)) {
            $arrayOfFunctionsNameForIzvjesce[] = $rowListOfFunctions["function_name"];
            $arrayOfFunctionsIdForIzvjesce[] = $rowListOfFunctions["function_id"];
            $arrayOfFunctionsIdPrikazForIzvjesce[] = $rowListOfFunctions["function_id_view"];
        }

        return [
            'functionsName' => $arrayOfFunctionsNameForIzvjesce,
            'functionsId' => $arrayOfFunctionsIdForIzvjesce,
            'functionsIdPrikaz' => $arrayOfFunctionsIdPrikazForIzvjesce,
        ];
    }
}

// Example usage:
$dbConnection = mysqli_connect("your_host", "your_username", "your_password", "your_database");
if (!$dbConnection) {
    die("Connection failed: " . mysqli_connect_error());
}

$globalTypeOfIzvjesce = 0; // Replace with the desired value

$functionListManager = new FunctionListManager($dbConnection, $globalTypeOfIzvjesce);
$functions = $functionListManager->getListOfFunctions();

// Access the results
$functionsName = $functions['functionsName'];
$functionsId = $functions['functionsId'];
$functionsIdPrikaz = $functions['functionsIdPrikaz'];
?>
