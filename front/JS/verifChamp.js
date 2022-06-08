var mdpCorrect=0;
var inputMdp = document.getElementById("mdpCreationCompte");
var selectTag = $('#boutonAddTag')
var allTag= [];
var request = new XMLHttpRequest();
    request.open("get", "back/tags/getTags.php", true);
    request.send();
    request.onload = function () {
        console.log(JSON.parse(this.responseText));

        let tags = JSON.parse(this.responseText);
        tags.forEach(function (tag) {
            selectTag.append($("<option />").attr("value", tag.IDTag).text(tag.NomTag));
        });
        selectTag.change(function(){
            let tagID = selectTag.val();
            tag = tags.find((tag) => tag.IDTag == tagID);
            if(tagID!="" && !allTag.includes(tagID)){
                let newTag = $("<div>")
                .addClass("tag")
                .attr("data-id", tag.IDTag)
                .css("background-color", "#" + tag.Couleur);
            newTag.html("<p>" + tag.NomTag + "</p>");

            let deleteTag = $("<img>").attr("src", "front/images/close.svg");
            newTag.append(deleteTag);
            newTag.css("cursor", "pointer");
            newTag.click(() => {
                newTag.remove();
                allTag = allTag.filter(findTag => findTag != tagID);
            });
                allTag.push(tagID);
                $("#tagInvite").append(newTag);
            }
            console.log(allTag);
            selectTag.val("");
        });
    };
function checkMdpTemporaire() {
    const checkBox = document.getElementById('mdpTemporaire').checked;
    if (checkBox === true) {
        inputMdp.disabled = true;
        inputMdp.placeholder = 'mot de passe temporaire utilisé';
        inputMdp.value = '';
        inputMdp.style.borderColor='';
        inputMdp.required = false;
        document.getElementById('labelmdpInput').style.visibility='hidden';
        mdpCorrect=1;
        
    } 
    else {
        inputMdp.disabled = false;
        inputMdp.required = true;
        inputMdp.placeholder = '';
        mdpCorrect=0;
    }
    console.log(mdpCorrect);
    
}

function checkMdp() {
    const val = inputMdp.value;
    if(val.match(/[0-9]/g) && val.match( /[A-Z]/g) && val.match(/[a-z]/g) && val.match( /[^a-zA-Z\d]/g)){
        document.getElementById("labelmdpInput").style.visibility = "hidden";
        inputMdp.style.borderColor = "";
        mdpCorrect=1;

    }
    else{
        document.getElementById("labelmdpInput").style.visibility = "visible";
        inputMdp.style.borderColor = "red";
        mdpCorrect=0;
    }

}

function checkNewMdp() {
    const mdp = psw.value;
    if(mdp.match(/[0-9]/g) && mdp.match( /[A-Z]/g) && mdp.match(/[a-z]/g) && mdp.match( /[^a-zA-Z\d]/g)){
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
        if(mdp2.match(/[0-9]/g) && mdp2.match( /[A-Z]/g) && mdp2.match(/[a-z]/g) && mdp2.match( /[^a-zA-Z\d]/g)){
            document.getElementById("submitNewMdp").disabled = false;
    
        }
        
    }
    else{
        document.getElementById("labelVerifMdp").innerText = " Confirmez le :\n les 2 mot de passes sont différents";
        document.getElementById("submitNewMdp").disabled = true;
    }
}

function tagVisible(){
    if(document.getElementById('selectRole').value=='invite'){
        document.getElementById('tagInvite').style.visibility = 'visible';
        
    }
    else{
        document.getElementById('tagInvite').style.visibility = 'hidden';
    }
}

function modifTagInvite(){
    if(document.getElementById('selectChamp').value=='tag'){
        document.getElementById('nouvelleValeur').style.visibility = 'hidden';
        document.getElementById('labelNouvelleValeur').style.visibility = 'hidden';
        document.getElementById('tagInvite2').style.visibility = 'visible';
        selectTag = $('#boutonAddTagInvite')
        var request = new XMLHttpRequest();
        request.open("get", "back/tags/getTags.php", true);
        request.send();
        request.onload = function () {
            console.log(JSON.parse(this.responseText));

            let tags = JSON.parse(this.responseText);
            tags.forEach(function (tag) {
                selectTag.append($("<option />").attr("value", tag.IDTag).text(tag.NomTag));
            });
            selectTag.change(function(){
                let tagID = selectTag.val();
                tag = tags.find((tag) => tag.IDTag == tagID);
                if(tagID!="" && !allTag.includes(tagID)){
                    let newTag = $("<div>")
                    .addClass("tag")
                    .attr("data-id", tag.IDTag)
                    .css("background-color", "#" + tag.Couleur);
                newTag.html("<p>" + tag.NomTag + "</p>");

                let deleteTag = $("<img>").attr("src", "front/images/close.svg");
                newTag.append(deleteTag);
                newTag.css("cursor", "pointer");
                newTag.click(() => {
                    newTag.remove();
                    allTag = allTag.filter(findTag => findTag != tagID);
                });
                    allTag.push(tagID);
                    $("#tagInvite2").append(newTag);
                }
                console.log(allTag);
                selectTag.val("");
            });
        };
    }
    else{
        document.getElementById('nouvelleValeur').style.visibility = 'visible';
        document.getElementById('labelNouvelleValeur').style.visibility = 'visible';
        document.getElementById('tagInvite2').style.visibility = 'hidden';
    }
}

function submitModifCompte(){
    $.ajax({
        type: "POST",
        url: "back/modifCompte.php",
        data : {'email' : document.getElementById('emailModifCompte').value, 'champ' : document.getElementById('selectChamp').value, 'valeur' : document.getElementById('nouvelleValeur').value, 'tags' : JSON.stringify(allTag)},
        success: (data) => {
            console.log(data);
            window.alert(data);
            $(".inputModifCompte").val("");

        }
        
    });
    allTag= [];
    document.getElementById('nouvelleValeur').style.visibility = 'visible';
    document.getElementById('labelNouvelleValeur').style.visibility = 'visible';
    document.getElementById('tagInvite2').style.visibility = 'hidden';
}

function submitInfoCompte(){ 
    if(document.getElementById('emailCreationCompte').value && document.getElementById('prenomCreationCompte').value && document.getElementById('nomCreationCompte').value
        && mdpCorrect=='1' && document.getElementById('descriptionCreationCompte').value && document.getElementById('selectRole').value){
        
        $.ajax({
            type: "POST",
            url: "back/dataSignUp.php",
            data : {'email' : document.getElementById('emailCreationCompte').value, 'prenom' : document.getElementById('prenomCreationCompte').value, 'nom' : document.getElementById('nomCreationCompte').value,
                'motDePasse' : document.getElementById('mdpCreationCompte').value, 'mdpTemporaire' : JSON.stringify(document.getElementById('mdpTemporaire').checked), 'description' : document.getElementById('descriptionCreationCompte').value,
                'role' : document.getElementById('selectRole').value, 'tags' : JSON.stringify(allTag)},
            success: (data) => {
                console.log(data);
                window.alert(data);
                $(".inputCreationCompte").val("");
                
            }
        });
    }
    else{

        window.alert("L'un des champs n'est pas valide");
    }
    allTag= [];
}