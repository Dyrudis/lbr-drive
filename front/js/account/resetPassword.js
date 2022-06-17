function submitResetMdp(){
    if(document.getElementById('email').value){
        $.ajax({
            type: "POST",
            url: "back/account/resetPassword.php",
            data : {'email' : document.getElementById('email').value},
            success: (data) => {
                if(data=='Succes'){
                    document.location.href="login.php"; 
                }
                else if(data=='Echec'){
                    alert.create({
                        content: "Echec de l'envoie de mail",
                        type: "error",
                    });
                }
                else if(data=='compte suspendu'){
                    alert.create({
                        content: "Votre compte a été suspendu",
                        type: "error",
                    });
                }
                else{
                    alert.create({
                        content: "Email incorrect",
                        type: "error",
                    });
                }
            }
        });
    }
    else{
        window.alert("L'un des champs n'est pas valide");
    }

}