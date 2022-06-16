let inputMdp = document.getElementById("nouveauMdp");
let inputVerifMdp = document.getElementById("verifNouveauMdp");

function VerifChampMdp() {
    if (inputMdp.value.match(/[0-9]/g) && inputMdp.value.match(/[A-Z]/g) && inputMdp.value.match(/[a-z]/g) && inputMdp.value.match(/[^a-zA-Z\d]/g)) {
        document.getElementById("labelNouveauMdp").innerText = "Nouveau mot de passe :";
        return true;
    } else {
        document.getElementById("labelNouveauMdp").innerText = " Nouveau mot de passe :\n le mot de passe doit contenir au moins:\n 1 maj, 1 min, 1 caractère et un chiffre";
        return false;
    }
}

function idemMdp() {
    if (inputMdp.value === inputVerifMdp.value) {
        document.getElementById("labelVerifNouveauMdp").innerText = " Confirmez le :";
        return true;
    } else {
        document.getElementById("labelVerifNouveauMdp").innerText = " Confirmez le :\n les 2 mot de passes sont différents";
        return false;
    }
}

function submitNouveauMdp() {
    if (idemMdp() && VerifChampMdp()) {
        $.ajax({
            type: "POST",
            url: "back/account/updatePassword.php",
            data: { nouveauMdp: inputMdp.value, ancienMdp: document.getElementById("ancienMdp").value },
            success: (data) => {
                if (data == "Succes") {
                    alert.create({
                        content: "Mot de passe modifié",
                        type: "success",
                    });
                    $(".inputNouveauMdp").val("");
                }
                if (data == "Echec") {
                    alert.create({
                        content: "Mot de passe incorrect",
                        type: "error",
                    });
                    $(".inputNouveauMdp").val("");
                }
            },
        });
    } else {
        window.alert("L'un des champs n'est pas valide");
    }
}
