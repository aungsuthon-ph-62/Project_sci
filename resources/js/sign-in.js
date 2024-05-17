const form = document.querySelector('form');
const submitBtn = form.querySelector('button[type="submit"]');

form.addEventListener('submit', (event) => {
    event.preventDefault();

    const emailInput = document.querySelector('#signin_email');
    const passwordInput = document.querySelector('#signin_password');

    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();

    // validate email
    if (email === '') {
        showError(emailInput, 'กรุณากรอกอีเมลล์');
    } else {
        isInvalidEmail(emailInput, email);
    }

    // validate password
    if (password === '') {
        showError(passwordInput, 'กรุณากรอกรหัสผ่าน');
    } else if (password.length < 8) {
        showError(passwordInput, 'รหัสผ่านต้องมี 8 ตัว หรือมากกว่า');
    } else {
        showSuccess(passwordInput);
    }


    // check if all inputs are valid before submitting the form
    if (form.querySelectorAll('.is-invalid').length === 0) {
        // disable the submit button to prevent double submissions
        submitBtn.disabled = true;

        // create a FormData object to store the form data
        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);

        // send the form data to the server using AJAX
        fetch('/Project_sci/private/app/controller/signIn.php', {
            method: 'POST',
            body: formData
        }).then(response => response.json()).then(data => {
            if (data.error) {
                console.log(data.error);
                // Show error message to user
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
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
                    title: "สำเร็จ!",
                    text: "เข้าสู่ระบบสำเร็จ",
                    timer: "1500",
                    showConfirmButton: true,
                    focusConfirm: true,
                }).then(() => {
                    form.reset();
                    window.location.href = 'index';
                });
            }
        })
            .catch(error => {
                console.log(error);
                // Show error message to user
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "เข้าสู่ระบบไม่สำเร็จ กรุณาลองใหม่อีกครั้ง",
                    timer: "1500",
                    showConfirmButton: true,
                    focusConfirm: true,
                }).then(() => {
                    submitBtn.disabled = false;
                });
            });
    }
});

function showError(input, message) {
    const formControl = input.parentElement;
    const successMsg = formControl.querySelector('.success-message');
    let errorMsg = formControl.querySelector('.error-message');

    input.classList.add('is-invalid');

    if (errorMsg === null) {
        // Create the error message element if it doesn't exist
        errorMsg = document.createElement('div');
        errorMsg.classList.add('invalid-feedback');
        errorMsg.classList.add('error-message');
        formControl.appendChild(errorMsg);
    }

    errorMsg.innerText = message;

    if (successMsg !== null) {
        successMsg.innerText = '';
    }
}

function showSuccess(input) {
    const formControl = input;
    const successMsg = formControl.querySelector('.success-message');
    const errorMsg = formControl.querySelector('.error-message');

    // remove any previous validation classes
    formControl.classList.remove('is-invalid');

    if (input.value.trim() !== '') {
        // add the validation class
        formControl.classList.add('is-valid');
        // hide any error message
        if (errorMsg !== null) {
            errorMsg.innerText = '';
        }
        // show success message if available
        if (successMsg !== null) {
            successMsg.innerText = 'Looks good!';
        }
    } else {
        // hide any success message
        if (successMsg !== null) {
            successMsg.innerText = '';
        }
    }
}

function isInvalidEmail(input, email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regex.test(email)) {
        showError(input, 'กรุณากรอกอีเมลล์ให้ถูกต้อง');
        return true;
    } else {
        showSuccess(input);
        return false;
    }
}

function isEmptyPassword(input, password) {
    if (password === '') {
        showError(input, 'กรุณากรอกรหัสผ่าน');
        return true;
    } else if (password.length < 8) {
        showError(input, 'รหัสผ่านต้องมี 8 ตัว หรือมากกว่า');
        return true;
    } else {
        showSuccess(input);
        return false;
    }
}

const emailInput = document.querySelector('#signin_email');
emailInput.addEventListener('keyup', (event) => {
    const email = emailInput.value.trim();
    if (email !== '') {
        isInvalidEmail(emailInput, email);
    } else {
        showError(emailInput, 'กรุณากรอกอีเมลล์');
    }
});

const passwordInput = document.querySelector('#signin_password');
passwordInput.addEventListener('keyup', (event) => {
    const password = passwordInput.value.trim();
    if (password !== '') {
        isEmptyPassword(passwordInput, password);
    } else {
        showError(passwordInput, 'กรุณากรอกพาสเวิร์ด');
    }
});

