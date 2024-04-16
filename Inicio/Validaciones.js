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
/*document.addEventListener("DOMContentLoaded", function() {
    const botonGuardar = document.querySelector(".boton");
  
    botonGuardar.addEventListener("click",function() {
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
*/
    // Definir una función estática para el AJAX
    function BusquedaCK() {
      var numeroCheque = $("#numero_cheque").val();
      console.log("Evento de clic del botón ejecutado correctamente.");
      console.log("Número de Cheque enviado desde el ajax(esto es el archivo js): " + numeroCheque)
      $.ajax({
          url: "Campos.php", 
          type: "POST", 
          data: { numero_cheque: numeroCheque },
          success: function(data) {
              try {
                  data = JSON.parse(data);
                  console.log("Datos recibidos del servidor: ", data);
                  
                  // Actualizar los campos del formulario si la respuesta es válida
                  $("#fecha").val(data.fecha);
                  if (data.beneficiario !== null && data.beneficiario !== '00000') {
                      $("#p-orden-a").val(data.beneficiario);
                  } else {
                      $("#p-orden-a").val("");
                  }
                  $("#monto").val(data.monto);
                  $("#descripcion").val(data.descripcion);
              } catch (error) {
                  console.error("Error al analizar la respuesta JSON:", error);
                  // Si hay un error al analizar la respuesta, no hacemos nada
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
              // Si hay un error en la solicitud AJAX, no hacemos nada
          }
      });
  }

function GrabaraCKs(event){
  event.preventDefault();
  $.ajax({
    type: "POST",
    url: "Envicks.php",
    data: $("#FormularioCks").serialize(),
      success: function(resp){
        if(resp=='0'){
          } else {
          // Aquí deberías manejar el caso en que la respuesta no sea '0'
        console.log("La respuesta no es '0':", resp);
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
      }
  })
    $("#input-numero-cheque").val('');
    $("#fecha").val('');
    $("#p-orden-a").val('');
    $("#suma-de").val('');
    $("#suma").val('');
    $("#DetallesCks").val('');
    $("#objeto-1").val('');
    $("#monto-1").val('');
}

function Anular(event){
  event.preventDefault();
  $.ajax({
    type :"POST",
    url: "AnularUpDate.php",
    data: $("#FRAnulacion").serialize(),
    success: function(resp){
        if(resp=='0'){
          } else {
          // Aquí deberías manejar el caso en que la respuesta no sea '0'
        console.log("La respuesta no es '0':");
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
      }
  })
  $("#numero_cheque").val('');
  $("#fecha").val('');
  $("#monto").val('');
  $("#p-orden-a").val('');  
  $("#descripcion").val('');
  $("#objeto-1").val('');
  $("#Objeto-2").val('');

}

function Circulacion(event){
  event.preventDefault();
  $.ajax({
    type :"POST",
    url: "CirculacionUpDate.php",
    data: $("#FRCirculacion").serialize(),
    success: function(resp){
        if(resp=='0'){
          } else {
          // Aquí deberías manejar el caso en que la respuesta no sea '0'
        console.log("La respuesta no es '0':");
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
      }
  })
  $("#numero_cheque").val('');
  $("#fecha").val('');
  $("#monto").val('');
  $("#p-orden-a").val('');  
  $("#descripcion").val('');
  $("#objeto-1").val('');

}

function OTransacciones(event){
  event.preventDefault();
  $.ajax({
    type :"POST",
    url: "OtrasTranSInSert.php",
    data: $("#FROtrasT").serialize(),
    success: function(resp){
        if(resp=='0'){
          } else {
          // Aquí deberías manejar el caso en que la respuesta no sea '0'
        console.log("La respuesta no es '0':");
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
      }
  })
  $("#Fecha").val('');
  $("#transaccion").val('');
  $("#Monto").val('');
}