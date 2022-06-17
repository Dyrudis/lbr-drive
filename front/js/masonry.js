var fixedwidth = 280 + 10, //the +10 is for 10px horizontal margin
    gallery = $("#gallery"); // cache a reference to our container

function masonry() {
    var children = gallery.children(); // cache a reference to our image list
    var columncount = Math.min(parseInt(gallery.width() / fixedwidth, 10) || 1, 6), // find how many columns fit in container,
        childWidth = gallery.width() / columncount - 10, // calculate the width of a column
        columns = [];

    for (var i = 0; i < columncount; i++) {
        // initialize columns (0 height for each)
        columns.push(0);
    }

    children.each(function (i, fileContainer) {
        var min = Math.min.apply(null, columns), // find height of shortest column
            index = columns.indexOf(min), // find column number with the min height
            x = index * (childWidth + 10), // calculate horizontal position of current image based on column it belongs
            filePreview = $(fileContainer).find(".file-preview");

        filePreview.css({ width: childWidth, height: "auto" });
        columns[index] += Math.max(filePreview.height(), 154) + 10; //calculate new height of column (+10 for 10px vertical margin)
        $(fileContainer).css({ left: x, top: min, width: childWidth, height: filePreview.height() });
        filePreview.css({ height: "100%" });
    });
}

$(window).resize(masonry);
