// Importation des tags de la bdd
allTags = [];
$.ajax({
    url: "back/tag/getTags.php",
    type: "GET",
    dataType: "json",
    success: function (data) {
        allTags = data;
    },
});

upload = [
    /*{
    'file' : ...,
    'name' : ...,
    'tags' : [...],
    'timestamp' : ...,
    'dom' : ...
    },*/
];

let dropArea = $("#drop-area"),
    dropContainer = $(".drop"),
    center = dropContainer.find(".center > div"),
    circle = center.children(".circle"),
    list = dropContainer.children(".list");

let started = false,
    currentDistance = 0,
    mouse = {
        x: 0,
        y: 0,
    };

dropArea.on("dragenter dragstart dragend dragleave dragover drag drop", (e) => {
    e.preventDefault();
});

dropArea.on("dragover", (e) => {
    dropContainer.addClass("dragged showDrops").css({
        "--r": calculateRotate(circle, e.pageX, e.pageY) + "deg",
    });
    let bool = $(e.target).is(circle) || $.contains(circle[0], e.target),
        distance = calculateDistance(circle, dropArea, e.pageX, e.pageY) > 1 ? 1 : calculateDistance(circle, dropArea, e.pageX, e.pageY);
    mouse = {
        x: e.pageX,
        y: e.pageY,
    };
    if (bool == true) {
        if (!started) {
            currentDistance = 0;
            startAnimation(currentDistance, 12, 300);
            started = true;
        }
    } else {
        currentDistance = distance * 12;
        setPathData(currentDistance);
        started = false;
    }
});

dropArea.on("dragend dragleave", (e) => {
    startAnimation(currentDistance, 12, 400);
});

dropArea.on("dragleave", (e) => {
    dropContainer.removeClass("dragged showDrops");
});

dropArea.on("drop", (e) => {
    animate();
    // Add the files on drop
    for (let i = 0; i < e.originalEvent.dataTransfer.files.length; i++) {
        addFile(e.originalEvent.dataTransfer.files[i]);
    }
});

// Add the files when user click on the button
document.getElementById("addFileButton").addEventListener("click", function () {
    let fileInput = document.createElement("input");
    fileInput.type = "file";
    fileInput.multiple = true;
    fileInput.accept = "image/*, video/*";
    fileInput.click();
    fileInput.addEventListener("change", function () {
        animate();
        for (let i = 0; i < fileInput.files.length; i++) {
            addFile(fileInput.files[i]);
        }
    });
});

// Animation when the user adds a file
function animate() {
    setTimeout(() => {
        startAnimation(currentDistance, 18, 100, () => {
            dropContainer.removeClass("showDrops");
            setTimeout(() => {
                startAnimation(18, 12, 300);
                setTimeout(() => {
                    dropContainer.addClass("show");
                    dropContainer.removeClass("dragged");
                    setTimeout(() => {
                        if (!dropContainer.hasClass("dropped")) {
                            dropContainer.addClass("dropped");
                            $("#uploadButton").fadeIn().css("display", "block");
                        }
                    }, 800);
                }, 400);
            }, 200);
        });
    }, 300);
}

// Add the file to the list
function addFile(file) {
    let type = file.type.split("/")[0];
    let name = file.name
        .split(".")
        .splice(0, file.name.split(".").length - 1)
        .join(".");

    /* Création de l'UI */
    let li = $("<li />");
    let preview;
    if (type == "image") {
        preview = $("<img />").attr("src", URL.createObjectURL(file));
    } else {
        preview = $("<video />");
        let info = $("<p>").text("?").addClass("info");
        let infoHover = $("<p>").text("Choisissez un endroit de la vidéo qui sera utilisé pour la miniature dans la galerie.").addClass("infoHover");
        li.append(info);
        li.append(infoHover);
        let source = $("<source />").attr("src", URL.createObjectURL(file)).attr("type", file.type);
        preview.append(source);
        preview.hover(function toggleControls() {
            if (this.hasAttribute("controls")) {
                this.removeAttribute("controls");
            } else {
                this.setAttribute("controls", "controls");
            }
        });
        preview.on("timeupdate", function () {
            updateTimestamp(this.currentTime, file);
            console.log(upload);
        });
    }
    let text = $("<div />").addClass("text");
    let input = $("<input />")
        .attr("value", name)
        .attr("placeHolder", "Nom du fichier")
        .on("change", function () {
            updateName($(this).val(), file);
        });
    let small = $("<small />").text(bytesToSize(file.size));
    let tags = $("<div />").addClass("tags");
    let addTag = $("<select />").addClass("addTag").css("width", "70px");
    addTag.append($("<option />").attr("value", "").text("+ Tag").attr("selected", "selected").attr("disabled", "disabled"));
    allTags.forEach((tag) => {
        if (tag.IDTag != 0) {
            addTag.append(
                $("<option />")
                    .attr("value", tag.IDTag)
                    .text(tag.NomTag)
                    .css("background-color", "#" + tag.Couleur)
            );
        }
    });
    let progressBar = $("<div />").addClass("progressBar");
    let progress = $("<div />").addClass("progress");
    progressBar.append(progress);

    preview.appendTo(li);
    tags.append(addTag);
    text.append(input).append(tags).append(small).append(progressBar).appendTo(li);

    li.appendTo(list);

    addTag.on("change", function () {
        let tag = $(this).val();
        let tagList = upload.find((e) => e.file == file).tags;
        if (tag != "" && !tagList.includes(tag)) {
            //updateTags(file, tag);
            let newTag = $("<div />")
                .addClass("tag")
                .css("background-color", "#" + allTags.find((e) => e.IDTag == tag).Couleur);
            newTag.append($("<p />").text(allTags.find((e) => e.IDTag == tag).NomTag));
            newTag.append($("<img />").attr("src", "front/images/close.svg").addClass("close"));
            newTag.on("click", function () {
                newTag.remove();
                removeTag(tag, file);
            });
            newTag.insertBefore(addTag);
            insertTag(tag, file);
        }
        $(this).val("");
    });

    upload.push({
        file: file,
        name: name,
        tags: [],
        timestamp: 0,
        dom: li,
    });
}

function updateName(name, file) {
    upload.find((e) => e.file == file).name = name;
}

function insertTag(IDTag, file) {
    upload.find((e) => e.file == file).tags.push(IDTag);
}

function removeTag(IDTag, file) {
    upload.find((e) => e.file == file).tags = upload.find((e) => e.file == file).tags.filter((e) => e != IDTag);
}

function updateTimestamp(timestamp, file) {
    upload.find((e) => e.file == file).timestamp = timestamp;
}

function startAnimation(from, to, duration, callback) {
    let stop = false,
        dur = duration || 200,
        start = null,
        end = null;

    function startAnim(timeStamp) {
        start = timeStamp;
        end = start + dur;
        draw(timeStamp);
    }

    function draw(now) {
        if (stop) {
            if (callback && typeof callback === "function") {
                callback();
            }
            return;
        }
        if (now - start >= dur) {
            stop = true;
        }
        let p = (now - start) / dur;
        val = p;
        let x = from + (to - from) * val;
        setPathData(x);
        requestAnimationFrame(draw);
    }

    requestAnimationFrame(startAnim);
}

function setPathData(value) {
    circle.find("svg path").attr("d", "M46,80 C55.3966448,80 63.9029705,76.1880913 70.0569683,70.0262831 C76.2007441,63.8747097 80,55.3810367 80,46 C80,36.6003571 76.1856584,28.0916013 70.0203842,21.9371418 C63.8692805,15.7968278 55.3780386, " + value + " 46, " + value + " C36.596754, " + value + " 28.0850784,15.8172663 21.9300655,21.9867066 C15.7939108,28.1372443 12,36.6255645 12,46 C12,55.4035343 15.8175004,63.9154436 21.9872741,70.0705007 C28.1377665,76.2063225 36.6258528,80 46,80 Z");
}

function calculateDistance(elem, parent, mX, mY) {
    let from = {
            x: mX,
            y: mY,
        },
        offset = elem.offset(),
        parentOffset = parent.offset(),
        nx1 = offset.left,
        ny1 = offset.top,
        nx2 = nx1 + elem.outerWidth(),
        ny2 = ny1 + elem.outerHeight(),
        elemOffset = {
            top: offset.top - parentOffset.top,
            left: offset.left - parentOffset.left,
        },
        maxX1 = Math.max(mX, nx1),
        minX2 = Math.min(mX, nx2),
        maxY1 = Math.max(mY, ny1),
        minY2 = Math.min(mY, ny2),
        intersectX = minX2 >= maxX1,
        intersectY = minY2 >= maxY1,
        to = {
            x: intersectX ? mX : nx2 < mX ? nx2 : nx1,
            y: intersectY ? mY : ny2 < mY ? ny2 : ny1,
        },
        distX = to.x - from.x,
        distY = to.y - from.y;
    return Math.sqrt(distX * distX + distY * distY) / elemOffset.left;
}

function calculateRotate(elem, mX, mY) {
    let offset = elem.offset(),
        center = {
            x: offset.left + elem.width() / 2,
            y: offset.top + elem.height() / 2,
        },
        radians = Math.atan2(mX - center.x, mY - center.y),
        degree = radians * (180 / Math.PI) * -1 + 180;
    return degree;
}

function bytesToSize(bytes) {
    if (bytes == 0) {
        return "0 Octet";
    }
    let i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024))),
        sizes = ["Octets", "Ko", "Mo", "Go", "To"];
    return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
}

/*--------------------------------*\
|   Send the files to the server   |
\*--------------------------------*/

$("#uploadButton").on("click", () => {
    upload.forEach((e) => {
        let dom = e.dom;
        // Disable the title input
        dom.find(".text input").attr("disabled", "disabled");

        // Disable the add tag select
        dom.find(".addTag").hide();

        // Disable the cross on tags
        dom.find(".tag").find(".close").hide();
        dom.find(".tag").off("click");

        // If there is not tag, add the default tag
        if (e.tags.length == 0) {
            noTag = $("<div />")
                .addClass("tag")
                .css("background-color", "#" + allTags.find((e) => e.IDTag == 0).Couleur);
            noTag.append($("<p />").text(allTags.find((e) => e.IDTag == 0).NomTag));
            dom.find(".tags").append(noTag);
        }
    });
    uploadFiles();

    // Hide the button
    $("#uploadButton").fadeOut();
});

async function uploadFiles() {
    if (upload.length == 0) {
        // All files are uploaded

        $("#uploadButton")
            .text("Retour à la galerie")
            .fadeIn()
            .click(() => {
                window.location.href = "index.php";
            });
        return;
    }

    // Upload the first file and remove it from the list
    let nextFile = upload.shift();
    let file = nextFile.file,
        name = nextFile.name,
        tags = nextFile.tags,
        timestamp = nextFile.timestamp,
        dom = nextFile.dom;

    let duration = await getDuration(file);
    let uploaded = 0;
    let total = file.size;
    let chunkSize = 1024 * 1024;
    let id = makeid();
    let blob = file.slice(uploaded, uploaded + chunkSize);
    sendChunk();
    dom.find(".progressBar").css("opacity", "1");

    function sendChunk() {
        let data = new FormData();
        data.append("file", blob);
        data.append("name", name);
        data.append("tags", JSON.stringify(tags));
        data.append("duration", duration);
        data.append("id", id);
        data.append("extension", file.name.split(".").pop());
        data.append("timestamp", timestamp);
        data.append("currentChunkNumber", 1 + uploaded / chunkSize);
        data.append("totalChunkNumber", Math.ceil(total / chunkSize));

        let request = new XMLHttpRequest();
        request.open("post", "./back/file/uploadFile.php", true);
        request.send(data);
        request.onload = function () {
            if (this.responseText != "OK" && this.responseText != "Chunk received") {
                console.error(this.responseText);
                return;
            }

            uploaded += chunkSize;
            if (uploaded < total) {
                // Send next chunk
                blob = file.slice(uploaded, uploaded + chunkSize);
                sendChunk();
            } else {
                // Upload finished
                uploaded = total;
                dom.find(".progressBar .progress").css("background-color", "green");

                // Upload the next file
                uploadFiles();
            }
            dom.find(".progressBar .progress").css("width", (uploaded / total) * 100 + "%");
        };
    }
}

async function getDuration(file) {
    // Not a video
    if (!file.type.match(/video/)) {
        return 0;
    }

    var video = document.createElement("video");
    video.preload = "metadata";
    video.src = URL.createObjectURL(file);
    return new Promise((resolve) => {
        video.onloadedmetadata = () => {
            window.URL.revokeObjectURL(video.src);
            resolve(video.duration);
        };
    });
}

function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 10; i++) text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}
