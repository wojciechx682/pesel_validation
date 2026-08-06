<?php

    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if (isset($_POST["pesel"])) {

            $pesel = $_POST["pesel"];

            //$_SESSION["result"] = validatePesel($pesel) ? "true" : "false";

            $controlDigit = calculateChecksum($pesel);

            //echo $controlDigit; exit();

            if(validatePeselString($pesel) && ($controlDigit == $pesel[10])){
                $_SESSION["result"] = "true";
            } else {
                $_SESSION["result"] = "false";
            }

        }


        header('Location: ' . $_SERVER["REQUEST_URI"], true, 303);
        exit();
    }

    function validatePeselString($pesel) {

        // czy podano
        if (empty($pesel)) {
            return false;
        }

        // 11 cyfr
        if (strlen($pesel) < 11 || strlen($pesel) > 11) {
            return false;
        }

        // tylko liczby
        if (ctype_digit($pesel) === false) {
            return false;
        }

        return true;
    }

    function calculateChecksum($pesel) {



        $weights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];

        $sum = 0;

        for ($i = 0; $i < 10; $i++) {
            $sum += ($pesel[$i] % 10) * $weights[$i];
        }

        $result = (10 - ($sum % 10));

        return $result;
    }

?>

<!DOCTYPE html>
<html lang="pl">
<head>

    <title>Walidator numeru PESEL</title>

</head>
<body>
    <form method="POST">
        <input type="text" name="pesel">
        <button type="submit">Sprawdź</button>
    </form>

    <br>

    <?php
        if (isset($_SESSION["result"])) {
            echo $_SESSION["result"];
            unset($_SESSION["result"]);
        }
    ?>
</body>
</html>