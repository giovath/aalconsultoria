exports.handler = async (event) => {

    if (event.httpMethod !== "POST") {
        return {
            statusCode: 405,
            body: JSON.stringify({
                message: "Método não permitido."
            })
        };
    }

    try {

        const body = JSON.parse(event.body);

        const response = await fetch(
            "https://api.brevo.com/v3/contacts",
            {
                method: "POST",

                headers: {
                    "api-key": process.env.BREVO_API_KEY,
                    "Content-Type": "application/json"
                },

                body: JSON.stringify({

                    email: body.email,

                    updateEnabled: true,

                    listIds: [7],

                    attributes: {

                        NOME: body.nome || "",

                        TELEFONE: body.telefone || "",

                        WHATSAPP: body.whatsapp || "",

                        MENSAGEM: body.mensagem || "",

                        TIPO: body.tipo || ""

                    }

                })

            }
        );


        const result = await response.text();


        return {

            statusCode: response.status,

            body: JSON.stringify({
                success: true,
                response: result
            })

        };


    } catch (error) {

        return {

            statusCode: 500,

            body: JSON.stringify({
                message: error.message
            })

        };

    }

};