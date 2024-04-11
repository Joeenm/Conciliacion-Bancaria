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
