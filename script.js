document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('feedbackForm');

    const submissionDateField = document.getElementById('submission_date');
    const currentDate = new Date();
    const formattedDate = currentDate.toISOString().slice(0, 16);
    submissionDateField.value = formattedDate;

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const feedback = document.getElementById('feedback').value.trim();
        const rating = document.getElementById('rating').value;

        if (name === "" || email === "" || feedback === "" || rating === "") {
            alert("All fields are required!");
            return;
        }

        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email)) {
            alert("Please enter a valid email address!");
            return;
        }

        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'submit_feedback.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                
                console.log(xhr.responseText); 
                alert('Feedback submitted successfully!');
                form.reset();
            } else {
                alert('Error submitting feedback. Please try again later.');
            }
        };

        xhr.onerror = function() {
            alert('Network error occurred. Please check your connection and try again.');
        };

        xhr.send(new URLSearchParams(formData).toString());
    });
});
