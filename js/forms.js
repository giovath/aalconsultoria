document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll("form").forEach(form => {

        form.addEventListener("submit", async (e) => {

            e.preventDefault();

            const button = form.querySelector("button");
            const originalText = button.innerHTML;

            button.disabled = true;
            button.innerHTML = "Enviando...";

            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            try {

                const response = await fetch("/.netlify/functions/submit-form", {

                    method: "POST",

                    headers: {
                        "Content-Type": "application/json"
                    },

                    body: JSON.stringify(data)

                });

                if (!response.ok) {
                    throw new Error("Erro ao enviar.");
                }

                button.innerHTML = "✓ Enviado!";

                form.reset();

                setTimeout(() => {

                    button.disabled = false;
                    button.innerHTML = originalText;

                }, 2500);

            } catch (err) {

                console.error(err);

                button.disabled = false;
                button.innerHTML = "Tentar novamente";

                alert("Não foi possível enviar o formulário.");

            }

        });

    });

});