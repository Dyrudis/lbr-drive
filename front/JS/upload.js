// Importation des tags de la bdd
allTags = [];
let request = new XMLHttpRequest();
request.open("get", "back/tags/getTags.php", true);
request.send();
request.onload = function () {
    allTags = JSON.parse(this.responseText);
};

upload = [
    /*{
    'file' : ...,
    'name' : ...,
    'tags' : [...],
    },*/
];

let dropArea = $("#drop-area"),
    dropContainer = $(".drop"),
    center = dropContainer.find(".center > div"),
    circle = center.children(".circle"),
    list = dropContainer.children(".list");

let started = false,
    currentDistance,
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
    setTimeout(() => {
        startAnimation(currentDistance, 18, 100, () => {
            dropContainer.removeClass("showDrops");
            setTimeout(() => {
                startAnimation(18, 12, 300);
                setTimeout(() => {
                    dropContainer.addClass("show");
                    dropContainer.removeClass("dragged");

                    //Fake Upload durations
                    setTimeout(() => {
                        if (!dropContainer.hasClass("dropped")) {
                            dropContainer.addClass("dropped");
                            $("#uploadButton").css({ display: "block", opacity: "0" });
                        }
                        setTimeout(() => {
                            $("#uploadButton").css({ opacity: "1" });
                        }, 1000);

                        list.find("li .progress").each(function () {
                            startPercent($(this), 0, 100, 1200);
                        });
                    }, 800);
                }, 400);
            }, 200);
        });
    }, 400);

    for (let i = 0; i < e.originalEvent.dataTransfer.files.length; i++) {
        let file = e.originalEvent.dataTransfer.files[i];
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
            let source = $("<source />").attr("src", URL.createObjectURL(file)).attr("type", file.type);
            preview.append(source);

            preview.hover(function toggleControls() {
                if (this.hasAttribute("controls")) {
                    this.removeAttribute("controls");
                } else {
                    this.setAttribute("controls", "controls");
                }
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
            addTag.append(
                $("<option />")
                    .attr("value", tag.IDTag)
                    .text(tag.NomTag)
                    .css("background-color", "#" + tag.Couleur)
            );
        });

        preview.appendTo(li);
        tags.append(addTag);
        text.append(input).append(tags).append(small).appendTo(li);

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
            console.log(upload.find((e) => e.file == file).tags);
        });

        upload.push({
            file: file,
            name: name,
            tags: [],
            dom: li,
        });
    }
});

function updateName(name, file) {
    upload.find((e) => e.file == file).name = name;
}

// TODO : UPDATE
function updateTags(tagsDiv, file) {
    // For each select inside tagsDiv
    let tagList = [];
    tagsDiv.find("select").each(function () {
        let value = $(this).val();
        if (value != null && value != "Nouveau Tag" && value != "Supprimer") {
            tagList.push($(this).val());
        }
    });
    upload.find((e) => e.file == file).tags = tagList;
}

function insertTag(IDTag, file) {
    upload.find((e) => e.file == file).tags.push(IDTag);
}

function removeTag(IDTag, file) {
    upload.find((e) => e.file == file).tags = upload.find((e) => e.file == file).tags.filter((e) => e != IDTag);
}

function linear(n) {
    return n;
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
        val = linear(p);
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
    let from = {
            x: mX,
            y: mY,
        },
        offset = elem.offset(),
        center = {
            x: offset.left + elem.width() / 2,
            y: offset.top + elem.height() / 2,
        },
        radians = Math.atan2(mX - center.x, mY - center.y),
        degree = radians * (180 / Math.PI) * -1 + 180;
    return degree;
}

function startPercent(progress, from, to, duration) {
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
            return;
        }
        if (now - start >= dur) {
            stop = true;
        }
        let p = (now - start) / dur;
        val = linear(p);
        let x = from + (to - from) * val;
        if (!progress.hasClass("complete")) {
            progress.find(".pie").css("strokeDasharray", (x * 2 * Math.PI * 8) / 100 + " " + 2 * Math.PI * 8);
            if (x >= 100) {
                progress.addClass("complete");
            }
        }
        requestAnimationFrame(draw);
    }

    requestAnimationFrame(startAnim);
}

function bytesToSize(bytes) {
    if (bytes == 0) {
        return "0 Octet";
    }
    let i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024))),
        sizes = ["Octets", "Ko", "Mo", "Go", "To"];
    return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
}

eva.replace({
    fill: "currentColor",
});

$("#uploadButton").on("click", () => {
    uploadEverything(upload);
    // For each element in the list
    $(".list")
        .find("li")
        .each(function () {
            // Add the "pending" class
            $(this).addClass("pending");
        });
    // Hide the button
    $("#uploadButton").hide();
});

function uploadEverything(upload) {
    upload.forEach((e) => {
        uploadFile(e.file, e.name, e.tags, e.dom);
        let loader = $("#loader");

        // Copy and paste the loader in e.dom and remove the id
        loader.clone().appendTo(e.dom).removeAttr("id");
        let progress = $("<div />").addClass("progress").html('<svg class="pie" width="32" height="32"><circle r="8" cx="16" cy="16" /></svg><svg class="tick" viewBox="0 0 24 24"><polyline points="18,7 11,16 6,12" /></svg>');
        progress.appendTo(e.dom);
        progress.find(".pie").css("strokeDasharray", 0 + " " + 2 * Math.PI * 8);
    });
}

function uploadFile(file, name, tags, dom) {
    getDuration(file).then((duration) => {
        let formData = new FormData();
        formData.append("file", file);
        formData.append("name", name);
        formData.append("tags", JSON.stringify(tags));
        formData.append("duration", duration);
        fetch("./back/upload.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.text())
            .then((res) => {
                if (res === "success") {
                    dom.addClass("uploaded");
                    dom.find(".progress").addClass("complete");
                } else {
                    dom.addClass("failed");
                    setTimeout(() => {
                        let error = $("<div>").addClass("error").text(res);
                        dom.append(error);
                    }, 500);
                }
            })
            .catch((error) => console.log(error));
    });
}

async function getDuration(file) {
    // if it's not a video
    if (!file.type.match(/video/)) {
        return 0;
    }

    // if it is a video
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
