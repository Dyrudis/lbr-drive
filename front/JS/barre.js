(function (){

    let tagTab = [];

    var request = new XMLHttpRequest();
    request.open("get", "back/loadBarre.php", true);
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
        let formData = new FormData();
        tagTab.sort();
        if (tagTab.length > 0) formData.append("tags", JSON.stringify(tagTab));

        let request = new XMLHttpRequest();
        request.open("post", "back/loadGallery.php", true);
        request.send(formData);
        request.onload = displayGallery;
    }

})();