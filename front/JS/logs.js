// Get the logs from the server
let request = new XMLHttpRequest();
request.open("get", "back/getLogs.php", true);
request.send();
request.onload = function () {
    logs = JSON.parse(this.responseText);
    logs.forEach(function (log) {
        displayLog(log);
    });
};

let userTrieur = $('#userTri').on('input', function () {

    $('.log').each(function () {

        if ($(this).find('.nom').text().toLowerCase().includes(userTrieur.val().toLowerCase())) {
            if ($(this).find('.description').text().toLowerCase().includes(contentTrieur.val().toLowerCase())) {
                $(this).show();
            }
        } else {
            $(this).hide();
        }
    });

});

let contentTrieur = $('#contentTri').on('input', function () {
    
    $('.log').each(function () {

        if ($(this).find('.description').text().toLowerCase().includes(contentTrieur.val().toLowerCase())) {
            if ($(this).find('.nom').text().toLowerCase().includes(userTrieur.val().toLowerCase())) {
                $(this).show();
            }
        } else {
            $(this).hide();
        }
    });

});

function displayLog(log) {
    console.log(log);
    let logDiv = $("<div>").addClass("log");

    //Photo de profil
    let avatarDiv = $("<div>").addClass("avatar undraggable");
    let avatar = $("<img>").attr("src", "/avatars/" + log.IDSource).addClass("undraggable");
    avatarDiv.append(avatar);

    //Nom de l'utilisateur
    let nomDiv = $("<div>").addClass("nom");
    let nom = $("<p>").html(log.Prenom + "<br/>" + log.Nom);
    nomDiv.append(nom);

    let description = $("<p>").text(log.Description).addClass("description");

    let date = $("<p>").html(formatDate(log.Date)).addClass("date");

    logDiv.append(avatarDiv);
    logDiv.append(nomDiv);
    logDiv.append(description);
    logDiv.append(date);

    $("#logs").append(logDiv);
}

function formatDate(date) {
    var d = new Date(date),
        month = "" + (d.getMonth() + 1),
        day = "" + d.getDate(),
        year = "" + d.getFullYear(),
        hours = "" + d.getHours(),
        minutes = "" + d.getMinutes();

    if (month.length < 2) month = "0" + month;
    if (day.length < 2) day = "0" + day;
    if (hours.length < 2) hours = "0" + hours;
    if (minutes.length < 2) minutes = "0" + minutes;

    return "le " + [day, month, year].join("/") + "<br/>à " + [hours, minutes].join(":");
}
