<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ValidateController
{
	public function validate($inputs = [])
	{
		$array = json_decode(json_encode($inputs), true);
		$value = "";
		$response = (object)[
			"message" => "correcto",
			"status" => true
		];

		if (count($inputs) === 0) {
			return false;
		}

		foreach ($array as $input) {
			if (($input['value'] === "" || $input['value'] === null) && $input['required'] === true) {
				$response->message = "El campo {$input['name']} es obligatorio";
				$response->status = false;
			}

			if ($response->status) {
				if (
					$input['type'] === "string" ||
					$input['type'] === "text" ||
					$input['type'] === "integer" ||
					$input['type'] === "decimal" ||
					$input['type'] === "email" ||
					$input['type'] === "number" ||
					$input['type'] === "cedula"
				) {
					$value = $input['value'];

					if (
						$input['type'] === "string" ||
						$input['type'] === "text" ||
						$input['type'] === "email" ||
						$input['type'] == 'number'
					) {
						if (strlen($value) < $input['min']) {
							$response->message = "El campo {$input['name']} no puede ser menor que {$input['min']} caracteres";
							$response->status = false;
						} else if (strlen($value) > $input['max']) {
							$response->message = "El campo {$input['name']} no puede ser mayor que {$input['max']} caracteres";
							$response->status = false;
						}
					}elseif($input['type'] == 'decimal' || $input['type'] == 'integer'){
						if ($value < $input['min']) {
							$response->message = "El campo {$input['name']} no puede ser menor que {$input['min']}";
							$response->status = false;
						} else if ($value > $input['max']) {
							$response->message = "El campo {$input['name']} no puede ser mayor que {$input['max']}";
							$response->status = false;
						}
					}
				}

				if ($input['type'] === "text") {
					if (preg_match('/\d/', $value)) {
						$response->message = "El campo {$input['name']} no puede tener números";
						$response->status = false;
					}
				}

				if ($input['type'] === "integer") {
					if (!is_int($value)) {
						$response->message = "El campo {$input['name']} tienen que ser entero";
						$response->status = false;
					}
				}

				if ($input['type'] === "decimal") {
					if (!is_numeric($value)) {
						$response->message = "El campo {$input['name']} no puede tener letras o caracteres especiales";
						$response->status = false;
					}
				}

				if ($input['type'] === "email") {
					if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
						$response->message = "El campo {$input['name']} Tiene que ser un email";
						$response->status = false;
					}
				}

				if ($input['type'] === "number") {
					if($value == "") $value = 0;
					if (!is_numeric($value)) {
						$response->message = "El campo {$input['name']} no puede tener letras o caracteres especiales";
						$response->status = false;
					}
				}

				if ($input['type'] === "cedula") {
					if (strlen($value) !== 10 || !preg_match('/^\d+$/', $value)) {
						$response->message = "La cédula es obligatoria o está incorrecta";
						$response->status = false;
					}

					$digitosRestantes = substr($value, 0, 9);
					$digitoVerificador = (int)substr($value, 9);

					$suma = 0;
					for ($i = 0; $i < strlen($digitosRestantes); $i++) {
						$digito = (int)$digitosRestantes[$i];
						if ($i % 2 === 0) {
							$digito *= 2;
							if ($digito > 9) {
								$digito -= 9;
							}
						}
						$suma += $digito;
					}

					$digitoCalculado = 10 - ($suma % 10);
					if ($digitoCalculado === 10) {
						$digitoCalculado = 0;
					}

					if ($digitoCalculado != $digitoVerificador) {
						$response->message = "La cédula está incorrecta";
						$response->status = false;
					}
				}
			}
		}

		return $response;
	}
}


/* End of file ValidateController.php */
/* Location: ./application/controllers/ValidateController.php */
