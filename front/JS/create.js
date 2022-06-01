$("#create-header").click(function () {
    $("#create").toggleClass("shown");
});

// Create a new category
$("#create-category-button").click(function () {
    let name = $("#category-input").val();
    let color = $("#category-color-input").val();

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
        url: "/back/createCategory.php",
        type: "POST",
        data: {
            name: name,
            color: color,
        },
        success: function (data) {
            console.log(data);
        },
    });
});

// Create a new tag
$("#create-tag-button").click(function () {
    let name = $("#tag-input").val();
    let IDCategorie = $("#category-select").val();

    // Check if the fields are empty
    if (name == "" || IDCategorie == "") {
        return;
    }

    // Ajax request to create the tag
    $.ajax({
        url: "/back/createTag.php",
        type: "POST",
        data: {
            name: name,
            IDCategorie: IDCategorie,
        },
        success: function (data) {
            console.log(data);
            location.reload();
        },
    });
});
