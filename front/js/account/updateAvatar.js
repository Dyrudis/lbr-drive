$("#avatar-container").click(function () {
    // Create a new file input
    let fileInput = document.createElement("input");
    fileInput.setAttribute("type", "file");
    fileInput.setAttribute("accept", "image/*");
    fileInput.setAttribute("name", "avatar");
    fileInput.setAttribute("id", "avatar");
    fileInput.setAttribute("onchange", "readURL(this);");
    fileInput.click();
});

function readURL(fileInput) {
    // Get the file
    let file = fileInput.files[0];

    if (file.size > 2000000) {
        alert.create({
            content: "Cette image fait plus de 2 Mo",
            type: "error",
        });
        return;
    }

    let formData = new FormData();
    formData.append("avatar", file);

    let request = new XMLHttpRequest();
    request.open("post", "back/account/updateAvatar.php", true);
    request.send(formData);
    request.onload = function () {
        if (this.responseText != "OK") {
            alert.create({
                content: this.responseText,
                type: "error",
            });
        } else {
            alert.create({
                content: "Avatar modifié avec succès",
                type: "success",
            });
        }
    };

    // Get the image
    let image = document.getElementById("avatar");
    image.src = window.URL.createObjectURL(file);
}
