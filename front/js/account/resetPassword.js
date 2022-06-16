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
                    window.alert("Echec de l'envoie de mail");
                }
                else if(data=='compte suspendu'){
                    window.alert("Votre compte a été suspendu");
                }
                else{
                    window.alert("Email incorrect");
                }
            }
        });
    }
    else{
        window.alert("L'un des champs n'est pas valide");
    }

}