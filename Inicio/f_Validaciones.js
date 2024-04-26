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

    // Definir una función estática para el AJAX
    function BusquedaCK() {
      var numeroCheque = $("#numero_cheque").val();
      console.log("Evento de clic del botón ejecutado correctamente.");
      console.log("Número de Cheque enviado desde el ajax(esto es el archivo js): " + numeroCheque)
      $.ajax({
          url: "c_BusquedaCampos.php", 
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

  // Prueba de Campos vacios = No envia
  // Prueba de Campos completos = Guardar Exitoso
  // Falta prueba de Cheque existente
  function GrabaraCKs(event){
    event.preventDefault();

    // Validar campos vacíos
    var camposVacios = false;
    $("#FormularioCks input[type='text']").each(function() {
      if ($(this).val() === '') {
        camposVacios = true;
        return false; // Salir del bucle si se encuentra un campo vacío
      }
    });
    
    if (camposVacios) {
      mostrarToast("Por favor, complete todos los campos.");
      return; // Detener la ejecución si hay campos vacíos
    }

    $.ajax({
      type: "POST",
      url: "c_EnviCKS.php",
      data: $("#FormularioCks").serialize(),
      dataType: 'json', // Esperamos recibir datos en formato JSON
      success: function(response) {
          if (response.success) {
              // El servidor devuelve éxito al guardar el cheque
              mostrarToast("El cheque se guardó correctamente.");
          } else {
              console.log("Respuesta inesperada del servidor:", response);
              mostrarToast("Cheque ya existe.");
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
          mostrarToast("Error al conectar con el servidor. Intente de nuevo más tarde.");
      }
  });
      $("#input-numero-cheque").val('');
      $("#fecha").val('');
      $("#p-orden-a").val('');
      $("#suma-de").val('');
      $("#suma").val('');
      $("#DetallesCks").val('');
      $("#objeto-1").val('');
      $("#monto-1").val('');
  }

  function validarNumeroCheque(event) {
    event.preventDefault();

    $.ajax({
        type: "POST",
        url: "c_validarNumCheque.php",
        data: $("#FormularioCks").serialize(),
        dataType: 'json', // Esperamos recibir datos en formato JSON
        success: function (response) {
            if (response.error) {
                console.log("Respuesta inesperada del servidor:", response);
                mostrarToast(response.error);

                // Deshabilitar los demás campos del formulario
                deshabilitarCampos();
            } else if (response.success) {
                console.log("Número de cheque nuevo:", response);
                mostrarToast(response.success);

                // Habilitar los demás campos del formulario
                habilitarCampos();
            }
        },
    });
}

function deshabilitarCampos() {
    $("#FormularioCks input[type='text']").not("#input-numero-cheque").prop('disabled', true);
}

function habilitarCampos() {
    $("#FormularioCks input[type='text']").not("#input-numero-cheque").prop('disabled', false);
}

function Anular(event){
  event.preventDefault();
  $.ajax({
    type :"POST",
    url: "c_AnularUpDate.php",
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
    url: "c_CirculacionUpDate.php",
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
    url: "c_OTGrabar.php",
    data: $("#FROtrasT").serialize(),
    success: function(resp){
      console.log(resp);
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

function mostrarToast(mensaje) {
  var toast = document.getElementById('toast-notification');
  var toastMessage = toast.querySelector('.toast-message');
  var toastIcon = toast.querySelector('.toast-icon');
  
  toastMessage.textContent = mensaje;
  toastIcon.innerHTML = 'ℹ️'; // Icono de información

  toast.classList.add('show'); // Mostrar la notificación

  setTimeout(function() {
    toast.classList.remove('show'); // Quitar la clase después de 3 segundos
  }, 3000); // 3000 milisegundos = 3 segundos
}

function MostrarConciliacion(){
  var NumeroMes = $("#Selectmes").val();
  var NumeroAge = $("#age").val();
      console.log("Evento de clic del botón ejecutado correctamente.");
      console.log("Número de mes enviado desde el ajax(esto es el archivo js): " + NumeroMes)
      console.log("Número de año enviado desde el ajax(esto es el archivo js): " + NumeroAge)
      $.ajax({
          url: "c_Conciliacion.php", 
          type: "POST", 
          data: { Selectmes: NumeroMes, age: NumeroAge },
          success: function(data) {
            try{
              //data = JSON.parse(data);
              console.log("Datos recibidos del servidor: ", data);
              $("#Libro_Pasado").text("SALDO SEGÚN LIBRO AL " + data.Libro_Pasado);
              $("#LibroActual").text("SALDO CONCILIADO SEGÚN LIBRO AL " + data.LibroActual);
              $("#LibroActual1").text("SALDO EN BANCO AL " + data.LibroActual);
              $("#LibroActual2").text("SALDO CONCILIADO IGUAL A BANCO AL " + data.LibroActual);
              $("#libro_1").val(data.saldo_anterior);
              $("#Depósito").val(data.masdepositos);
              $("#Cheques-Anulados").val(data.maschequesanulados);
              $("#Notas-de-Crédito").val(data.masnotascredito);
              $("#Ajustes").val(data.masajusteslibro);
              $("#Subtotal").val(data.sub1);
              $("#SUB_TOTAL").val(data.subtotal1);
              $("#Cheques-girados").val(data.menoschequesgirados);
              $("#Notas-Débitos").val(data.menosnotasdebito);
              $("#Ajustes2").val(data.menosajusteslibro);
              $("#Subtotal2").val(data.sub2);
              $("#SALDO_CONCILIADO").val(data.saldolibros);
              //$("#SALDO_BANCO").val(data.saldobanco);
              $("#Depósitos-Tránsito").val(data.masdepositostransito);
              $("#Cheques_en_Circulación").val(data.menoschequescirculacion);
              $("#Ajustes3").val(data.masajustesbanco);
              $("#Subtotal3").val(data.sub3);
              $("#SALDO-CONCILIADO-IGUAL-A").val(data.saldo_conciliado);
            }catch (error) {
              console.error("Error al analizar la respuesta JSON:", error);
              // Si hay un error al analizar la respuesta, no hacemos nada
          }
          },
        })
}