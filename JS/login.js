const formulario = document.querySelector("#formulario-login");
const validation = document.querySelector(".validation-1");
const validation2 = document.querySelector(".validation-2");

const email = document.querySelector("#email");
const password = document.querySelector("#password");

formulario.addEventListener("submit", (event) => {
    event.preventDefault();

    const emailValue = email.value.trim();
    const passwordValue = password.value;

    const valid = validationForm(emailValue, passwordValue);

    if (!valid) {
        return;
    }
});

function validationForm(emailValue, passwordValue) {
    let valid = true;

    validation.textContent = "";
    validation2.textContent = "";

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (emailValue === "") {
        validation.textContent = "El campo no puede estar vacío";
        valid = false;
    } else if (!emailRegex.test(emailValue)) {
        validation.textContent = "El correo no es válido";
        valid = false;
    }

    if (passwordValue === "") {
        validation2.textContent = "El campo no puede estar vacío";
        valid = false;
    }

    return valid;
}