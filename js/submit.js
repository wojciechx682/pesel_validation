document.getElementById("validate-pesel-form").addEventListener("submit", function (event) {

    // console.log("validate-pesel-form submit event occurred");

    event.preventDefault();

    const formData = new FormData(this); // wstawienie daych formularza (this) do obiektu FormData

    fetch("endpoint/validatePesel.php", {
        method: "POST",
        body: formData
    })
    .then(response => {

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        return response.json();

    })
    .then(data => {

        if (data.success) {

            console.log("Operacja zakończona sukcesem.");

            document.getElementById("result").innerHTML = data.message;

        } else {
            console.error(data.message);

            document.getElementById("result").innerHTML = data.message;
        }

    })
    .catch(error => {
        console.error("Błąd:", error);
    });

});