const formulario = document.getElementById("register-form");
const nameInput = document.getElementById("name");
const email = document.getElementById("email");
const password = document.getElementById("password");
const passwordConfirm = document.getElementById("password_confirm");
const registerMessage = document.querySelector(".register-message");

formulario.addEventListener("submit", async (event) => {
    event.preventDefault();

    if (password.value !== passwordConfirm.value) {
        registerMessage.textContent = "Las contraseñas no coinciden";
        return;
    }

    const userData = {
        name: nameInput.value,
        email: email.value,
        password: password.value,
        accion: "register"
    };

    try {
        const respuesta = await fetch("../php/User/procesos.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(userData)
        });

        const data = await respuesta.json();

        if (data.statusCode === 201) {
            window.location.href = "../index.php";
        } else {
            registerMessage.textContent = data.message;
        }
    } catch (error) {
        console.log("Hubo un problema con la peticion", error);
        registerMessage.textContent = "No se pudo conectar con el servidor";
    }
});
