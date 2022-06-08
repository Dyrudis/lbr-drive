(function (){

    let tagTab = [];
    let userToggle = false;
    let typeTriTag = "Intersection";
    let fileTypeSearching = "tout-type";

    var request = new XMLHttpRequest();
    request.open("get", "back/tags/getTags.php", true);
    request.send();
    request.onload = displayBarre;
    


    function displayBarre() {

        allTags = JSON.parse(this.responseText);
        allTags.forEach(element => {
            displayTag(element);
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
        newTag.style.backgroundColor = "#"+tag.Couleur;
        listToAppend.appendChild(newTag);

        newTag.addEventListener("click", function() {

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
            newTagCopy.addEventListener("click", function() {
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

    myFilesToggler = document.getElementById("toggle-mes-fichiers");
    myFilesToggler.addEventListener("click", function() {

        //Si recherche par fichiers possédés non-actif -> activer
        if (!myFilesToggler.classList.contains("active")) {
            userToggle = true;
            myFilesToggler.classList.add("active");
            
            sendFormData();
        }
        //Si recherche par fichiers possédés actif -> désactiver
        else {
            userToggle = false;
            myFilesToggler.classList.remove("active");

            sendFormData();
        }

    });

    triTagToggler = document.getElementById("toggle-type-tri-tag");
    triTagToggler.addEventListener("click", function() {

        //Si recherche par intersection actif -> switch union
        if (triTagToggler.classList.contains("Intersection")) {
            
            triTagToggler.classList.remove("Intersection");
            triTagToggler.classList.add("Union");
            triTagToggler.innerText = "Union";
            typeTriTag = "Union";
        }
        //Si recherche par union actif -> switch intersection
        else {
            triTagToggler.classList.remove("Union");
            triTagToggler.classList.add("Intersection");
            triTagToggler.innerText = "Intersection";
            typeTriTag = "Intersection";
        }
        sendFormData();
    });

    fileTypeToggler = document.getElementById("toggle-type-fichier");
    fileTypeToggler.addEventListener("click", function() {

        //Si recherche par tout type de fichiers -> recherche seulement video
        if (fileTypeToggler.classList.contains("tout-type")) {
            fileTypeToggler.classList.remove("tout-type");
            fileTypeToggler.classList.add("video");
            fileTypeSearching = "video";
            fileTypeToggler.innerText = "Vidéo";
        }
        //Si recherche par video -> recherche seulement image
        else if (fileTypeToggler.classList.contains("video")) {
            fileTypeToggler.classList.remove("video");
            fileTypeToggler.classList.add("image");
            fileTypeSearching = "image";
            fileTypeToggler.innerText = "Image";
        }
        //Si recherche par image -> recherche par tout type de fichiers
        else {
            fileTypeToggler.classList.remove("image");
            fileTypeToggler.classList.add("tout-type");
            fileTypeSearching = "tout-type";
            fileTypeToggler.innerText = "Image/Vidéo";
        }
        sendFormData();
    });

    //Fonction qui selon les variables globales fait la requete souhaitée
    function sendFormData() {
    
        let formData = new FormData();

        //Ajout des tags dans le formulaire
        if (tagTab.length > 0) formData.append("tags", JSON.stringify(tagTab));

        //Defini si la recherche concerne seulement les fichiers possédés
        if (userToggle) formData.append("user", "true");

        //Defini le type de recherche de tags
        if (typeTriTag == "Union") formData.append("typeTriTag", "Union");

        //Defini le type de fichier recherché
        if (fileTypeSearching == "tout-type") formData.append("fileType", "tout-type");
        else if (fileTypeSearching == "video") formData.append("fileType", "video");
        else formData.append("fileType", "image");
    
        let request = new XMLHttpRequest();
        request.open("post", "back/indexLoader/loadGallery.php", true);
        request.send(formData);
        request.onload = displayGallery;
    }


})();