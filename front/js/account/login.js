function submitLogin() {
    if (document.getElementById("email").value && document.getElementById("motdepasse").value) {
        $.ajax({
            type: "POST",
            url: "back/account/login.php",
            data: { email: document.getElementById("email").value, motdepasse: document.getElementById("motdepasse").value },
            success: (data) => {
                if (data == "connect") {
                    document.location.href = "index.php";
                } else if (data == "firstConnect") {
                    document.location.href = "setPassword.php";
                } else if (data == "Identifiants incorrects") {
                    alert.create({
                        content: "Identifiants incorrects",
                        type: "error",
                    });
                    $(".inputLogin").val("");
                } else if (data == "suspendu") {
                    alert.create({
                        content: "Votre compte est suspendu",
                        type: "error",
                    });
                    $(".inputLogin").val("");
                } else {
                    console.error(data);
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

document.getElementById("motdepasse").onkeydown = function (e) {

    //deprecated mais fonctionne pour le moment
    if (e.which == 13) {
        submitLogin();
    }
}