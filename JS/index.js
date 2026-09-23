const formulario = document.getElementById("formulario-login");
const email = document.getElementById("email");
const password = document.getElementById("password");
const validationEmail = document.querySelector(".validation-1");
const validationPassword = document.querySelector(".validation-2");
const loginMessage = document.querySelector(".login-message");

formulario.addEventListener("submit", async (event) => {
    event.preventDefault();

    const emailValue = email.value;
    const passwordValue = password.value;

    const valid = validationForm(emailValue, passwordValue);

    if (!valid) {
        return;
    }

    const userData = {
        user: emailValue,
        password: passwordValue,
        accion: "login"
    };

    try {
        const data = await sendData(userData);

        if (data.statusCode === 200) {
            loginMessage.textContent = "Exito";
        } else {
            loginMessage.textContent = "Usuario y/o contraseña no validos";
        }
    } catch (error) {
        console.log("Hubo un problema con la peticion", error);
        loginMessage.textContent = "No se pudo conectar con el servidor";
    }
});

function validationForm(emailValue, passwordValue) {
    let valid = true;

    validationEmail.textContent = "";
    validationPassword.textContent = "";

    if (emailValue == "") {
        validationEmail.textContent = "El campo no puede estar vacio";
        valid = false;
    } else {
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        if (!emailRegex.test(emailValue)) {
            validationEmail.textContent = "El correo no es valido";
            valid = false;
        }
    }

    if (passwordValue == "") {
        validationPassword.textContent = "El campo no puede estar vacio";
        valid = false;
    }

    return valid;
}

async function sendData(userData) {
    const respuesta = await fetch("php/User/procesos.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(userData)
    });

    return respuesta.json();
}
