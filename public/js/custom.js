// Custom JavaScript for the project
document.addEventListener("DOMContentLoaded", function() {
    // Example: Simple form validation
    const form = document.querySelector("form");
    if (form) {
        form.addEventListener("submit", function(event) {
            const nameInput = form.querySelector("input[name='name']");
            if (!nameInput.value) {
                alert("Please enter your name.");
                event.preventDefault(); // Prevent form submission
            }
        });
    }
});
