// Get all the tags
var allTags = [];
var request = new XMLHttpRequest();
request.open("get", "back/tags/getTags.php", true);
request.send();
request.onload = function () {
    allTags = JSON.parse(this.responseText);

    // Get all the files
    var request = new XMLHttpRequest();
    request.open("get", "back/files/getFiles.php", true);
    request.send();
    request.onload = displayGallery;
};

function displayGallery() {
    $("#gallery").empty();

    // If the response is a php error, print it
    if (this.responseText.startsWith("<")) {
        $("#gallery").text(this.responseText);
        return;
    }

    allFiles = JSON.parse(this.responseText);
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
    } else {
        preview = $("<video />");
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
        .html("<p>" + file.NomFichier + "</p>");
    let author = $("<div>")
        .addClass("file-hover-author")
        .text("de " + file.Prenom + " " + file.Nom + ", " + file.Date);
    let info = $("<div>")
        .addClass("file-hover-info")
        .text(bytesToSize(file.Taille) + (file.Duree != "0" ? " - " + formatSeconds(file.Duree) : ""));

    // All the actions
    let actions = $("<div>").addClass("file-hover-actions");

    let downloadFile = $("<img>").attr("src", "front/images/download.png");
    let deleteFile = $("<img>").attr("src", "front/images/delete.svg");
    let restoreFile = $("<img>").attr("src", "front/images/restore.png");
    let addTag = $("<select>");
    addTag.append($("<option>").attr("value", "0").attr("selected", "selected").attr("disabled", "disabled").text("+ Tag"));
    allTags.forEach((tag) => {
        addTag.append(
            $("<option>")
                .attr("value", tag.IDTag)
                .text(tag.NomTag)
                .css({ "background-color": "#" + tag.Couleur, color: "white" })
        );
    });

    actions.append(downloadFile); // FOR EVERYONE
    if (file.isEditable) {
        actions.append(file.Corbeille ? restoreFile : deleteFile); // ONLY FOR AUTHOR OR ADMIN
        actions.append(addTag); // ONLY FOR AUTHOR OR ADMIN
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
        if (confirm("Voulez-vous vraiment supprimer ce fichier ?")) {
            let formData = new FormData();
            formData.append("IDFichier", JSON.stringify(file.IDFichier));

            let request = new XMLHttpRequest();
            request.open("post", "back/files/suspendFile.php", true);
            request.send(formData);
            request.onload = function () {
                if (this.responseText == "OK") {
                    container.remove();
                } else {
                    console.log(this.responseText);
                }
            };
        }
    });

    // Restore button
    restoreFile.click(function () {
        if (confirm("Voulez-vous vraiment restaurer ce fichier ?")) {
            let formData = new FormData();
            formData.append("IDFichier", JSON.stringify(file.IDFichier));

            let request = new XMLHttpRequest();
            request.open("post", "back/files/restoreFile.php", true);
            request.send(formData);
            request.onload = function () {
                if (this.responseText == "OK") {
                    container.remove();
                } else {
                    console.log(this.responseText);
                }
            };
        }
    });

    // Add tag button
    addTag.change(function () {
        let tagID = addTag.val();
        tag = allTags.find((tag) => tag.IDTag == tagID);
        if (tagID != 0) {
            addTagToFile(file.IDFichier, tagID);

            let newTag = $("<div>")
                .addClass("tag")
                .attr("data-id", tag.IDTag)
                .css("background-color", "#" + tag.Couleur);
            newTag.html("<p>" + tag.NomTag + "</p>");

            let deleteTag = $("<img>").attr("src", "front/images/close.svg");
            newTag.append(deleteTag);
            newTag.css("cursor", "pointer");
            newTag.click(() => {
                deleteTagFromFile(file.IDFichier, tag.IDTag);
                newTag.remove();
            });
            container.find(".file-hover-tags").append(newTag);
        }

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

function displayInFullscreen(event) {
    let preview = event.currentTarget.cloneNode(true); //.children[0].cloneNode(true);
    // Select "#fullscreen-container" or create it if it doesn't exist
    let container = $("#fullscreen-container");
    if (container.length == 0) {
        container = $("<div>").attr("id", "fullscreen-container");
        $("body").append(container);
    }
    // If the priview is a video, add controls
    if (preview.tagName == "VIDEO") {
        preview.setAttribute("controls", "controls");
        preview.style.backgroundColor = "black";
    }
    container.append(preview);
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
        let deleteTag = $("<img>").attr("src", "front/images/close.svg");
        let tags = container.find(".tag");
        tags.append(deleteTag);
        tags.css("cursor", "pointer");
        tags.click(function () {
            deleteTagFromFile(file.IDFichier, $(this).attr("data-id"));
            $(this).remove();
        });

        let editTitle = $("<img>").attr("src", "front/images/edit.svg").addClass("edit-title pointerOnHover");
        container.find(".file-hover-title").append(editTitle);
        container.find(".file-hover-title").css("cursor", "text");
        container.find(".file-hover-title").click(function () {
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
}

function deleteTagFromFile(IDFichier, IDTag) {
    let formData = new FormData();
    formData.append("IDFichier", IDFichier);
    formData.append("IDTag", IDTag);

    let request = new XMLHttpRequest();
    request.open("post", "back/files/deleteTag.php", true);
    request.send(formData);
    request.onload = function () {
        if (this.responseText != "OK") {
            console.log(this.responseText);
        }
    };
}

function addTagToFile(IDFichier, IDTag) {
    let formData = new FormData();
    formData.append("IDFichier", IDFichier);
    formData.append("IDTag", IDTag);

    let request = new XMLHttpRequest();
    request.open("post", "back/files/addTag.php", true);
    request.send(formData);
    request.onload = function () {
        if (this.responseText != "OK") {
            console.log(this.responseText);
        }
    };
}

function editFileTitle(IDFichier, newTitle) {
    let formData = new FormData();
    formData.append("IDFichier", IDFichier);
    formData.append("NomFichier", newTitle);

    let request = new XMLHttpRequest();
    request.open("post", "back/files/updateTitle.php", true);
    request.send(formData);
    request.onload = function () {
        if (this.responseText != "OK") {
            console.log(this.responseText);
        }
    };
}
