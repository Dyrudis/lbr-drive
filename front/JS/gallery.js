// To prevent the user from accessing the data directly
(function () {
    var request = new XMLHttpRequest();
    request.open("get", "back/loadGallery.php", true);
    request.send();
    request.onload = displayGallery;

    function displayGallery() {
        allFiles = JSON.parse(this.responseText);
        console.log(allFiles);
        allFiles.forEach((file) => {
            displayFile(file);
        });
    }

    function displayFile(file) {
        // TMP
        file.Tags = ["tag1", "tag2"];

        let path = "./upload/" + file.IDFichier + "." + file.Extension;
        console.log(path);
        //path = "./upload/test.png";

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

            /* preview.hover(function toggleControls() {
                if (this.hasAttribute("controls")) {
                    this.removeAttribute("controls");
                } else {
                    this.setAttribute("controls", "controls");
                }
            }); */
        }
        preview.addClass("file-preview");
        let hover = $("<div>").addClass("file-hover");
        let hoverTags = $("<div>").addClass("file-hover-tags");
        file.Tags.forEach((tag) => {
            let tagElem = $("<div>")
                .addClass("tag")
                .html("<p>" + tag + "</p>");
            hoverTags.append(tagElem);
        });
        let title = $("<div>").addClass("file-hover-title").text(file.NomFichier);
        let author = $("<div>")
            .addClass("file-hover-author")
            .text("de " + file.Prenom + " " + file.Nom + ", " + file.Date);
        let info = $("<div>")
            .addClass("file-hover-info")
            .text(bytesToSize(file.Taille) + (file.Duree != "0" ? " - " + formatSeconds(file.Duree) : ""));
        hover.append(hoverTags);
        hover.append(title);
        hover.append(author);
        hover.append(info);

        container.append(preview);
        container.append(hover);

        // Radom number between 1 and 4
        let random = Math.floor(Math.random() * 4) + 1;
        $("#col-" + random).append(container);
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
})();
