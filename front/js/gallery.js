// Get all the tags
var allTags = [];
var request = new XMLHttpRequest();
request.open("get", "back/tag/getTags.php", true);
request.send();
request.onload = function () {
    allTags = JSON.parse(this.responseText);

    // Get all the files
    var request = new XMLHttpRequest();
    request.open("get", "back/file/getFiles.php", true);
    request.send();
    request.onload = displayGallery;
};

function displayGallery() {
    $("#gallery").empty();

    // If the response is a php error, print it
    try {
        allFiles = JSON.parse(this.responseText);
    } catch (e) {
        console.error(this.responseText);
        return;
    }

    allFiles.forEach((file) => {
        displayFile(file);
    });
}

function displayFile(file) {
    let IDTags = file.IDTags.split(",");
    let NomTags = file.NomTags.split(",");
    let CouleurTags = file.CouleurTags.split(",");

    // Create an array of objects with the tags
    file.Tags = [];
    for (let i = 0; i < IDTags.length; i++) {
        file.Tags.push({
            ID: IDTags[i],
            Nom: NomTags[i],
            Couleur: CouleurTags[i],
        });
    }

    delete file.IDTags;
    delete file.NomTags;
    delete file.CouleurTags;

    let path = "./upload/" + file.IDFichier + "." + file.Extension;

    let container = $("<div>").addClass("file-container");
    let preview;
    if (file.Type == "image") {
        preview = $("<img />").attr("src", path);
        preview.on("load", masonry);
    } else {
        preview = $("<video />");
        preview.on("loadeddata", masonry);
        preview[0].currentTime = file.Miniature;
        let source = $("<source />")
            .attr("src", path)
            .attr("type", file.Type + "/" + file.Extension);
        preview.append(source);
    }
    preview.addClass("file-preview");
    let hover = $("<div>").addClass("file-hover");
    let hoverTags = $("<div>").addClass("file-hover-tags");
    file.Tags.forEach((tag) => {
        let tagElem = $("<div>")
            .addClass("tag")
            .html("<p>" + tag.Nom + "</p>")
            .css("background-color", "#" + tag.Couleur)
            .attr("data-id", tag.ID);
        hoverTags.append(tagElem);
    });
    let title = $("<div>")
        .addClass("file-hover-title")
        .html("<p>" + file.NomFichier + "</p>")
        .attr("title", file.NomFichier);
    let author = $("<div>")
        .addClass("file-hover-author")
        .attr("title", "de " + file.Prenom + " " + file.Nom + ", " + file.Date);
    if (file.Corbeille) {
        author.html("<strong>" + daysUntil30Days(file.Corbeille) + "</strong>");
    } else {
        author.html("de " + file.Prenom + " " + file.Nom + ", " + file.Date);
    }
    let info = $("<div>")
        .addClass("file-hover-info")
        .text(bytesToSize(file.Taille) + (file.Duree != "0" ? " - " + formatSeconds(file.Duree) : ""));

    // All the actions
    let actions = $("<div>").addClass("file-hover-actions");

    let downloadFile = $("<img>").attr("src", "front/images/download.png").addClass("undraggable");
    let deleteFile = $("<img>").attr("src", "front/images/delete.svg").addClass("undraggable");
    let restoreFile = $("<img>").attr("src", "front/images/restore.png").addClass("undraggable");
    let addTag = $("<select>");
    addTag.append($("<option>").attr("value", "0").attr("selected", "selected").attr("disabled", "disabled").text("+ Tag"));
    allTags.forEach((tag) => {
        if (tag.IDTag != 0) {
            addTag.append(
                $("<option>")
                    .attr("value", tag.IDTag)
                    .text(tag.NomTag)
                    .css({ "background-color": "#" + tag.Couleur, color: "white" })
            );
        }
    });

    actions.append(downloadFile); // FOR EVERYONE
    if (file.isEditable) {
        // ONLY FOR AUTHOR OR ADMIN
        if (file.Corbeille) actions.append(restoreFile);
        actions.append(deleteFile);
        actions.append(addTag);
    }

    hover.append(hoverTags);
    hover.append(title);
    hover.append(author);
    hover.append(info);
    hover.append(actions);

    container.append(preview);
    container.append(hover);

    $("#gallery").append(container);

    /*-------------------------------------*\
    |   Implementation of all the actions   |
    \*-------------------------------------*/

    // On Right Click : Display actions
    container.contextmenu((e) => {
        e.preventDefault(); // Prevent the browser from opening the context menu

        // If the container has the class selected
        if (container.hasClass("selected")) {
            hideActions(container, file);
        } else {
            displayActions(container, file);
        }
    });

    // On Left Click : Display preview
    preview.click(displayInFullscreen);

    // On left Click on multiple selection mode : Select file
    container.click(() => toggleSelectFile(container, file));

    // Download button
    downloadFile.click(function () {
        const a = document.createElement("a");
        a.style.display = "none";
        a.href = path;
        a.download = file.NomFichier + "." + file.Extension;
        a.click();
    });

    // Delete button
    deleteFile.click(function () {
        // The file is not in the trash
        if (!file.Corbeille) {
            if (confirm('Voulez-vous vraiment déplacer le fichier "' + file.NomFichier + '" à la corbeille ?')) {
                let formData = new FormData();
                formData.append("IDFichier", file.IDFichier);

                let request = new XMLHttpRequest();
                request.open("post", "back/file/suspendFile.php", true);
                request.send(formData);
                request.onload = function () {
                    if (this.responseText == "OK") {
                        container.remove();
                        masonry();
                    } else {
                        alert.create({
                            content: "Action impossible",
                            type: "error",
                        });
                    }
                };
            }
        }
        // The file is in the trash
        else {
            if (confirm('Voulez-vous vraiment supprimer définitivement le fichier "' + file.NomFichier + '" ?')) {
                let formData = new FormData();
                formData.append("IDFichier", file.IDFichier);

                let request = new XMLHttpRequest();
                request.open("post", "back/file/deleteFile.php", true);
                request.send(formData);
                request.onload = function () {
                    if (this.responseText == "OK") {
                        container.remove();
                        masonry();
                    } else {
                        alert.create({
                            content: "Action impossible",
                            type: "error",
                        });
                    }
                };
            }
        }
    });

    // Restore button
    restoreFile.click(function () {
        if (confirm('Voulez-vous vraiment restaurer le fichier "' + file.NomFichier + '" ?')) {
            let formData = new FormData();
            formData.append("IDFichier", file.IDFichier);

            let request = new XMLHttpRequest();
            request.open("post", "back/file/restoreFile.php", true);
            request.send(formData);
            request.onload = function () {
                if (this.responseText == "OK") {
                    container.remove();
                    masonry();
                } else {
                    alert.create({
                        content: "Action impossible",
                        type: "error",
                    });
                }
            };
        }
    });

    // Add tag button
    addTag.change(function () {
        let tagID = addTag.val();

        // if the tag is already in the file
        if (container.find(".tag[data-id='" + tagID + "']").length > 0) {
            // Reset the select
            addTag.val(0);
            return;
        }

        tag = allTags.find((tag) => tag.IDTag == tagID);
        addTagToFile(file.IDFichier, tagID);

        let newTag = $("<div>")
            .addClass("tag")
            .attr("data-id", tagID)
            .css("background-color", "#" + tag.Couleur);
        newTag.html("<p>" + tag.NomTag + "</p>");

        let deleteTag = $("<img>").attr("src", "front/images/close.svg");
        newTag.append(deleteTag);
        newTag.css("cursor", "pointer");
        newTag.click(() => {
            deleteTagFromFile(file.IDFichier, tagID);
            newTag.remove();

            // If there is no tag, add the tag div with data-id = 0
            if (container.find(".tag").length == 0) {
                let tag = $("<div>")
                    .addClass("tag")
                    .attr("data-id", "0")
                    .css("background-color", "#" + allTags.find((tag) => tag.IDTag == 0).Couleur);
                tag.html("<p>Aucun tag</p>");
                container.find(".file-hover-tags").append(tag);
            }
        });
        container.find(".file-hover-tags").append(newTag);

        // Remove the tag div with data-id = 0
        container.find(".file-hover-tags").find("[data-id='0']").remove();

        // Reset the select
        addTag.val(0);
    });
}

function bytesToSize(bytes) {
    if (bytes == 0) {
        return "0 Octet";
    }
    let i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024))),
        sizes = ["Octets", "Ko", "Mo", "Go", "To"];
    return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
}

// Convert seconds to MM:SS or HH:MM:SS
function formatSeconds(s) {
    let sec_num = parseInt(s, 10);
    let hours = Math.floor(sec_num / 3600);
    let minutes = Math.floor((sec_num - hours * 3600) / 60);
    let seconds = sec_num - hours * 3600 - minutes * 60;

    if (seconds < 10) {
        seconds = "0" + seconds;
    }
    if (hours > 0) {
        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        return hours + ":" + minutes + ":" + seconds;
    } else {
        return minutes + ":" + seconds;
    }
}

function daysUntil30Days(date) {
    if (date == null) return "";
    let dateToday = new Date();
    let dateAfter30Days = new Date(new Date(date).getTime() + 30 * 24 * 60 * 60 * 1000);
    let diff = dateAfter30Days.getTime() - dateToday.getTime();
    console.log(dateToday.getDate() + "   " + new Date("2020-06-10").getDate());
    return Math.round(diff / (1000 * 60 * 60 * 24)) + " jour(s) avant suppression !";
}

function displayInFullscreen(event) {
    if (multiselection) return;

    let preview = event.currentTarget.cloneNode(true); //.children[0].cloneNode(true);
    // Select "#fullscreen-container" or create it if it doesn't exist
    let container = $("#fullscreen-container");
    if (container.length == 0) {
        container = $("<div>").attr("id", "fullscreen-container");
        $("body").append(container);
    }
    // If the preview is a video, add controls
    if (preview.tagName == "VIDEO") {
        preview.setAttribute("controls", "controls");
        preview.style.backgroundColor = "black";
    }
    container.append(preview);
    preview.style.width = "auto";
    preview.style.height = "auto";
    container.click(function (e) {
        if (e.target !== this) return;
        container.remove();
    });
}

function displayActions(container, file) {
    // Remove the class from all other containers
    $(".file-container.selected").each(function () {
        hideActions($(this));
    });
    container.addClass("selected");

    // Only allow to delete tag/edit title if the file is editable
    if (file.isEditable) {
        // Select all tags except the one with data-id = 0
        let tags = container.find(".tag").not("[data-id='0']");
        let deleteTag = $("<img>").attr("src", "front/images/close.svg");
        tags.append(deleteTag);
        tags.css("cursor", "pointer");
        tags.click(function () {
            deleteTagFromFile(file.IDFichier, $(this).attr("data-id"));
            $(this).remove();

            // If there is no tag, add the tag div with data-id = 0
            if (container.find(".tag").length == 0) {
                let tag = $("<div>")
                    .addClass("tag")
                    .attr("data-id", "0")
                    .css("background-color", "#" + allTags.find((tag) => tag.IDTag == 0).Couleur);
                tag.html("<p>Aucun tag</p>");
                container.find(".file-hover-tags").append(tag);
            }
        });

        let editTitle = $("<img>").attr("src", "front/images/edit.svg").addClass("edit-title pointerOnHover undraggable");
        container.find(".file-hover-title").append(editTitle);
        container.find(".file-hover-title").css("cursor", "text");
        editTitle.click(function () {
            container.find(".file-hover-title > img").remove();
            let title = container.find(".file-hover-title > p");
            let input = $("<input>").attr("type", "text").attr("value", title.text()).addClass("edit-title-input");
            title.replaceWith(input);
            input.focus();
            input.select();
            input.change(function () {
                let newTitle = input.val();
                if (newTitle.length > 0) {
                    editFileTitle(file.IDFichier, newTitle);
                    title.text(newTitle);
                    input.replaceWith(title);
                } else {
                    input.replaceWith(title);
                }
                hideActions(container);
            });
        });
    }
}

function hideActions(container, file) {
    container.removeClass("selected");

    tags = container.find(".tag");
    tags.find("img").remove();
    tags.css("cursor", "default");
    tags.off("click");

    container.find(".edit-title").remove();
    container.find(".file-hover-title").off("click");
    container.find(".file-hover-title").css("cursor", "default");

    // If there is still an input, trigger the change event to save the title
    let input = container.find(".edit-title-input");
    if (input.length > 0) {
        input.change();
    }
}

function deleteTagFromFile(IDFichier, IDTag) {
    let formData = new FormData();
    formData.append("IDFichier", IDFichier);
    formData.append("IDTag", IDTag);

    let request = new XMLHttpRequest();
    request.open("post", "back/file/deleteTag.php", true);
    request.send(formData);
    request.onload = function () {
        if (this.responseText != "OK") {
            alert.create({
                content: "Action impossible",
                type: "error",
            });
        }
    };
}

function addTagToFile(IDFichier, IDTag) {
    let formData = new FormData();
    formData.append("IDFichier", IDFichier);
    formData.append("IDTag", IDTag);

    let request = new XMLHttpRequest();
    request.open("post", "back/file/addTag.php", true);
    request.send(formData);
    request.onload = function () {
        if (this.responseText != "OK") {
            alert.create({
                content: "Action impossible",
                type: "error",
            });
            return false;
        } else {
            return true;
        }
    };
}

function editFileTitle(IDFichier, newTitle) {
    let formData = new FormData();
    formData.append("IDFichier", IDFichier);
    formData.append("NomFichier", newTitle);

    let request = new XMLHttpRequest();
    request.open("post", "back/file/updateTitle.php", true);
    request.send(formData);
    request.onload = function () {
        if (this.responseText != "OK") {
            alert.create({
                content: "Action impossible",
                type: "error",
            });
        }
    };
}

/* Selection multiple */

let selectedFiles = [];
let multiselection = false;

let selectionMultipleToggler = $("#selection-multiple-toggle");
selectionMultipleToggler.click(function () {
    if (selectionMultipleToggler.hasClass("active")) {
        selectionMultipleToggler.removeClass("active").text("Désactivé");
        $("#selection-multiple").css("display", "none");
        multiselection = false;
        $(".file-container").each(function () {
            unselectFile($(this));
        });
    } else {
        selectionMultipleToggler.addClass("active").text("Activé");
        $("#selection-multiple").css("display", "block");
        multiselection = true;
    }
});

function toggleSelectFile(container, file) {
    if (multiselection == false) return;

    if (container.hasClass("mutliselected")) {
        unselectFile(container, file);
    } else {
        selectFile(container, file);
    }
    updateSize();
}

function selectFile(container, file) {
    container.addClass("mutliselected");
    selectedFiles.push(file);
}

function unselectFile(container, file) {
    container.removeClass("mutliselected");
    selectedFiles.splice(selectedFiles.indexOf(file), 1);
}

function updateSize() {
    let sum = 0;
    selectedFiles.forEach((file) => {
        sum += parseInt(file.Taille);
    });

    $("#selection-multiple-size").text(bytesToSize(sum));
}

//ajout du tag pour tous les fichiers selectionnés
function addTagAll() {
    selectedFiles.forEach((file) => {
        let formData = new FormData();
        formData.append("IDFichier", file.IDFichier);
        formData.append("IDTag", document.getElementById("selection-multiple-select").value);

        let request = new XMLHttpRequest();
        request.open("post", "back/file/addTag.php", true);
        request.send(formData);
        request.onload = function () {
            if (this.responseText != "OK") {
                alert.create({
                    content: "Action impossible",
                    type: "error",
                });
                return false;
            } else {
                alert.create({
                    content: "Tag ajouté aux fichiers sélectionnés",
                    type: "success",
                });
                location.reload();
                return true;
            }
        };
    });
}

//suppression du tag pour tous les fichiers selectionnés
function deleteTagAll() {
    selectedFiles.forEach((file) => {
        let formData = new FormData();
        formData.append("IDFichier", file.IDFichier);
        formData.append("IDTag", document.getElementById("selection-multiple-select").value);

        let request = new XMLHttpRequest();
        request.open("post", "back/file/deleteTag.php", true);
        request.send(formData);
        request.onload = function () {
            if (this.responseText != "OK") {
                alert.create({
                    content: "Action impossible",
                    type: "error",
                });
                return false;
            } else {
                alert.create({
                    content: "Tag supprimé aux fichiers sélectionnés",
                    type: "success",
                });
                location.reload();
                return true;
            }
        };
    });
}

//download tous les fichiers selectionnés
function downloadAll() {
    selectedFiles.forEach((file) => {
        const a = document.createElement("a");
        a.style.display = "none";
        a.href = "./upload/" + file.IDFichier + "." + file.Extension;
        a.download = file.NomFichier + "." + file.Extension;
        a.click();
    });
}

//déplacer tous les fichiers selectionnés dans la corbeille
function deleteAll() {
    if (confirm("Voulez-vous vraiment supprimer les fichiers sélectionnés ?")) {
        selectedFiles.forEach((file) => {
            let formData = new FormData();
            formData.append("IDFichier", file.IDFichier);

            let request = new XMLHttpRequest();
            request.open("post", "back/file/suspendFile.php", true);
            request.send(formData);
            request.onload = function () {
                if (this.responseText == "OK") {
                    location.reload();
                } else {
                    alert.create({
                        content: "Action impossible",
                        type: "error",
                    });
                }
            };
        });
    }
}

$("#menuToggle").click(() => {
    $("#barre").toggleClass("visible");
    masonry();
});
