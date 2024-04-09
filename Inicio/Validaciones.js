function SoloLetras(evento) {
    var letras = (evento.which) ? evento.which : evento.keyCode;
    if (letras == 8 || letras == 32) {
        return true;
    } else if ((letras >= 65 && letras <= 90) || (letras >= 97 && letras <= 122)) {
        return true;
    } else {
        return false;
    }
}

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

function actualizarMonto() {
    // Obtener el valor ingresado en el primer input
    var valorSuma = document.getElementById("suma-de").value;

    // Mostrar el mismo valor en el segundo input
    document.getElementById("monto-1").value = valorSuma;
}

// Alerta de confirmación
document.addEventListener("DOMContentLoaded", function() {
    const botonGuardar = document.querySelector(".boton");
  
    botonGuardar.addEventListener("click", function() {
      const campos = document.querySelectorAll("input[type='text'], input[type='date'], select");
      let camposVacios = false;
  
      campos.forEach(function(campo) {
        if (campo.value.trim() === "") { // Verifica que el campo no esté vacío
          camposVacios = true;
          return;
        }
      });
  
      if (camposVacios) {
        alert("Por favor completar todos los campos.");
      } else {
        // Aquí puedes agregar la lógica para guardar los datos
        console.log("Todos los campos están llenos. Guardando datos...");
      }
    });
  });

// Función para convertir un número a letras
/* function numeroALetras(numero) {
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
} */