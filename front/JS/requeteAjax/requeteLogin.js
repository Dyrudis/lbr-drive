function submitLogin(){ 
    if(document.getElementById('email').value && document.getElementById('motdepasse').value ){
        
        $.ajax({
            type: "POST",
            url: "back/dataLogin.php",
            data : {'email' : document.getElementById('email').value, 'motdepasse' : document.getElementById('motdepasse').value },
            success: (data) => {
                if(data=='connect'){
                    document.location.href="index.php"; 
                }
                if(data=='firstConnect'){
                    document.location.href="nouveauMdp.php"; 
                }
                if(data=='Identifiants incorrects'){
                    window.alert("Identifiants incorrects");
                    $(".inputLogin").val("");
                }
                if(data=='suspendu'){
                    window.alert("Votre compte est suspendu");
                    $(".inputLogin").val("");
                }
            }
        });
    }
    else{

        window.alert("L'un des champs n'est pas valide");
    }
}