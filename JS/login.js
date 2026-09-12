const formulario = document.querySelector("#formulario-login");
const validation = document.querySelector(".validation-1");
const validation2 = document.querySelector(".validation-2");

const email = document.querySelector("#email");
const password = document.querySelector("#password");

formulario.addEventListener("submit", (event) => {
    event.preventDefault();

    const emailValue = email.value.trim();
    const passwordValue = password.value;

    validation.textContent = "";
    validation2.textContent = "";

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (emailValue === "") {
        validation.textContent = "El campo no puede estar vacío";
    } else if (!emailRegex.test(emailValue)) {
        validation.textContent = "El correo no es válido";
    }

    if (passwordValue === "") {
        validation2.textContent = "El campo no puede estar vacío";
    }
});