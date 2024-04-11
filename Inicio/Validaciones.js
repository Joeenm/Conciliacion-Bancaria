/* function SoloLetras(evento) {
    var letras = (evento.which) ? evento.which : evento.keyCode;
    if (letras == 8 || letras == 32) {
        return true;
    } else if ((letras >= 65 && letras <= 90) || (letras >= 97 && letras <= 122)) {
        return true;
    } else {
        return false;
    }
} */

function SoloNumeros(evento) {
    var tomo = (evento.which) ? evento.which : evento.keyCode;
    var valor = evento.target.value;

    // Verificar si la tecla presionada es un número y la longitud del valor es menor o igual a 4
    if ((tomo >= 48 && tomo <= 57) && valor.length <= 4) {
        return true; // Permitir la entrada
    } else {
        return false; // Bloquear la entrada
    }
}

function SoloDinero(evento) {
    var dinero = (evento.which) ? evento.which : evento.keyCode;
    var input = evento.target.value;
    if (input.indexOf('.')!== -1){
        var parte = input.split('.');
        if(parte[1].length>=2){
            return false;
        }
    }
    
    if ((dinero === 46 && input.indexOf('.') === -1)||(dinero >= 48 && dinero <= 57)) {
        return true;
    } else {
        return false;
    }
}

// Función para convertir un número a letras
/*function numeroALetras(numero) {
    // Array de unidades
    var unidades = ['Cero', 'Uno', 'Dos', 'Tres', 'Cuatro', 'Cinco', 'Seis', 'Siete', 'Ocho', 'Nueve'];

    // Array de decenas hasta el veinte
    var decenasHasta20 = ['Diez', 'Once', 'Doce', 'Trece', 'Catorce', 'Quince', 'Dieciséis', 'Diecisiete', 'Dieciocho', 'Diecinueve'];

    // Array de decenas
    var decenas = ['', '', 'Veinte', 'Treinta', 'Cuarenta', 'Cincuenta', 'Sesenta', 'Setenta', 'Ochenta', 'Noventa'];

    // Array de centenas
    var centenas = ['', 'Ciento', 'Doscientos', 'Trescientos', 'Cuatrocientos', 'Quinientos', 'Seiscientos', 'Setecientos', 'Ochocientos', 'Novecientos'];

    // Array de miles
    var miles = ['', 'Mil', 'Millón', 'Mil Millones'];

    // Función para obtener el nombre de un número entre 1 y 999
    function nombreNumero(n) {
        if (n < 10) {
            return unidades[n];
        } else if (n < 20) {
            return decenasHasta20[n - 10];
        } else if (n < 100) {
            var unidad = n % 10;
            return decenas[Math.floor(n / 10)] + (unidad !== 0 ? ' y ' + unidades[unidad] : '');
        } else {
            var centena = Math.floor(n / 100);
            var decena = n % 100;
            return centenas[centena] + (decena !== 0 ? ' ' + nombreNumero(decena) : '');
        }
    }

    // Función para convertir un número entero a letras
    function convertirEnteroALetras(entero) {
        if (entero === 0) {
            return unidades[entero];
        } else {
            var letras = '';
            var contador = 0;
            while (entero > 0) {
                var grupo = entero % 1000;
                if (grupo > 0) {
                    letras = nombreNumero(grupo) + ' ' + miles[contador] + ' ' + letras;
                }
                entero = Math.floor(entero / 1000);
                contador++;
            }
            return letras.trim();
        }
    }

    // Función para convertir un número decimal a letras
    function convertirDecimalALetras(decimal) {
        if (decimal === 0) {
            return '';
        } else {
            var letrasDecimal = '';
            var decimalSplit = String(decimal).split('.');
            if (decimalSplit.length === 2) {
                var parteDecimal = Number(decimalSplit[1]);
                if (parteDecimal > 0) {
                    letrasDecimal = ' punto ' + convertirEnteroALetras(parteDecimal);
                }
            }
            return letrasDecimal.trim();
        }
    }

    // Convertir el número a letras
    var resultado = '';
    if (numero === 0) {
        resultado = unidades[numero];
    } else if (numero < 0) {
        resultado = 'Menos ' + convertirEnteroALetras(-numero);
    } else {
        var numeroEntero = Math.floor(numero);
        var numeroDecimal = numero - numeroEntero;
        resultado = convertirEnteroALetras(numeroEntero) + convertirDecimalALetras(numeroDecimal);
    }

    return resultado;
}

// Función para convertir el número ingresado a letras y mostrarlo en el campo "suma"
function convertirNumeroALetras() {
    // Obtener el valor del campo "suma-de"
    var numero = document.getElementById("suma-de").value;

    // Convertir el número a letras usando la función numeroALetras y mostrarlo en el campo "suma"
    document.getElementById("suma").value = numeroALetras(Number(numero));
}
*/
    // Definir una función estática para el AJAX
    function hacerAjax() {
        var numeroCheque = $("#numero-cheque").val();
        console.log("Evento de clic del botón ejecutado correctamente.");
        console.log("Número de Cheque enviado desde el ajax(esto es el archivo js): " + numeroCheque)
        $.ajax({
            url: "Campos.php", 
            type: "POST", 
            data: { numero_cheque: numeroCheque },
            success: function(data) {
                console.log("Datos recibidos del servidor: ", data); // Verificar los datos recibidos en la consola del navegador
                data = JSON.parse(data); // Convertir el JSON recibido en un objeto JavaScript
                $("#fecha").val(data.fecha); // Asignar la fecha a un campo con ID "fecha"
                $("#p-orden-a").val(data.beneficiario); // Asignar el beneficiario a un campo con ID "beneficiario"
                $("#monto").val(data.monto); // Asignar el monto a un campo con ID "monto"
                $("#descripcion").val(data.descripcion); // Asignar la descripción a un campo con ID "descripcion"
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            }
        });
    }
