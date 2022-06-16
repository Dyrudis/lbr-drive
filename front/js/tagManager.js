(function () {
    let categories = [];
    let tags = [];

    // Récupération des catégories
    var request = new XMLHttpRequest();
    request.open("get", "back/tag/getCategories.php", true);
    request.send();
    request.onload = function () {
        try {
            categories = JSON.parse(this.responseText);
        } catch {
            console.error(this.responseText);
            return;
        }

        categories.forEach(function (category) {
            displayCategory(category);
            $("#categorySelected").append("<option value='" + category.IDCategorie + "'>" + category.NomCategorie + "</option>");
        });

        // Récupération des tags
        var request = new XMLHttpRequest();
        request.open("get", "back/tag/getTags.php", true);
        request.send();
        request.onload = function () {
            try {
                tags = JSON.parse(this.responseText);
            } catch {
                console.error(this.responseText);
                return;
            }

            tags.forEach(function (tag) {
                displayTag(tag, categories);
            });
        };
    };

    function displayCategory(category) {
        let listCategories = $("#categoryContent");

        let newCategory = $("<div>").addClass("container");
        let preview = $("<div>").addClass("preview");
        let title = $("<p>").text(category.NomCategorie).addClass("title");
        let tagSample = $("<div>")
            .addClass("tag")
            .text("Exemple")
            .css("background-color", "#" + category.Couleur);
        preview.append(title);
        preview.append(tagSample);
        newCategory.append(preview);

        let form = $("<form>");
        let input = $("<input>").attr("type", "text").attr("value", category.NomCategorie).addClass("textInput");
        let color = $("<input>")
            .attr("type", "color")
            .attr("value", "#" + category.Couleur)
            .addClass("colorInput");
        let confirm = $("<input>").attr("type", "button").attr("value", "Confirmer").addClass("confirmInput");
        let remove = $("<input>").attr("type", "button").attr("value", "Supprimer").addClass("removeInput");
        form.append(input);
        form.append(color);
        form.append(confirm);
        form.append(remove);
        newCategory.append(form);

        listCategories.append(newCategory);

        input.on("input", function () {
            title.text(input.val() || category.NomCategorie);
        });

        color.on("input", function () {
            tagSample.css("background-color", color.val());
        });

        confirm.on("click", function () {
            $.ajax({
                url: "back/tag/updateCategory.php",
                type: "POST",
                data: {
                    IDCategorie: category.IDCategorie,
                    name: input.val(),
                    color: color.val().substring(1),
                },
                success: function (data) {
                    if (data == "Modification nulle") {
                        // Pas de modification
                    }
                    else if (data != "OK") {
                        console.error(data);
                        alert(data);
                        location.reload();
                    } else {
                        location.reload();
                    }
                },
            });
        });

        remove.on("click", function () {
            if (window.confirm('Êtes-vous sûr de vouloir supprimer la catégorie "' + category.NomCategorie + '" ?')) {
                $.ajax({
                    url: "back/tag/deleteCategory.php",
                    type: "POST",
                    data: {
                        IDCategorie: category.IDCategorie,
                    },
                    success: function (data) {
                        if (data != "OK") {
                            console.error(data);
                        } else {
                            location.reload();
                        }
                    },
                });
            }
        });
    }

    function displayTag(tag, categories) {
        let listTags = $("#tagContent");

        let newTag = $("<div>").addClass("container");

        let preview = $("<div>").addClass("preview");
        let tagPreview = $("<p>")
            .text(tag.NomTag)
            .addClass("tag")
            .css("background-color", "#" + tag.Couleur);
        preview.append(tagPreview);
        newTag.append(preview);

        let form = $("<form>");
        let input = $("<input>").attr("type", "text").attr("value", tag.NomTag).addClass("textInput");
        let catInput = $("<select>").addClass("selectInput");
        categories.forEach(function (category) {
            let option = $("<option>").attr("value", category.IDCategorie).text(category.NomCategorie);
            if (category.IDCategorie == tag.IDCategorie) {
                option.attr("selected", "selected");
            }
            catInput.append(option);
        });
        let confirm = $("<input>").attr("type", "button").attr("value", "Confirmer").addClass("confirmInput");
        let remove = $("<input>").attr("type", "button").attr("value", "Supprimer").addClass("removeInput");
        form.append(input);
        form.append(catInput);
        form.append(confirm);
        form.append(remove);
        newTag.append(form);

        listTags.append(newTag);

        input.on("input", function () {
            tagPreview.text(input.val() || tag.NomTag);
        });

        catInput.on("change", function () {
            tagPreview.css("background-color", "#" + categories.find((e) => e.IDCategorie == catInput.val()).Couleur);
        });

        confirm.on("click", function () {
            $.ajax({
                url: "back/tag/updateTag.php",
                type: "POST",
                data: {
                    IDTag: tag.IDTag,
                    name: input.val(),
                    IDCategorie: catInput.val(),
                },
                success: function (data) {
                    if (data == "Modification nulle") {
                        // Pas de modification
                    }
                    else if (data != "OK") {
                        console.error(data);
                        alert(data);
                        location.reload();
                    } else {
                        location.reload();
                    }
                },
            });
        });

        remove.on("click", function () {
            if (window.confirm('Êtes-vous sûr de vouloir supprimer le tag "' + tag.NomTag + '" ?')) {
                $.ajax({
                    url: "back/tag/deleteTag.php",
                    type: "POST",
                    data: {
                        IDTag: tag.IDTag,
                    },
                    success: function (data) {
                        if (data != "OK") {
                            console.error(data);
                        } else {
                            location.reload();
                        }
                    },
                });
            }
        });
    }

    // Create a new category
    $("#createCategory").click(function () {
        let name = $("#categoryInput").val();
        let color = $("#categoryColor").val();

        // Check if the fields are empty
        if (name == "" || color == "") {
            return;
        }

        // Check if the color is valid
        if (!color.match(/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/)) {
            return;
        }

        // Delete the '#' from the color
        color = color.substring(1);

        // Ajax request to create the category
        $.ajax({
            url: "back/tag/createCategory.php",
            type: "POST",
            data: {
                name: name,
                color: color,
            },
            success: function (data) {
                if (data != "OK") {
                    console.error(data);
                    alert("Catégorie déjà existante");
                } else {
                    location.reload();
                }
            },
        });
    });

    // Create a new tag
    $("#createTag").click(function () {
        let name = $("#tagInput").val();
        let IDCategorie = $("#categorySelected").val();

        // Check if the fields are empty
        if (name == "" || IDCategorie == "") {
            return;
        }

        // Ajax request to create the tag
        $.ajax({
            url: "back/tag/createTag.php",
            type: "POST",
            data: {
                name: name,
                IDCategorie: IDCategorie,
            },
            success: function (data) {
                if (data != "OK") {
                    console.error(data);
                    alert("Tag déjà existant");
                } else {
                    location.reload();
                }
            },
        });
    });
})();
