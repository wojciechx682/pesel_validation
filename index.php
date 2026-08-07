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

    <form method="POST" id="validate-pesel-form">
        <input type="text" name="pesel">
        <button type="submit">Sprawdź</button>
    </form>

    <br>

    <span id="result"></span>

    <?php
//        if (isset($_SESSION["result"])) {
//            echo $_SESSION["result"];
//            unset($_SESSION["result"]);
//        }
    ?>

    <script src="js/submit.js"></script>

</body>

</html>