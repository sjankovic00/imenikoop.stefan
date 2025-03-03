$(document).ready(function () { //ceka da se stranica ucita, pa tek krece da se izvrsava

    $(document).on("click", ".edit-btn", function () { //kada kliknemo na edit, pokrecemo funkciju koja ucitava id, salje ajax zahtev, popunjava forme
        let memberId = $(this).attr("data-id"); // dohvatamo id korisnika uz pomoc data-id

        $.ajax({ // ajax zahtev za ucitavanje podataka clana
            url: "/edit", // pozivamo rutu
            type: "POST", //post metoda za slanje podataka
            data: { id: memberId }, // id clana koga trebamo ucitati
            dataType: "json", // ocekuje se json odgovor o podacima
            success: function (response) { //obrada odgovora servera
                console.log("Server response:", response);// prikaz odgovora u konzoli za debug

                if (response.success) { // ako je true dobijamo podatke clana
                    let data = response.data;
                    $("#edit-id").val(data.id || ''); //popunjavanje forme sa podacima iz baze
                    $("#edit-name").val(data.name || '');
                    $("#edit-surname").val(data.surname || '');
                    $("#edit-phone").val(data.phone_number || '');
                    $("#edit-address").val(data.address || '');
                    $("#edit-email").val(data.email || '');
                    $("#edit-opis").val(data.description || '');
                    $("#edit-website").val(data.website ? data.website : '');

                    $(".modal-overlay").fadeIn(); // siva pozadina na modalu
                    $("#editModal").fadeIn(); // prikaz modala za editovanje
                } else {
                    alert("Error loading data: " + response.message);
                }
            },
            error: function (xhr, status, error) {   // ako dodje do success===false, prikazuje gresku
                console.error("AJAX Error:", xhr.responseText);
                alert("An error occurred. Check the console.");
            }
        });
    });

    $(".modal-close, .modal-overlay").click(function () { //zatvaranje modala, na klik dugmeta ili na sivu pozadinu
        $("#editModal").fadeOut();
        $(".modal-overlay").fadeOut();
    });

    $("#saveEdit").click(function () { //klikom na sacuvaj dugme, uzimamo sve podatke iz forme i cuvamo ih
        let formData = $("#editForm").serialize();  //automatski formatira podatke za slanje

        $.ajax({ // slanje ajax zahteva za update
            url: "/edit",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                console.log("Save response:", response);
                if (response.success) {
                    alert("Data successfully updated!");
                    location.reload();
                } else {
                    alert("Error updating: " + response.message);
                }
            }
        });
    });

    $(".delete-btn").click(function () { //klikom na dugme obrisi dobijamo upit
        let memberId = $(this).attr("data-id"); // uzimamo id clana iz data-id kog treba da obrisemo

        if (!confirm("Are you sure you want to delete this member?")) { // poruka koju dobijamo
            return;
        }

        $.ajax({ //slanje ajax zahteva za brisanje
            url: "/delete",
            type: "POST",
            data: { id: memberId },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert("Member successfully deleted!");
                    window.location.href = "/index"; // vraca nas na index stranu nako sto je uspesno obrisan clan
                } else {
                    alert("Error deleting: " + response.message);
                }
            }
        });
    });
});

$(document).ready(function () {
    $("#uploadForm").submit(function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "upload.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert("Picture successfully added!");

                    let newImageHtml = `
                        <div class="image-container">
                            <img src="/${response.filepath}" alt="Profilna slika" class="user-image">
                            <button class="delete-image-btn" data-image-id="${response.image_id}">Delete picture</button>
                        </div>
                    `;

                    $(".user-images").append(newImageHtml);
                    $(".no-images-message").remove();
                    $("#uploadForm")[0].reset();
                } else {
                    alert("Error uploading image: " + response.message);
                }
            },
            error: function () {
                alert("There was an error uploading the image.");
            }
        });
    });
});

$(document).on("click", ".delete-image-btn", function () {
    let imageId = $(this).attr("data-image-id"); // Uzmi ID slike
    let imageContainer = $(this).closest(".image-container"); // Nađi div slike

    if (!confirm("Are you sure you want to delete this picture?")) {
        return;
    }

    $.ajax({
        url: "/delete_image.php",
        type: "POST",
        data: { image_id: imageId },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                alert("Picture successfully deleted!");
                imageContainer.remove(); // Uklanja sliku i dugme BEZ reload-a

                // Ako više nema slika, prikaži poruku
                if ($(".image-container").length === 0) {
                    $(".user-images").html("<p class='no-images-message'>There are no images available for this user.</p>");
                }
            } else {
                alert("Error deleting image:" + response.message);
            }
        },
        error: function () {
            alert("An error occurred while deleting the picture.");
        }
    });
});

