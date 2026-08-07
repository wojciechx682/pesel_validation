<?php

    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if (isset($_POST["pesel"])) {

            $pesel = $_POST["pesel"];

            if(validatePesel($pesel)) {
                $_SESSION["result"] = "true";
            } else {
                $_SESSION["result"] = "false";
            }

        }


        header('Location: ' . $_SERVER["REQUEST_URI"], true, 303);
        exit();
    }

    function validatePesel($pesel) {
        if (!validatePeselString($pesel)) return false;
        if (!calculateChecksum($pesel)) return false;
        $year = (int) substr($pesel, 0, 2);
        $month = (int) substr($pesel, 2, 2);
        $day = (int) substr($pesel, 4, 2);
        if (!validateDate($year, $month, $day)) return false;
        return true;
    }

    function validatePeselString($pesel) {

        // czy podano
        if (empty($pesel)) {
            return false;
        }

        // 11 cyfr
        if (strlen($pesel) !== 11) {
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
            $sum += $pesel[$i] * $weights[$i];
        }

        $result = (10 - ($sum % 10)) % 10;

        return $result == $pesel[10];
    }

    function validateDate($year, $month, $day) {

        if ($month >= 1 && $month <= 12) {
            $century = 1900;
        } elseif ($month >= 21 && $month <= 32) {
            $century = 2000;
            $month -= 20;
        } elseif ($month >= 41 && $month <= 52) {
            $century = 2100;
            $month -= 40;
        } elseif ($month >= 61 && $month <= 72) {
            $century = 2200;
            $month -= 60;
        } elseif ($month >= 81 && $month <= 92) {
            $century = 1800;
            $month -= 80;
        } else {
            return false;
        }

        $year += $century;

        return checkdate($month, $day, $year);
    }

?>

<!DOCTYPE html>
<html lang="pl">
<head>

    <title>Walidator numeru PESEL</title>

    <style>
        body {
            background-color: #7e7e7e;
        }
    </style>

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