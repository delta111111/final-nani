// Get the modal
const modal = document.getElementById("myModal");

// Get the button that opens the modal
const btn = document.getElementById("openModalBtn");

// Get the <span> element that closes the modal
const span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    closeModal();
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        closeModal();
    }
}

// Function to close the modal
function closeModal() {
    modal.style.display = "none";
}

// Handle form submission
document.getElementById("modalForm").onsubmit = function(event) {
    event.preventDefault(); // Prevent form submission
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;

    // You can add code here to handle the data as needed
    console.log(`Name: ${name}, Email: ${email}`);
    
    closeModal(); // Close the modal after submission
}