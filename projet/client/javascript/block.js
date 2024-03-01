// Function to handle task addition
function addTask() {
  var todoBlock = document.getElementById("Todo-Block");
  var redContainer = document.createElement("div");
  redContainer.className = "tache-bloc block"; // Add the "block" class
  redContainer.draggable = true; // Make the container draggable
  
  // Create a text area
  var editableText = document.createElement("textarea");
  editableText.placeholder = "Votre texte ici";
  editableText.className = "editable-text"; // Add the "editable-text" class
  redContainer.appendChild(editableText);

  todoBlock.appendChild(redContainer);
}

// Function to handle dragover event
function handleDragOver(e) {
  e.preventDefault();
  const draggable = document.querySelector('.tache-bloc.dragging');
  if (draggable) {
      this.appendChild(draggable);
  }
}

// Function to handle drop event
function handleDrop(e) {
  e.preventDefault();
  const draggable = document.querySelector('.tache-bloc.dragging');
  if (draggable) {
      this.appendChild(draggable);
      draggable.classList.remove('dragging');
      logDropMessage(this); // Call the function to log drop message
  }
}

// Function to handle drag start event
function handleDragStart(e) {
  if (e.target.classList.contains('tache-bloc')) {
      e.target.classList.add('dragging');
  }
}

// Function to handle drag end event
function handleDragEnd(e) {
  if (e.target.classList.contains('tache-bloc')) {
      e.target.classList.remove('dragging');
  }
}
 
// Function to log the drop message
function logDropMessage(container) {
  console.log("Dropped onto block: " + container.id);
}

// Add event listeners
document.getElementById("add-task-btn").addEventListener("click", addTask);

var containers = document.querySelectorAll('.block');

containers.forEach(container => {
  container.addEventListener('dragover', handleDragOver);
  container.addEventListener('drop', handleDrop);
});

document.addEventListener('dragstart', handleDragStart);
document.addEventListener('dragend', handleDragEnd);
