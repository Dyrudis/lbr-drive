$("#avatar-container").click(function() {
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

    let formData = new FormData();
    formData.append('avatar', file);

    let request = new XMLHttpRequest();
    request.open("post", "back/account/updateAvatar.php", true);
    request.send(formData);
    request.onload = function () {
        if (this.responseText != "OK") {
            console.log(this.responseText);
        }
    };

    // Get the image
    let image = document.getElementById("avatar");
    image.src = window.URL.createObjectURL(file);
}
