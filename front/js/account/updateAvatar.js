$("#avatar-container").click(function () {
    // Create a new file input
    let fileInput = document.createElement("input");
    fileInput.setAttribute("type", "file");
    fileInput.setAttribute("accept", "image/*");
    fileInput.setAttribute("name", "avatar");
    fileInput.setAttribute("id", "avatar");
    fileInput.setAttribute("onchange", "uploadAvatar(this);");
    fileInput.click();
});

function uploadAvatar(fileInput) {
    let file = fileInput.files[0];
    let uploaded = 0;
    let total = file.size;
    let chunkSize = 1024 * 1024;
    let id = makeid();
    let blob = file.slice(uploaded, uploaded + chunkSize);
    sendChunk();

    function sendChunk() {
        let data = new FormData();
        data.append("chunk", blob);
        data.append("extension", file.name.split(".").pop());
        data.append("id", id);
        data.append("currentChunkNumber", 1 + uploaded / chunkSize);
        data.append("totalChunkNumber", Math.ceil(total / chunkSize));

        let request = new XMLHttpRequest();
        request.open("post", "./back/account/updateAvatar.php", true);
        request.send(data);
        request.onload = function () {
            if (this.responseText != "OK" && this.responseText != "Chunk received") {
                console.error(this.responseText);
                alert.create({
                    content: this.responseText,
                    type: "error",
                });
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
                let image = document.getElementById("avatar");
                image.src = window.URL.createObjectURL(file);
                alert.create({
                    content: "Avatar modifié avec succès",
                    type: "success",
                });
            }
        };
    }
}

function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 10; i++) text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}
