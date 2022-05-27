(function (){

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
        let newTag = document.createElement("p");
        newTag.className = "tag";
        newTag.innerHTML = tag.NomTag;
        newTag.style.backgroundColor = "#"+tag.Couleur;
        listToAppend.appendChild(newTag);


    }
})();