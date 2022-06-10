function submitSupprCompte(){
    if(document.getElementById('emailCompteSuppr').value && document.getElementById('motDePasse').value){
        $.ajax({
            type: "POST",
            url: "back/account/deleteAccount.php",
            data : {'mdpCompte' : document.getElementById('motDePasse').value, 'emailSuppr' : document.getElementById('emailCompteSuppr').value},
            success: (data) => {
                if(data=='Succes'){
                    window.alert("Le compte a été supprimé");
                    $(".inputSupprCompte").val("");
                }
                if(data=='Echec mdp'){
                    window.alert("Mot de passe invalide");
                    $(".inputSupprCompte").val("");
                }
            }
        });
    }
    else{

        window.alert("L'un des champs n'est pas valide");
    }

}