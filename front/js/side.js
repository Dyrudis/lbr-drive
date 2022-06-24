(function () {
    let tagTab = [];
    let userToggle = false;
    let tagFilter = "Intersection";
    let typeFilter = "tout-type";
    let trashToggle = false;
    // Get all the users
    var allAccount = [];
    $.ajax({
        type: "POST",
        url: "back/account/getAccounts.php",
        data: {filter : true},
        success: (data) => {
            console.log(data);
            allAccount = JSON.parse(data);
            let selectAccount = $("#select-utilisateur");
            allAccount.forEach(info =>{
                selectAccount.append($("<option />").attr("value",info.IDUtilisateur).text(info.Nom + " " + info.Prenom))
            })
            selectAccount.change(() =>{
                myFilesToggler.classList.remove("active");
                userToggle = false;
                sendFormData();
            })
            
        },
    });

    var request = new XMLHttpRequest();
    request.open("get", "back/tag/getTags.php", true);
    request.send();
    request.onload = displayBarre;

    function displayBarre() {
        allTags = JSON.parse(this.responseText);
        allTags.forEach((tag) => {
            displayTag(tag);
            $("#selection-multiple-select").append($("<option>").attr("value", tag.IDTag).text(tag.NomTag).css("background-color", tag.Couleur));
        });
    }

    function displayTag(tag) {
        let listCategories = document.getElementById("liste-categories");
        //Check if listCategories has child with id = tag
        let child = document.getElementById(tag.NomCategorie);
        if (child == null) {
            let newCategory = document.createElement("div");
            newCategory.id = tag.NomCategorie;
            newCategory.className = "category";
            newCategory.innerHTML = "<p>" + tag.NomCategorie + "</p>";
            newCategory.innerHTML += "<div class='taglist'></div>";
            listCategories.appendChild(newCategory);
        }

        let listToAppend = document.getElementById(tag.NomCategorie).getElementsByClassName("taglist")[0];
        let newTag = document.createElement("div");
        newTag.className = "tag";
        newTag.innerHTML = "<p>" + tag.NomTag + "</p>";
        newTag.style.backgroundColor = "#" + tag.Couleur;
        listToAppend.appendChild(newTag);

        newTag.addEventListener("click", function () {
            //Check if tag is already selected
            if (tagTab.includes(tag.IDTag)) {
                return;
            }

            //copy newtag
            let newTagCopy = newTag.cloneNode(true);
            newTagCopy.classList.add("undraggable");
            newTagCopy.innerHTML += "<img src='front/images/close.svg'/>";

            //add tag to tagTab
            tagTab.push(tag.IDTag);

            //append newTag
            document.getElementById("gallery-header").appendChild(newTagCopy);

            //adds a listener to cancel the tag selection
            newTagCopy.addEventListener("click", function () {
                document.getElementById("gallery-header").removeChild(newTagCopy);
                tagTab.splice(tagTab.indexOf(tag.IDTag), 1);

                loadGalleryWithTags();
            });

            loadGalleryWithTags();
        });
    }

    function loadGalleryWithTags() {
        tagTab.sort();
        sendFormData();
    }

    let myFilesToggler = document.getElementById("toggle-mes-fichiers");
    myFilesToggler.addEventListener("click", function () {
        //Si recherche par fichiers possédés non-actif -> activer
        if (!myFilesToggler.classList.contains("active")) {
            $("#select-utilisateur").val("");
            myFilesToggler.classList.add("active");
            userToggle = true;
        }
        //Si recherche par fichiers possédés actif -> désactiver
        else {
            myFilesToggler.classList.remove("active");
            userToggle = false;
        }
        sendFormData();
    });

    let triTagToggler = document.getElementById("toggle-type-tri-tag");
    triTagToggler.addEventListener("click", function () {
        //Si recherche par intersection actif -> switch union
        if (triTagToggler.classList.contains("Intersection")) {
            triTagToggler.classList.remove("Intersection");
            triTagToggler.classList.add("Union");
            triTagToggler.innerText = "Union";
            tagFilter = "Union";
        }
        //Si recherche par union actif -> switch intersection
        else {
            triTagToggler.classList.remove("Union");
            triTagToggler.classList.add("Intersection");
            triTagToggler.innerText = "Intersection";
            tagFilter = "Intersection";
        }
        sendFormData();
    });

    let fileTypeToggler = document.getElementById("toggle-type-fichier");
    fileTypeToggler.addEventListener("click", function () {
        //Si recherche par tout type de fichiers -> recherche seulement video
        if (fileTypeToggler.classList.contains("tout-type")) {
            fileTypeToggler.classList.remove("tout-type");
            fileTypeToggler.classList.add("video");
            typeFilter = "video";
            fileTypeToggler.innerText = "Vidéo";
        }
        //Si recherche par video -> recherche seulement image
        else if (fileTypeToggler.classList.contains("video")) {
            fileTypeToggler.classList.remove("video");
            fileTypeToggler.classList.add("image");
            typeFilter = "image";
            fileTypeToggler.innerText = "Image";
        }
        //Si recherche par image -> recherche par tout type de fichiers
        else {
            fileTypeToggler.classList.remove("image");
            fileTypeToggler.classList.add("tout-type");
            typeFilter = "tout-type";
            fileTypeToggler.innerText = "Image/Vidéo";
        }
        sendFormData();
    });

    let trashToggler = document.getElementById("toggle-corbeille");
    trashToggler.addEventListener("click", function () {
        //Si recherche par fichiers corbeille non-actif -> activer
        if (!trashToggler.classList.contains("active")) {
            trashToggler.classList.add("active");
            trashToggle = true;
            // Cache la selection multiple
            $("#selection-multiple-toggle").prev().hide();
            $("#selection-multiple-toggle").hide();
        }
        //Si recherche par fichiers corbeille actif -> désactiver
        else {
            trashToggler.classList.remove("active");
            trashToggle = false;
            // Affiche la selection multiple
            $("#selection-multiple-toggle").prev().show();
            $("#selection-multiple-toggle").show();
        }
        sendFormData();
    });

    //Fonction qui selon les variables globales fait la requete souhaitée
    function sendFormData() {
        let formData = new FormData();
        let selectUser = document.getElementById("select-utilisateur").value;

        //Ajout des tags dans le formulaire
        if (tagTab.length > 0) formData.append("tags", JSON.stringify(tagTab));

        //Defini si la recherche concerne seulement les fichiers possédés
        if(selectUser==""){
            if (userToggle) formData.append("user", -1);
        }
        else{
            formData.append("user", selectUser);
        }
        

        //Defini le type de recherche de tags
        if (tagFilter == "Union") formData.append("typeTriTag", "Union");

        //Defini le type de fichier recherché
        if (typeFilter == "tout-type") formData.append("fileType", "tout-type");
        else if (typeFilter == "video") formData.append("fileType", "video");
        else formData.append("fileType", "image");

        //Defini si la recherche concerne les fichiers de la corbeille
        formData.append("corbeille", trashToggle);

        let request = new XMLHttpRequest();
        request.open("post", "back/file/getFiles.php", true);
        request.send(formData);
        request.onload = displayGallery;
    }
})();
