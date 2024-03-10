//#####################
//      Logout
//#####################

$(document).ready(function () {
    $("#logout").click(function (event) {
        event.preventDefault(); // pour afficher les echos / permission         
        console.log("deconnection");

        //var
        const UserConnected = sessionStorage.getItem('username');
        //get liste projet
        logout(UserConnected, function (response) {
            // Callback de succès

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

//#####################
//   get projet user
//#####################

$.getScript("javascript/service/service_http.js", function () {
    console.log("servicesHttp.js chargé !");

    // récupèrer les projet
    const pkUserConnected = sessionStorage.getItem('PKuser');
    const UserConnected = sessionStorage.getItem('username');

    console.log(pkUserConnected);
    console.log(UserConnected);

    if (pkUserConnected === null || UserConnected === null) {
        alert("Un problème est survenu, merci de vous reconnecter");
        window.location.href = "connexion.html";
    } else {
        //get liste projet
        getUserProjet(UserConnected, pkUserConnected, function (response) {
            // Callback de succès 
            console.log(response);

            if (response.length === 0) {
                alert("Aucun projet trouvé.");

            } else {

                alert("Projets récupérés avec succès!");

                // Supprime tous les éléments de la liste déroulante
                var dropdown = document.getElementById("projects-dropdown");
                dropdown.innerHTML = "";

                // Récupère les projets du JSON
                var projects = response;

                // Parcourt chaque projet et ajoute-le à la liste déroulante
                projects.forEach(function (project) {
                    var option = document.createElement("option");
                    option.value = project.PK_Projet;
                    option.text = project.Nom;
                    dropdown.appendChild(option);

                    //stock session projet
                    sessionStorage.setItem('Projet_' + project.PK_Projet, project.Nom);


                });
            }

        }, function (error) {
            // Callback d'erreur
            alert("Aucun projet pour cette utilisateur !");
        });
    }
});

//#####################
//   create task
//#####################

const projectsDropdown = document.getElementById('projects-dropdown');
var projetSelectionner = "Undefined";

// Écouteur menu déroulant -> change le projet sélectionné avec convention : Projet_X
projectsDropdown.addEventListener('change', function () {

    var selectedOptionValue = this.value;
    console.log(selectedOptionValue);

    projetSelectionner = this.value;
    //récpèrer la PK du projet séléctionner
    var nomProjet = 'Projet_' + projectsDropdown.value;
    var projetPK = nomProjet.match(/\d+/)[0];
    console.log(projetPK);
    //récupèrer les taches du projets séléctionner.
    getTasksProjet(projetPK);
});


const addTaskButton = document.getElementById('add-task-btn');
//bouton écouteur
addTaskButton.addEventListener('click', function () {

    console.log(projetSelectionner);

    if (projetSelectionner === "Undefined") {
        projetSelectionner = sessionStorage.getItem('Projet_1');
    } else if (projetSelectionner === null) {
        alert("Impossible de crée une nouvelle task sans être dans un projet");
    } else if (projetSelectionner !== null && projectsDropdown !== "Undefined") {
        //crée tâche dans projet séléctionner
        console.log("Tâche à créer dans le projet PK :" + projetSelectionner);

        createTask(projetSelectionner, function (response) {
            console.log("result stringified create task:", JSON.stringify(response));
            var message = response.message;
            alert(message);

        }, function (error) {
            // Callback d'erreur
            var message = error.message;
            alert(message);
        });
    }

});

//#####################
//   move task
//#####################

// drop tache
function handleDrop(e) {
    e.preventDefault();
    const pkTacheCree = e.dataTransfer.getData('text/plain');
    const draggable = document.querySelector(`[data-value="${pkTacheCree}"]`);

    if (draggable) {
        const targetBlock = e.target.closest('.block');

        //check droit
        var isAdmin = sessionStorage.getItem('IsAdmin');
        var tachePos = targetBlock.id;

        if (tachePos === "Validate" && isAdmin === "false") {
            alert("Vous n'avez pas les droits de déplacer cette tache ici !");
        } else {
            if (targetBlock && draggable !== targetBlock) {
                if (!targetBlock.contains(draggable)) { // Vérifier si l'élément draggable n'est pas déjà dans le bloc cible

                    targetBlock.appendChild(draggable);
                    draggable.classList.remove('dragging');

                    // pk
                    const pkTacheCreeValue = draggable.dataset.value;

                    // block déplacer
                    const blockValue = blockValues[targetBlock.id];

                    logDropMessage(targetBlock, blockValue, pkTacheCreeValue);
                } else {
                    console.log("Peut pas déplacer sur le même emplacement");
                }
            } else {
                console.log("Peut pas déplacer sur le même emplacement");
            }
        }
    } else {
        console.log("No draggable element found.");
    }
}

//info des positions
const blockValues = {
    "Todo-Block": 1,
    "In-Progress": 2,
    "Done": 3,
    "Validate": 4
};

//sout info console
function logDropMessage(container, blockValue, pkTacheCreeValue) {

    var isAdmin = sessionStorage.getItem('IsAdmin');
    var userPK = sessionStorage.getItem('PKuser');
    var tachePos = container.id;

    console.log("------------------------------------")
    console.log("Dropped onto block: " + tachePos);
    console.log("Block value: " + blockValue);
    console.log("PK de la tache: " + pkTacheCreeValue);
    console.log("user admin :" + isAdmin);

    moveBlock(blockValue, pkTacheCreeValue, userPK);
}

function moveBlock(blockValue, pkTacheCreeValue, userPK) {
    //requête :
    moveTask(blockValue, pkTacheCreeValue, userPK, function (response) {
        var message = response.message;
        alert(message);
    }, function (error) {
        var message = error.message;
        alert(message);
    });
}

//#####################################
//   méthode pour déplacer task
//####################################


// Function to handle dragover event
function handleDragOver(e) {
    e.preventDefault();
    const draggable = document.querySelector('.tache-bloc.dragging');
    if (draggable) {
        this.appendChild(draggable);
    }
}

/// Function to handle drag start event
function handleDragStart(e) {
    if (e.target.classList.contains('tache-bloc')) {
        e.dataTransfer.setData('text/plain', e.target.dataset.value);
        e.target.classList.add('dragging');
    }
}

// Function to handle drag over event
function handleDragOver(e) {
    e.preventDefault();
}


// Function to handle drag end event
function handleDragEnd(e) {
    if (e.target.classList.contains('tache-bloc')) {
        e.target.classList.remove('dragging');
    }
}

// Add event listeners
document.addEventListener('dragstart', handleDragStart);
document.addEventListener('dragover', handleDragOver);
document.addEventListener('drop', handleDrop);
document.addEventListener('dragend', handleDragEnd);

//#####################################
//  modification description
//####################################

// Sélectionnez tous les éléments de bloc
var blockElements = document.querySelectorAll('.block');

blockElements.forEach(function (blockElement) {
    blockElement.addEventListener('keypress', function (event) {
        //enter
        if (event.key === 'Enter') {
            var titleElement = blockElement.querySelector('.task-title');
            var text = blockElement.querySelector('textarea');

            if (titleElement && text) {
                //get élèment task
                var pkTache = extractPKFromTitle(titleElement.innerText);
                var textValue = text.value;

                //request
                modifyTask(pkTache, textValue, function (response) {
                    console.log("result stringified modify task :", JSON.stringify(response));

                }, function (error) {
                    var message = error.message;
                    alert(message);
                });


            } else {
                console.error('Aucun élément de titre ou de textarea correspondant trouvé pour ce bloc de tâche.');
            }
        }
    });
});

// Fonction pour extraire la PK à partir du titre
function extractPKFromTitle(titleText) {
    // get pk
    var splitTitle = titleText.split(":");
    if (splitTitle.length === 2) {
        return splitTitle[1].trim();
    } else {
        console.error('Format de titre incorrect. Assurez-vous que le titre est "Nom de la tâche : PK".');
        return null;
    }
}

//#####################################
//  Liste de toute les tasks d'un projet
//####################################
//v3
function getTasksProjet(projetPK) {
    console.log("Récupération des tâches du projet pour la PK :" + projetPK)

    getTasksProjetAJax(projetPK, function (response) {
        console.log(response); // Vérifiez la structure de la réponse pour vous assurer qu'elle est correcte
        alert("Affichage des tâches");

        // Supprimer tous les déjà présents dans les blocs
        var containerKeys = Object.keys(blockValues);
        containerKeys.forEach(function (key) {
            var container = document.getElementById(key);
            if (container) {
                while (container.firstChild) {
                    container.removeChild(container.firstChild);
                }
            } else {
                console.error("Element de bloc non trouvé pour la clé : ", key);
            }
        });

        // Parcourir les tâches dans la réponse et créer un conteneur pour chaque tâche
        response.forEach(function (taskData) {
            var redContainer = document.createElement("div");
            redContainer.className = "tache-bloc block";

            // Assigner la clé primaire de la tâche comme attribut personnalisé de l'élément de bloc
            redContainer.dataset.value = taskData.PK_Tache;

            // Make the container draggable
            redContainer.draggable = true;

            // Create the editable text field
            var editableText = document.createElement("textarea");
            editableText.value = taskData.Nom; // Utiliser la valeur de Nom comme contenu du textarea
            editableText.className = "editable-text";
            redContainer.appendChild(editableText);

            // Add a title containing the task's primary key
            var titleElement = document.createElement("span");
            titleElement.textContent = "Tâche numéro : " + taskData.PK_Tache;
            titleElement.classList.add("task-title");
            redContainer.appendChild(titleElement);

            // Identifier le bloc correspondant en fonction de l'état de la tâche
            var blockKey = Object.keys(blockValues).find(key => blockValues[key] === taskData.Etat);
            if (!blockKey) {
                blockKey = "Todo-Block"; // Par défaut, ajouter au bloc "À faire"
            }

            // Ajouter le conteneur à l'élément correspondant
            var todoBlock = document.getElementById(blockKey);
            if (todoBlock) {
                todoBlock.appendChild(redContainer);
            } else {
                console.error("Element de bloc non trouvé pour la clé : ", blockKey);
            }
        });
    }, function (error) {
        // Supprimer tous les éléments des blocs en cas d'erreur
        var containerKeys = Object.keys(blockValues);
        containerKeys.forEach(function (key) {
            var container = document.getElementById(key);
            if (container) {
                while (container.firstChild) {
                    container.removeChild(container.firstChild);
                }
            } else {
                console.error("Element de bloc non trouvé pour la clé : ", key);
            }
        });

        // Callback d'erreur
        alert("Aucune tâche pour ce projet");
    });
}


        //##########################################
        // crée projet pour user connecter
        //##########################################

        const newProjectButton = document.getElementById("add-new-projet");

        newProjectButton.addEventListener("click", function () {
            var pkUser = window.sessionStorage.getItem('PKuser');
            var projectName = document.getElementById("project-name").value;


            if (projectName.length > 0) {

                console.log("Créer projet pour l'utilisateur : " + pkUser + " avec les valeurs :" + projectName);

                createUserProjetAjax(pkUser, projectName, function (response) {
                    // Callback de succès
                    var message = response.message;
                    alert(message);

                }, function (error) {
                    var message = error.message;
                    alert(message);

                });

            } else {
                alert("Veuillez remplir tous les champs !");
            }
        });
 



