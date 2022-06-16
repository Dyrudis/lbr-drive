function submitSupprCompte(){
    if(document.getElementById('emailCompteSuppr').value && document.getElementById('motDePasse').value){
        $.ajax({
            type: "POST",
            url: "back/account/deleteAccount.php",
            data : {'mdpCompte' : document.getElementById('motDePasse').value, 'emailSuppr' : document.getElementById('emailCompteSuppr').value},
            success: (data) => {
                if(data=='Succes'){
                    alert.create({
                        content: "Le compte a été supprimé",
                        type: "success",
                    });
                    $(".inputSupprCompte").val("");
                }
                if(data=='Echec mdp'){
                    alert.create({
                        content: "Mot de passe invalide",
                        type: "error",
                    });
                    $(".inputSupprCompte").val("");
                }
            }
        });
    }
    else{
        alert.create({
            content: "L'un des champs n'est pas valide",
            type: "error",
        });
    }

}