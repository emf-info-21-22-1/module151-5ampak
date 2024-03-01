//variable
var loginValueUsername;
var loginValuePassword;

//Load http
$.getScript("javascript/service/service_http.js", function () {
    console.log("servicesHttp.js chargé !");
});


$(document).ready(function () {
    $("#submitCon").click(function (event) {
        event.preventDefault(); // pour afficher les echos / permission

        // get data
        console.log("Button login pressed");

        loginValueUsername = $("#username").val();
        console.log("Username:", loginValueUsername);

        loginValuePassword = $("#password").val();
        console.log("Password:", loginValuePassword);

        //méhode login
        loginUser(loginValueUsername, loginValuePassword);

    });
});

//connecter
function loginUser(username, password) {
    console.log("Connexion à l'utilisateur : " + username + " " + password);

    // Appel de la fonction AJAX pour se connecter
    connexionUserAjax(username, password, function (response) {
        // Callback de succès
        console.log(response);

        // Récupération des propriétés de la réponse JSON
        var success = response.success;
        var message = response.message;
        var userLogin = response["Userlogin"];
        var userPK = response["UserPK"];

        if (success) {
            alert("Utilisateur connecté avec succès : " + userLogin);
            sessionStorage.setItem('username', userLogin);
            sessionStorage.setItem('PKuser', userPK);
            // Redirigez l'utilisateur vers la page planning.html ou effectuez d'autres actions nécessaires
            window.location.href = "planning.html";
        } else {
            alert("La connexion a échoué : " + message);
        }
    }, function (error) {

        alert("Login ou mot de passe incorrect");
    });
}

