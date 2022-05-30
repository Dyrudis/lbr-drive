var correctMdp =0;
var correctEmail =1;
var inputMdp = document.getElementById("mdpCreationCompte");
function checkMdpTemporaire() {
    const checkBox = document.getElementById('mdpTemporaire').checked;
    if (checkBox === true) {
        inputMdp.disabled = true;
        inputMdp.placeholder = 'mot de passe temporaire utilisé';
        inputMdp.value = '';
        correctMdp =1;
    } 
    else {
        inputMdp.disabled = false;
        inputMdp.placeholder = 'mot de passe';
        correctMdp =0;
    }
    checkSubmit();
    
}

function checkMdp() {
    const val = inputMdp.value;
    if(val.match(/[0-9]/g) && val.match( /[A-Z]/g) && val.match(/[a-z]/g) && val.match( /[^a-zA-Z\d]/g)){
        document.getElementById("labelmdpInput").style.visibility = "hidden";
        inputMdp.style.borderColor = "";
        correctMdp=1;

    }
    else{
        document.getElementById("labelmdpInput").style.visibility = "visible";
        inputMdp.style.borderColor = "red";
        correctMdp=0;
    }
    checkSubmit();

}

function checkNewMdp() {
    const val = psw.value;
    if(val.match(/[0-9]/g) && val.match( /[A-Z]/g) && val.match(/[a-z]/g) && val.match( /[^a-zA-Z\d]/g)){
        document.getElementById("labelNewMdp").innerText = "Nouveau mot de passe :"

    }
    else{
        document.getElementById("labelNewMdp").innerText = " Nouveau mot de passe :\n le mot de passe doit contenir:\n 1 maj, 1 min, 1 caractère et un chiffre";
    }

}

function checkSameMdp(){
    const mdp = psw.value;
    const mdp2 = psw2.value;
    if(mdp===mdp2){
        document.getElementById("labelVerifMdp").innerText = " Confirmez le :\n ";
        document.getElementById("submitNewMdp").disabled = false;
    }
    else{
        document.getElementById("labelVerifMdp").innerText = " Confirmez le :\n les 2 mot de passes sont différents";
        document.getElementById("submitNewMdp").disabled = true;
    }
}

/*
function checkEmail(){
    console.log(document.getElementById('emailCreationCompte').value);
    $.ajax({
        type: "POST",
        url: "back/checkEmail.php",
        data : {'email' : document.getElementById('emailCreationCompte').value},
        success: (data) => {
            console.log(data);
            if(data==='1'){
                document.getElementById("emailIncorrect").style.visibility = "hidden";
                document.getElementById('emailCreationCompte').style.borderColor = "";
                console.log("mail correct");
                correctEmail=1;
            }
            else{
                document.getElementById("emailIncorrect").style.visibility = "visible";
                document.getElementById('emailCreationCompte').style.borderColor = "red";
                console.log("mail mauvais");
                correctEmail=0;
                
            }
            checkSubmit();
        
        }
    });
}*/

function checkSubmit(){
    if(correctMdp==1 && correctEmail==1){
        console.log('SA MARCHE');
        document.getElementById("submitCreationCompte").disabled = false;
    }
    else{
        console.log('RATER');
        document.getElementById("submitCreationCompte").disabled = true;
        
    }
        

}