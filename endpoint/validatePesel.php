<?php

    require_once "../peselValidator.php";
    header('Content-Type: application/json');

    $response = [
        "success" => false,
        "message" => ""
    ];

    try {

        // 1. Sprawdzenie metody żądania
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            throw new Exception("Nieprawidłowa metoda żądania");
        }

        // 3. Walidacja danych
        if (empty($_POST["pesel"])) {
            throw new Exception("Pole PESEL jest wymagane.");
        }

        // 2. Pobranie danych z POST
        $pesel = $_POST["pesel"];

        // Tutaj wywołujesz swoją logikę:
        $isValid = validatePesel($pesel);

        if (!$isValid) {
            throw new Exception("Niepoprawny numer PESEL.");
        }

        // 4. Sukces
        $response["success"] = true;
        $response["message"] = "PESEL jest poprawny.";


    } catch (Exception $e) {

        $response["message"] = $e->getMessage();

    }

    // 5. Zwrócenie JSON
    echo json_encode($response);