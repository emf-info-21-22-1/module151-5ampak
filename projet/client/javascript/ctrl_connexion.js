//variable
var loginValueUsername;
var loginValuePassword;

//Load http
$.getScript("javascript/service/service_http.js", function () {
    console.log("servicesHttp.js chargé !");
});


$(document).ready(function () {
    $("#submitCon").click(function (event) {
        event.preventDefault();

        //injection html ?

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

        // Récupération des propriétés de la réponse JSON
        var userLogin = response["Userlogin"];
        var userPK = response["UserPK"];
        var userAdmin = response["IsAdmin"];
        
            alert("Connexion réussis avec succès : " + userLogin);

            sessionStorage.setItem('username', userLogin);
            sessionStorage.setItem('PKuser', userPK);
            sessionStorage.setItem('IsAdmin', userAdmin);
            // Redirigez l'utilisateur vers la page planning.html ou effectuez d'autres actions nécessaires
            window.location.href = "planning.html";
        
    }, function (error) {
        alert("Login ou mot de passe incorrect");
    });
}

