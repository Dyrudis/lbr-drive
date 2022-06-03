(function () {
    displayCategories();
    displayTags();

    function displayCategories() {
        // Récupération des catégories
        var request = new XMLHttpRequest();
        request.open("get", "back/tags/getCategories.php", true);
        request.send();
        request.onload = function () {
            console.log(this.responseText);
            console.log(JSON.parse(this.responseText));

            let categories = JSON.parse(this.responseText);
            categories.forEach(function (category) {
                displayCategory(category);
            });
        };
    }

    function displayTags() {
        // Récupération des tags
        var request = new XMLHttpRequest();
        request.open("get", "back/tags/getTags.php", true);
        request.send();
        request.onload = function () {
            console.log(JSON.parse(this.responseText));

            let tags = JSON.parse(this.responseText);
            tags.forEach(function (tag) {
                displayTag(tag);
            });
        };
    }

    function displayCategory(category) {
        let listCategories = $("#categoryContent");

        let newCategory = $("<div>").addClass("container");
        let preview = $("<div>").addClass("preview");
        let title = $("<p>").text(category.NomCategorie);
        let tagSample = $("<div>")
            .addClass("tag")
            .text("Exemple")
            .css("background-color", "#" + category.Couleur);
        preview.append(title);
        preview.append(tagSample);
        newCategory.append(preview);

        let form = $("<form>");
        let input = $("<input>").attr("type", "text").attr("value", category.NomCategorie);
        let color = $("<input>")
            .attr("type", "color")
            .attr("value", "#" + category.Couleur);
        let confirm = $("<input>").attr("type", "button").attr("value", "Confirmer");
        let remove = $("<input>").attr("type", "button").attr("value", "Supprimer");
        form.append(input);
        form.append(color);
        form.append(confirm);
        form.append(remove);
        newCategory.append(form);

        listCategories.append(newCategory);
    }

    function displayTag(tag) {
        let listTags = $("#tagContent");

        let newTag = $("<div>").addClass("container");
        let preview = $("<p>")
            .text(tag.NomTag)
            .addClass("tag")
            .css("background-color", "#" + tag.Couleur);
        newTag.append(preview);

        let form = $("<form>");
        let input = $("<input>").attr("type", "text").attr("value", tag.NomTag);
        let catInput = $("<select>");

        let confirm = $("<input>").attr("type", "button").attr("value", "Confirmer");
        let remove = $("<input>").attr("type", "button").attr("value", "Supprimer");
        form.append(input);
        form.append(catInput);
        form.append(confirm);
        form.append(remove);
        newTag.append(form);

        listTags.append(newTag);
    }
})();
