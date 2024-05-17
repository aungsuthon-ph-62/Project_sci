const form = document.querySelector("form");
const submitBtn = form.querySelector('button[type="submit"]');

form.addEventListener("submit", (event) => {
  event.preventDefault();

  const firstNameInput = document.querySelector("#signup_fname");
  const lastNameInput = document.querySelector("#signup_lname");
  const emailInput = document.querySelector("#signup_email");
  const passwordInput = document.querySelector("#signup_password");
  const confirmPasswordInput = document.querySelector(
    "#signup_confirm_password"
  );

  const firstName = firstNameInput.value.trim();
  const lastName = lastNameInput.value.trim();
  const email = emailInput.value.trim();
  const password = passwordInput.value.trim();
  const confirmPassword = confirmPasswordInput.value.trim();
  const role = selectInput.value;

  // validate select input
  if (role === "") {
    showError(selectInput, "กรุณาเลือกสถานะผู้ใช้");
  } else {
    showSuccess(selectInput);
  }

  // validate first name
  if (firstName === "") {
    showError(firstNameInput, "กรุณากรอกชื่อจริง");
  } else {
    showSuccess(firstNameInput);
  }

  // validate last name
  if (lastName === "") {
    showError(lastNameInput, "กรุณากรอกนามสกุล");
  } else {
    showSuccess(lastNameInput);
  }

  // validate email
  if (email === "") {
    showError(emailInput, "กรุณากรอกอีเมลล์");
  } else {
    isInvalidEmail(emailInput, email);
  }

  // validate password
  if (password === "") {
    showError(passwordInput, "กรุณากรอกรหัสผ่าน");
  } else if (password.length < 8) {
    showError(passwordInput, "รหัสผ่านต้องมี 8 ตัว หรือมากกว่า");
  } else {
    showSuccess(passwordInput);
  }

  // validate confirm password
  if (confirmPassword === "") {
    showError(confirmPasswordInput, "กรุณายืนยันรหัสผ่าน");
  } else if (password !== confirmPassword) {
    showError(confirmPasswordInput, "รหัสผ่านไม่ตรงกัน");
  } else {
    showSuccess(confirmPasswordInput);
  }

  firstNameInput.addEventListener("keyup", () => {
    showSuccess(firstNameInput);
  });

  lastNameInput.addEventListener("keyup", () => {
    showSuccess(lastNameInput);
  });

  // check if all inputs are valid before submitting the form
  if (form.querySelectorAll(".is-invalid").length === 0) {
    // disable the submit button to prevent double submissions
    submitBtn.disabled = true;

    // create a FormData object to store the form data
    const formData = new FormData();
    formData.append("first_name", firstName);
    formData.append("last_name", lastName);
    formData.append("email", email);
    formData.append("password", password);
    formData.append("role", role);

    // send the form data to the server using AJAX
    fetch("/Project_sci/private/app/controller/signUp.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.error) {
          console.log(data.error);
          // Show error message to user
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: data.error,
            timer: "1500",
            showConfirmButton: true,
            focusConfirm: true,
          }).then(() => {
            submitBtn.disabled = false;
          });
        } else {
          // Show success message to user
          Swal.fire({
            icon: "success",
            title: "สมัครสมาชิกสำเร็จ!",
            text: data.message,      
            timer: "1500",
            showConfirmButton: true,
            focusConfirm: true,
          }).then(() => {
            form.reset();
            window.location.href = "login";
          });
        }
      })
      .catch((error) => {
        console.log(error);
        // Show error message to user
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "สมัครสมาชิกไม่สำเร็จ กรุณาลองใหม่อีกครั้ง",
          timer: "1500",
          showConfirmButton: true,
          focusConfirm: true,
        }).then(() => {
          submitBtn.disabled = false;
        });
      });
  }
});

function isInvalidEmail(input, email) {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!regex.test(email)) {
    showError(input, "กรุณากรอกอีเมลล์ให้ถูกต้อง");
    return true;
  } else {
    showSuccess(input);
    return false;
  }
}

function showError(input, message) {
  const formControl = input.parentElement;
  const successMsg = formControl.querySelector(".success-message");
  let errorMsg = formControl.querySelector(".error-message");

  input.classList.add("is-invalid");

  if (errorMsg === null) {
    // Create the error message element if it doesn't exist
    errorMsg = document.createElement("div");
    errorMsg.classList.add("invalid-feedback");
    errorMsg.classList.add("error-message");
    formControl.appendChild(errorMsg);
  }

  errorMsg.innerText = message;

  if (successMsg !== null) {
    successMsg.innerText = "";
  }
}

function showSuccess(input) {
  const formControl = input;
  const successMsg = formControl.querySelector(".success-message");
  const errorMsg = formControl.querySelector(".error-message");

  // remove any previous validation classes
  formControl.classList.remove("is-invalid");

  if (input.value.trim() !== "") {
    // add the validation class
    formControl.classList.add("is-valid");
    // hide any error message
    if (errorMsg !== null) {
      errorMsg.innerText = "";
    }
    // show success message if available
    if (successMsg !== null) {
      successMsg.innerText = "Looks good!";
    }
  } else {
    // hide any success message
    if (successMsg !== null) {
      successMsg.innerText = "";
    }
  }
}
