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

function displayLog(log) {
    console.log(log);
    let logDiv = $("<div>").addClass("log");

    let avatarDiv = $("<div>").addClass("avatar");
    let avatar = $("<img>").attr("src", "/avatars/" + log.IDSource);
    avatarDiv.append(avatar);

    let nomDateDiv = $("<div>").addClass("nom-date");
    let nom = $("<p>").html(log.Prenom + "<br/>" + log.Nom);
    let date = $("<p>").html(formatDate(log.Date)).addClass("date");
    nomDateDiv.append(nom);
    nomDateDiv.append(date);

    let description = $("<p>").text(log.Description).addClass("description");

    logDiv.append(avatarDiv);
    logDiv.append(nomDateDiv);
    logDiv.append(description);

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
