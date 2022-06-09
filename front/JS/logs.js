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
    let date = $("<p>").text(log.Date).addClass("date");
    nomDateDiv.append(nom);
    nomDateDiv.append(date);

    let description = $("<p>").text(log.Description).addClass("description");

    logDiv.append(avatarDiv);
    logDiv.append(nomDateDiv);
    logDiv.append(description);

    $("#logs").append(logDiv);
}
