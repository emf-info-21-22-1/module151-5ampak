
$(document).ready(function () {
    $("#logout").click(function (event) {
        event.preventDefault(); // pour afficher les echos / permission         
        console.log("deconnection");


        //var
        const UserConnected = sessionStorage.getItem('username');
        //get liste projet
        logout(UserConnected, function (response) {
            // Callback de succès !

            console.log(response);
            var userLogOut = response["userLogOut"];
            console.log(userLogOut);
            alert("Personne déconnecter : " + userLogOut);
            sessionStorage.clear();
            window.location.href = "planning.html";

        }, function (error) {
            // Callback d'erreur
            alert("Problème de déconnection !");
        });


    });
});


$.getScript("javascript/service/service_http.js", function () {
    console.log("servicesHttp.js chargé !");

    // 1) récupèrer les projet ! vérifier la session sinon
    // postman abuse
    const pkUserConnected = sessionStorage.getItem('PKuser');
    const UserConnected = sessionStorage.getItem('username');

    console.log(pkUserConnected);
    console.log(UserConnected);

    if (pkUserConnected === null | UserConnected === null) {
        alert("Un problème est survenu, merci de vous reconnecter"); $
       window.location.href = "connexion.html";
    }


    //get liste projet
    getUserProjet(UserConnected, pkUserConnected, function (response) {
        // Callback de succès
        alert("Liste des projets :", response);
    }, function (error) {
        // Callback d'erreur
        alert("Problème avec la liste des projets !");
    });
});

