  document.getElementById("biodataForm").addEventListener("submit", function(event) {

            event.preventDefault();

            let name = document.getElementById("name").value.trim();
            let matric = document.getElementById("matric").value.trim();
            let email = document.getElementById("email").value.trim();
            let phone = document.getElementById("phone").value.trim();
            let gender = document.getElementById("gender").value;
            let department = document.getElementById("department").value.trim();
            let age = document.getElementById("age").value;
            let message = document.getElementById("message");

            if (name === "" || matric === "" || email === "" ||
                phone === "" || gender === "" || department === "" || age === "") {

                message.textContent = "Please fill in all fields.";
                message.style.color = "red";
                return;
            }

            if (phone.length < 10) {
                message.textContent = "Please enter a valid phone number.";
                message.style.color = "red";
                return;
            }

            if (age < 10 || age > 100) {
                message.textContent = "Please enter a valid age.";
                message.style.color = "red";
                return;
            }

            message.textContent = "Form submitted successfully!";
            message.style.color = "green";

            this.reset();
        });