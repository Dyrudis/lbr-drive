let inputMdp = document.getElementById("nouveauMdp");
let inputVerifMdp = document.getElementById("verifNouveauMdp");

function VerifChampMdp() {
    if (inputMdp.value.match(/[0-9]/g) && inputMdp.value.match(/[A-Z]/g) && inputMdp.value.match(/[a-z]/g) && inputMdp.value.match(/[^a-zA-Z\d]/g)) {
        return true;
    } else {
        return false;
    }
}

function idemMdp() {
    if (inputMdp.value === inputVerifMdp.value) {
        document.getElementById("labelVerifNouveauMdp").innerText = " Confirmez mot de passe :";
        return true;
    } else {
        document.getElementById("labelVerifNouveauMdp").innerText = " Confirmez mot de passe :\n les 2 mots de passe sont différents";
        return false;
    }
}

function submitNouveauMdp() {
    if (idemMdp() && VerifChampMdp()) {
        $.ajax({
            type: "POST",
            url: "back/account/setPassword.php",
            data: { nouveauMdp: inputMdp.value },
            success: (data) => {
                if (data == "Succes") {
                    document.location.href = "index.php";
                }
                if (data == "Echec") {
                    alert.create({
                        content: "L'ajout du nouveau mot de passe a échoué",
                        type: "error",
                    });
                    $(".inputNouveauMdp").val("");
                }
            },
        });
    } else {
        alert.create({
            content: "L'un des champs n'est pas valide",
            type: "error",
        });
    }
}
