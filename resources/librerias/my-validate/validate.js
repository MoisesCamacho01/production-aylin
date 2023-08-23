function validate(inputs = []) {
	let array = JSON.parse(JSON.stringify(inputs));
	let value = "";
	let response = true;
	if (inputs.length === 0) {
		return false;
	}

	array.forEach((input) => {
		if (((input.value === "") || (input.value === undefined)) && input.required === true) {
			document.querySelector(
				`span[name=${input.name}]`
			).textContent = `El campo ${input.campo} es obligatorio`;
			toast("bg-danger", "Campo Obligatorio", `El campo ${input.campo} es obligatorio`,1);
			response = false;
		}

		if (response) {
			if (
				input.type === "string" ||
				input.type === "text" ||
				input.type === "integer" ||
				input.type === "decimal" ||
				input.type === "email" ||
				input.type === "number" ||
				input.type === "cedula"
			) {
				value = input.value;
				document.querySelector(`span[name=${input.name}]`).textContent = ``;
				if (
					input.type === "string" ||
					input.type === "text" ||
					input.type === "email" ||
					input.type === "number"
				) {

					if (value.length < input.min) {
						document.querySelector(
							`span[name=${input.name}]`
						).textContent = `El campo ${input.campo} no puede ser menor que ${input.min} caracteres`;
						toast("bg-danger", "Cantidad minima", `El campo ${input.campo} no puede ser menor que ${input.min} caracteres`,1);
						response = false;
					} else if (value.length > input.max) {
						document.querySelector(
							`span[name=${input.name}]`
						).textContent = `El campo ${input.campo} no puede ser mayor que ${input.max} caracteres`;
						toast("bg-danger", "Cantidad maxima", `El campo ${input.campo} no puede ser mayor que ${input.max} caracteres`,1);
						response = false;
					}
				} else if(input.type === "integer" || input.type === "decimal") {
					if (value * 1 < input.min) {
						document.querySelector(
							`span[name=${input.name}]`
						).textContent = `El campo ${input.campo} no puede ser menor que ${input.min}`;
						toast("bg-danger", "Cantidad minima", `El campo ${input.campo} no puede ser menor que ${input.min}`,1);
						response = false;
					} else if (value * 1 > input.max) {
						document.querySelector(
							`span[name=${input.name}]`
						).textContent = `El campo ${input.campo} no puede ser mayor que ${input.max}`;
						toast("bg-danger", "Cantidad maxima", `El campo ${input.campo} no puede ser mayor que ${input.max}`,1);
						response = false;
					}
				}
			}

			if (input.type === "text") {

				let num = /\d/;

				if (num.test(value)) {
					document.querySelector(
						`span[name=${input.name}]`
					).textContent = `El campo ${input.campo} no puede tener números`;
					toast("bg-danger", "Dato no compatible", `El campo ${input.campo} no puede tener números`,1);
					response = false;
				}
			}

			if (input.type === "integer") {

				if (!isNaN(value)) {
					if (!Number.isInteger(value)) {
						document.querySelector(
							`span[name=${input.name}]`
						).textContent = `El campo ${input.campo} tienen que ser entero`;
						toast("bg-danger", "Dato no compatible", `El campo ${input.campo} tienen que ser entero`,1);
						response = false;
					}
				} else {

					response = false;
				}
			}

			if (input.type === "decimal") {

				if (isNaN(value)) {
					document.querySelector(
						`span[name=${input.name}]`
					).textContent = `El campo ${input.campo} no puede tener letras o caracteres especiales`;
					toast("bg-danger", "Dato no compatible", `El campo ${input.campo} no puede tener letras o caracteres especiales`,1);
					response = false;
				}
			}

			if (input.type === "email") {

				let email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
				if (!email.test(value)) {
					document.querySelector(
						`span[name=${input.name}]`
					).textContent = `El campo ${input.campo} Tiene que ser un email`;
					toast("bg-danger", "Dato no compatible", `El campo ${input.campo} Tiene que ser un email`,1);
					response = false;
				}
			}

			if (input.type === "number") {

				if (isNaN(value)) {
					document.querySelector(
						`span[name=${input.name}]`
					).textContent = `El campo ${input.campo} no puede tener letras o caracteres especiales`;
					toast("bg-danger", "Dato no compatible", `El campo ${input.campo} no puede tener letras o caracteres especiales`,1);
					response = false;
				}
			}
		}

		if (input.type === "cedula") {

			// Verificar longitud y formato
			if (value.length !== 10 || !/^\d+$/.test(value)) {
				response = false;
			}

			// Extraer dígitos de la cédula
			var digitosRestantes = value.substring(0, 9);
			var digitoVerificador = Number(value.substring(9));

			// Verificar el dígito verificador
			var suma = 0;
			for (var i = 0; i < digitosRestantes.length; i++) {
				var digito = Number(digitosRestantes.charAt(i));
				if (i % 2 === 0) {
					digito *= 2;
					if (digito > 9) {
						digito -= 9;
					}
				}
				suma += digito;
			}

			var digitoCalculado = 10 - (suma % 10);
			if (digitoCalculado === 10) {
				digitoCalculado = 0;
			}

			if (digitoCalculado != digitoVerificador) {
				document.querySelector(`span[name=${input.name}]`).textContent =
					"La cédula es obligatoria o esta incorrecta";
				toast("bg-danger", "La cédula es obligatoria", `La cédula es obligatoria o esta incorrecta`,1);
				response = false;
			}
		}
	});

	return response;
}
