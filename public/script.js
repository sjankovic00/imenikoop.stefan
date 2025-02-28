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
                    $("#edit-name").val(data.ime || '');
                    $("#edit-surname").val(data.prezime || '');
                    $("#edit-phone").val(data.br_telefona || '');
                    $("#edit-address").val(data.adresa || '');
                    $("#edit-email").val(data.email || '');
                    $("#edit-opis").val(data.opis || '');
                    $("#edit-website").val(data.website ? data.website : '');

                    $(".modal-overlay").fadeIn(); // siva pozadina na modalu
                    $("#editModal").fadeIn(); // prikaz modala za editovanje
                } else {
                    alert("Greška pri učitavanju podataka: " + response.message);
                }
            },
            error: function (xhr, status, error) {   // ako dodje do success===false, prikazuje gresku
                console.error("AJAX Greška:", xhr.responseText);
                alert("Došlo je do greške. Proveri konzolu.");
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
                    alert("Podaci uspešno ažurirani!");
                    location.reload();
                } else {
                    alert("Greška pri ažuriranju: " + response.message);
                }
            }
        });
    });

    $(".delete-btn").click(function () { //klikom na dugme obrisi dobijamo upit
        let memberId = $(this).attr("data-id"); // uzimamo id clana iz data-id kog treba da obrisemo

        if (!confirm("Da li ste sigurni da želite da obrišete ovog člana?")) { // poruka koju dobijamo
            return;
        }

        $.ajax({ //slanje ajax zahteva za brisanje
            url: "/delete",
            type: "POST",
            data: { id: memberId },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert("Član uspešno obrisan!");
                    window.location.href = "/index"; // vraca nas na index stranu nako sto je uspesno obrisan clan
                } else {
                    alert("Greška pri brisanju: " + response.message);
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
                    alert("Slika je uspešno dodata!");

                    let newImageHtml = `
                        <div class="image-container">
                            <img src="/${response.filepath}" alt="Profilna slika" class="user-image">
                            <button class="delete-image-btn" data-image-id="${response.image_id}">Obriši sliku</button>
                        </div>
                    `;

                    $(".user-images").append(newImageHtml);
                    $(".no-images-message").remove();
                    $("#uploadForm")[0].reset();
                } else {
                    alert("Greška pri uploadu slike: " + response.message);
                }
            },
            error: function () {
                alert("Došlo je do greške pri uploadu slike.");
            }
        });
    });
});

$(document).on("click", ".delete-image-btn", function () {
    let imageId = $(this).attr("data-image-id"); // Uzmi ID slike
    let imageContainer = $(this).closest(".image-container"); // Nađi div slike

    if (!confirm("Da li ste sigurni da želite da obrišete ovu sliku?")) {
        return;
    }

    $.ajax({
        url: "/delete_image.php",
        type: "POST",
        data: { image_id: imageId },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                alert("Slika je uspešno obrisana!");
                imageContainer.remove(); // Uklanja sliku i dugme BEZ reload-a

                // Ako više nema slika, prikaži poruku
                if ($(".image-container").length === 0) {
                    $(".user-images").html("<p class='no-images-message'>Nema dostupnih slika za ovog korisnika.</p>");
                }
            } else {
                alert("Greška pri brisanju slike: " + response.message);
            }
        },
        error: function () {
            alert("Došlo je do greške pri brisanju slike.");
        }
    });
});

