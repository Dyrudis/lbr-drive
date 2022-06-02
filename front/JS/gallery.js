var request = new XMLHttpRequest();
request.open("get", "back/loadGallery.php", true);
request.send();
request.onload = displayGallery;
function displayGallery() {
    $("#gallery").empty();
    //console.log(this.responseText);
    allFiles = JSON.parse(this.responseText);
    allFiles.forEach((file) => {
        displayFile(file);
    });
}

function displayFile(file) {
    file.Tags = file.NomTags.split(",");
    file.CouleurTags = file.CouleurTags.split(",");

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
            .html("<p>" + tag + "</p>")
            .css("background-color", "#" + file.CouleurTags[file.Tags.indexOf(tag)]);
        hoverTags.append(tagElem);
    });
    let title = $("<div>").addClass("file-hover-title").text(file.NomFichier);
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
    let addTag = $("<p>").text("+ Tag");

    actions.append(downloadFile); // FOR EVERYONE
    if (file.isEditable) {
        actions.append(deleteFile); // ONLY FOR AUTHOR OR ADMIN
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

    /* Implementation of all the actions */

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
            /* let request = new XMLHttpRequest();
            request.open("get", "back/deleteFile.php?id=" + file.IDFichier, true);
            request.send();
            request.onload = displayGallery; */
            let formData = new FormData();
            formData.append("IDFichier", JSON.stringify(file.IDFichier));

            let request = new XMLHttpRequest();
            request.open("post", "back/deleteFile.php", true);
            request.send(formData);
            request.onload = function () {
                //console.log(this.responseText);
                if (this.responseText == "Fichier supprimé") {
                    container.remove();
                }
            };
        }
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

    // Only allow to delete tag if the file is editable
    if (file.isEditable) {
        let deleteTag = $("<img>").attr("src", "front/images/close.svg");
        let tags = container.find(".tag");
        tags.append(deleteTag);
        tags.css("cursor", "pointer");
    }
}

function hideActions(container, file) {
    container.removeClass("selected");

    tags = container.find(".tag");
    tags.find("img").remove();
    tags.css("cursor", "default");
}
