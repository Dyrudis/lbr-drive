var mdpCorrect = false;
var emailCorrect = false;
var inputMdp = document.getElementById("mdpCreationCompte");
var selectTag = $("#boutonAddTag");
var allTag = [];
var allTag2 = [];
var request = new XMLHttpRequest();
request.open("get", "back/tag/getTags.php", true);
request.send();
request.onload = function () {

    let tags = JSON.parse(this.responseText);
    tags.forEach(function (tag) {
        selectTag.append($("<option />").attr("value", tag.IDTag).text(tag.NomTag));
    });
    selectTag.change(function () {
        let tagID = selectTag.val();
        tag = tags.find((tag) => tag.IDTag == tagID);
        if (tagID != "" && !allTag.includes(tagID)) {
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
                allTag = allTag.filter((findTag) => findTag != tagID);
            });
            allTag.push(tagID);
            selectTag.before(newTag);
        }
        selectTag.val("");
    });
};

//recupérer tous les utilisateurs
var allAccount = [];
var divInfoCompte = document.getElementById("infoCompte");
$.ajax({
    type: "POST",
    url: "back/account/getAccounts.php",
    data: {},
    success: (data) => {
        allAccount = JSON.parse(data);
        var body = document.getElementById("infoCompte");

        // creates a <table> element and a <tbody> element
        var tbl = document.createElement("table");
        tbl.id = "tabInfoCompte";
        var tblHead = document.createElement("thead");
        var tblBody = document.createElement("tbody");
        row = document.createElement("tr");
        ["Nom", "Prenom", "Email", "Description", "Role", "Etat"].forEach((field, index) => {
            cell = document.createElement("th");
            cell.addEventListener("click", () => {
                sortTable(index);
            });
            cellText = document.createTextNode([field]);
            cell.appendChild(cellText);
            row.appendChild(cell);
        });
        // add the row to the head of the table
        tblHead.appendChild(row);
        // creating all cells
        for (let i = 0; i < allAccount.length; i++) {
            if (allAccount[i]["Role"] == "admin") {
                allAccount[i]["Role"] = "Administrateur";
            } else if (allAccount[i]["Role"] == "ecriture") {
                allAccount[i]["Role"] = "Ecriture";
            } else if (allAccount[i]["Role"] == "invite") {
                allAccount[i]["Role"] = "Invité";
            } else if (allAccount[i]["Role"] == "lecture") {
                allAccount[i]["Role"] = "Lecture";
            }
            if (allAccount[i]["Actif"] == 1 || allAccount[i]["Actif"] == 2) {
                allAccount[i]["Actif"] = "Actif";
            } else if (allAccount[i]["Actif"] == 0) {
                allAccount[i]["Actif"] = "Supendu";
            }
            // creates a table row
            row = document.createElement("tr");
            ["Nom", "Prenom", "Email", "Description", "Role", "Actif"].forEach((field) => {
                cell = document.createElement("td");
                cellText = document.createTextNode(allAccount[i][field]);
                cell.appendChild(cellText);
                row.appendChild(cell);
            });
            // add the row to the end of the table body
            tblBody.appendChild(row);
        }

        // put the <thead> in the <table>
        tbl.appendChild(tblHead);
        // put the <tbody> in the <table>
        tbl.appendChild(tblBody);
        // appends <table> into <body>
        body.appendChild(tbl);
        // sets the border attribute of tbl to 2;
        tbl.setAttribute("border", "2");
    },
});

function checkMdpTemporaire() {
    const checkBox = document.getElementById("mdpTemporaire").checked;
    if (checkBox === true) {
        inputMdp.disabled = true;
        inputMdp.placeholder = "Mot de passe temporaire utilisé";
        inputMdp.value = "";
        inputMdp.style.borderColor = "";
        inputMdp.required = false;
        document.getElementById("labelmdpInput").style.visibility = "hidden";
        mdpCorrect = true;
    } else {
        inputMdp.disabled = false;
        inputMdp.required = true;
        inputMdp.placeholder = "";
        mdpCorrect = false;
    }
}

function checkMdp() {
    let val = inputMdp.value;
    if (val.match(/[0-9]/g) && val.match(/[A-Z]/g) && val.match(/[a-z]/g) && val.match(/[^a-zA-Z\d]/g)) {
        document.getElementById("labelmdpInput").style.visibility = "hidden";
        inputMdp.style.borderColor = "";
        mdpCorrect = true;
    } else {
        document.getElementById("labelmdpInput").style.visibility = "visible";
        inputMdp.style.borderColor = "red";
        mdpCorrect = false;
    }
}

function checkEmail(){
    let InputEmail = document.getElementById("emailCreationCompte").value;
    //RFC2822
    if (InputEmail.match(/[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/g)) {
        emailCorrect = true;
    }
    else{
        emailCorrect= false
    }

}

function tagVisible() {
    if (document.getElementById("selectModifRole").value == "invite") {
        document.getElementById("tagInvite").style.display = "flex";
    } else {
        document.getElementById("tagInvite").style.display = "none";
    }
}

function modifTagInvite() {
    if (document.getElementById("selectChamp").value == "tag") {
        document.getElementById("nouvelleValeur").style.display = "none";
        document.getElementById("labelNouvelleValeur").style.display = "none";
        document.getElementById("selectModifRole").style.display = "none";
        document.getElementById("tagInvite2").style.display = "flex";
        var selectTag2 = $("#boutonAddTagInvite");
        var request = new XMLHttpRequest();
        request.open("get", "back/tag/getTags.php", true);
        request.send();
        request.onload = function () {

            let tags2 = JSON.parse(this.responseText);
            tags2.forEach(function (tag) {
                selectTag2.append($("<option />").attr("value", tag.IDTag).text(tag.NomTag));
            });
            selectTag2.change(function () {
                let tagID2 = selectTag2.val();
                tag = tags2.find((tag) => tag.IDTag == tagID2);
                if (tagID2 != "" && !allTag2.includes(tagID2)) {
                    let newTag2 = $("<div>")
                        .addClass("tag")
                        .attr("data-id", tag.IDTag)
                        .css("background-color", "#" + tag.Couleur);
                    newTag2.html("<p>" + tag.NomTag + "</p>");

                    let deleteTag2 = $("<img>").attr("src", "front/images/close.svg");
                    newTag2.append(deleteTag2);
                    newTag2.css("cursor", "pointer");
                    newTag2.click(() => {
                        newTag2.remove();
                        allTag2 = allTag2.filter((findTag) => findTag != tagID2);
                    });
                    allTag2.push(tagID2);
                    selectTag2.before(newTag2);
                }
                selectTag2.val("");
            });
        };
    } else if (document.getElementById("selectChamp").value == "Role") {
        document.getElementById("nouvelleValeur").style.display = "none";
        document.getElementById("labelNouvelleValeur").style.display = "none";
        document.getElementById("tagInvite2").style.display = "none";
        document.getElementById("selectModifRole").style.display = "flex";
    } else {
        document.getElementById("nouvelleValeur").style.display = "flex";
        document.getElementById("labelNouvelleValeur").style.display = "flex";
        document.getElementById("tagInvite2").style.display = "none";
        document.getElementById("selectModifRole").style.display = "none";
    }
}

function submitModifCompte() {
    if (document.getElementById("emailModifCompte").value && document.getElementById("selectChamp").value) {
        $.ajax({
            type: "POST",
            url: "back/account/updateAccount.php",
            data: { email: document.getElementById("emailModifCompte").value, champ: document.getElementById("selectChamp").value, nouveauRole: document.getElementById("addRole").value, valeur: document.getElementById("nouvelleValeur").value, tags: JSON.stringify(allTag2) },
            success: (data) => {
                if (data == "Succes") {
                    alert.create({
                        content: "Compte modifié",
                        type: "success",
                    });
                } else if (data == "Succes invite") {
                    alert.create({
                        content: "Tags de restriction modifié",
                        type: "success",
                    });
                } else {
                    alert.create({
                        content: "Echec de la modification du compte",
                        type: "error",
                    });
                }
                $(".inputModifCompte").val("");
                document.getElementById("nouvelleValeur").style.display = "flex";
                document.getElementById("labelNouvelleValeur").style.display = "flex";
                document.getElementById("tagInvite2").style.display = "none";
                document.getElementById("selectModifRole").style.display = "none";
            },
        });
    } else {
        alert.create({
            content: "l'un des champs n'est pas respecté",
            type: "error",
        });
    }
}

function submitInfoCompte() {
    if (emailCorrect && document.getElementById("prenomCreationCompte").value && document.getElementById("nomCreationCompte").value && mdpCorrect && document.getElementById("descriptionCreationCompte").value && document.getElementById("selectRole").value) {
        $.ajax({
            type: "POST",
            url: "back/account/signUp.php",
            data: { email: document.getElementById("emailCreationCompte").value, prenom: document.getElementById("prenomCreationCompte").value, nom: document.getElementById("nomCreationCompte").value, motDePasse: document.getElementById("mdpCreationCompte").value, mdpTemporaire: JSON.stringify(document.getElementById("mdpTemporaire").checked), description: document.getElementById("descriptionCreationCompte").value, role: document.getElementById("selectRole").value, tags: JSON.stringify(allTag) },
            success: (data) => {
                if (data.startsWith("<")) {
                    console.error(data);
                } else {
                    alert.create({
                        content: data,
                        type: "success",
                    });
                }
                $(".inputCreationCompte").val("");
            },
        });
    } else {
        alert.create({
            content: "L'un des champs n'est pas valide",
            type: "error",
        });
    }
}

function sortTable(n) {
    var table,
        rows,
        switching,
        i,
        x,
        y,
        shouldSwitch,
        dir,
        switchcount = 0;
    table = document.getElementById("tabInfoCompte");
    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc";
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /* Loop through all table rows (except the
      first, which contains table headers): */
        for (i = 1; i < rows.length - 1; i++) {
            // Start by saying there should be no switching:
            shouldSwitch = false;
            /* Get the two elements you want to compare,
        one from current row and one from the next: */
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /* Check if the two rows should switch place,
        based on the direction, asc or desc: */
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /* If a switch has been marked, make the switch
        and mark that a switch has been done: */
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            // Each time a switch is done, increase this count by 1:
            switchcount++;
        } else {
            /* If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again. */
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}
