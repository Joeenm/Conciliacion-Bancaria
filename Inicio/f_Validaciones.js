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

// Convertir números a cantidad en letras
function convertirNumeroALetras() {
  // Obtener el valor del campo de entrada
  let numero = document.getElementById('suma-de').value.trim();

  // Verificar si el valor es un número válido
  if (!isNaN(numero) && numero != '') {
      // Convertir el número a letras
      let resultado = convertirNumeroALetrasTexto(numero);

      // Mostrar el resultado en el campo de texto de salida
      document.getElementById('suma').value = resultado;
  } else {
      // Si el valor ingresado no es un número válido, limpiar el campo de salida
      document.getElementById('suma').value = '';
  }
}

function convertirNumeroALetrasTexto(numero) {
  // Array con los nombres de los números
  let unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
  let decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
  let centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];

  // Convertir la parte entera a letras
  let parteEntera = '';

  if (numero.includes('.')) {
      let partes = numero.split('.');
      parteEntera = convertirParteEnteraALetras(partes[0]);
      parteEntera += ' con ' + convertirParteDecimalALetras(partes[1]);
  } else {
      parteEntera = convertirParteEnteraALetras(numero);
  }

  return parteEntera;
}

function convertirParteEnteraALetras(numero) {
  // Convertir la parte entera a letras
  let resultado = '';
  let unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
  let decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
  let centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];

  if (numero.length == 1) {
      resultado = unidades[numero];
  } else if (numero.length == 2) {
      if (numero[0] == '1') {
          resultado = decenas[numero[1]];
      } else {
          resultado = decenas[numero[0]] + ' ' + unidades[numero[1]];
      }
  } else if (numero.length == 3) {
      resultado = centenas[numero[0]] + ' ' + (numero.slice(1) == '00' ? '' : convertirParteEnteraALetras(numero.slice(1)));
  } else if (numero.length > 3 && numero.length <= 6) {
      resultado = convertirParteEnteraALetras(numero.slice(0, numero.length - 3)) + ' mil ' + convertirParteEnteraALetras(numero.slice(numero.length - 3));
  } else if (numero.length > 6 && numero.length <= 9) {
      resultado = convertirParteEnteraALetras(numero.slice(0, numero.length - 6)) + ' millones ' + convertirParteEnteraALetras(numero.slice(numero.length - 6));
  }

  return resultado;
}

function convertirParteDecimalALetras(numero) {
  // Convertir la parte decimal a letras
  let resultado = '';
  let unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
  let decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];

  if (numero.length == 1) {
      resultado = numero + '/10';
  } else if (numero.length == 2) {
      resultado = numero + '/100';
  }

  return resultado;
}

// Función para pasar monto en Suma-de a Monto-1 en Pantalla Cheques
function actualizarMonto() {
    // Obtener el valor ingresado en el primer input
    var valorSuma = document.getElementById("suma-de").value;

    // Mostrar el mismo valor en el segundo input
    document.getElementById("monto-1").value = valorSuma;
}

    // Función para buscar número de cheque en Pantallas Anulación y Sacar de Circulación
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
                
                if ('success' in data) {
                    mostrarToast(data.success); // Mostrar mensaje de éxito
                    // Actualizar los campos del formulario si la respuesta es válida
                    $("#fecha").val(data.data.fecha);
                    if (data.data.beneficiario !== null && data.data.beneficiario !== '00000') {
                        $("#p-orden-a").val(data.data.beneficiario);
                    } else {
                        $("#p-orden-a").val("");
                    }
                    $("#monto").val(data.data.monto);
                    $("#descripcion").val(data.data.descripcion);
                } else if ('error' in data) {
                    mostrarToast(data.error); // Mostrar mensaje de error
                    // Limpiar los campos del formulario
                    $("#fecha").val("");
                    $("#p-orden-a").val("");
                    $("#monto").val("");
                    $("#descripcion").val("");
                } else {
                    console.error("Respuesta inesperada del servidor:", data);
                }
            } catch (error) {
                console.error("Error al analizar la respuesta JSON:", error);
                // Si hay un error al analizar la respuesta, mostramos un mensaje genérico
                mostrarToast("Error al procesar la respuesta del servidor");
                // Limpiar los campos del formulario
                $("#fecha").val("");
                $("#p-orden-a").val("");
                $("#monto").val("");
                $("#descripcion").val("");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            // Si hay un error en la solicitud AJAX, mostramos un mensaje genérico
            mostrarToast("Error en la solicitud AJAX");
            // Limpiar los campos del formulario
            $("#fecha").val("");
            $("#p-orden-a").val("");
            $("#monto").val("");
            $("#descripcion").val("");
        }
    });
  }

  // Prueba de Campos vacios = No envia
  // Prueba de Campos completos = Guardar Exitoso
  // Prueba de Cheque existente
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

  // Validar número de cheque existente y mostrar notificación en Pantalla Cheques
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

// Funciones para Habilitar y Deshabilitar campos en Pantalla Cheques
function deshabilitarCampos() {
    $("#FormularioCks input[type='text']").not("#input-numero-cheque").prop('disabled', true);
}

function habilitarCampos() {
    $("#FormularioCks input[type='text']").not("#input-numero-cheque").prop('disabled', false);
}

// Función para botón en Anulación
function Anular(event) {
  event.preventDefault();
  $.ajax({
    type: "POST",
    url: "c_AnularUpDate.php",
    data: $("#FRAnulacion").serialize(),
    success: function(resp) {
      try {
        data = JSON.parse(resp);
        console.log("Datos recibidos del servidor:", data);
        
        if ('success' in data) {
          mostrarToast(data.success); // Mostrar mensaje de éxito
          // Limpiar los campos del formulario después de la solicitud AJAX
          $("#FRAnulacion")[0].reset();
        } else if ('error' in data) {
          mostrarToast(data.error); // Mostrar mensaje de error
        } else if ('info' in data) { // Nuevo mensaje para información de registro
          console.log(data.info); // Mostrar información de registro en la consola
          mostrarToast("Ocurrió un error al anular el cheque. Consulta la consola para más detalles.");
        } else {
          console.error("Respuesta inesperada del servidor:", data);
          mostrarToast("Error inesperado en la respuesta del servidor");
        }
      } catch (error) {
        console.error("Error al analizar la respuesta JSON:", error);
        // Si hay un error al analizar la respuesta, mostramos un mensaje genérico
        mostrarToast("Error al procesar la respuesta del servidor");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
      // Si hay un error en la solicitud AJAX, mostramos un mensaje genérico
      mostrarToast("Error en la solicitud AJAX");
    }
  });
}

// Función para botón en Sacar de Circulación
function Circulacion(event) {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "c_CirculacionUpDate.php",
        data: $("#FRCirculacion").serialize(),
        success: function(resp) {
            try {
                data = JSON.parse(resp);
                console.log("Datos recibidos del servidor:", data);
                
                if ('success' in data) {
                    mostrarToast(data.success); // Mostrar mensaje de éxito
                    // Limpiar los campos del formulario después de la solicitud AJAX
                    $("#FRCirculacion")[0].reset();
                } else if ('error' in data) {
                    mostrarToast(data.error); // Mostrar mensaje de error
                } else {
                    console.error("Respuesta inesperada del servidor:", data);
                    mostrarToast("Respuesta inesperada del servidor");
                }
            } catch (error) {
                console.error("Error al analizar la respuesta JSON:", error);
                // Si hay un error al analizar la respuesta, mostramos un mensaje genérico
                mostrarToast("Error al procesar la respuesta del servidor");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            // Si hay un error en la solicitud AJAX, mostramos un mensaje genérico
            mostrarToast("Error en la solicitud AJAX");
        }
    });
}

// Función para botón en Otras Transacciones
function OTransacciones(event) {
    event.preventDefault();
    $.ajax({
      type: "POST",
      url: "c_OTGrabar.php",
      data: $("#FROtrasT").serialize(),
      success: function(resp) {
        try {
          data = JSON.parse(resp);
          console.log("Datos recibidos del servidor:", data);
          
          if ('success' in data) {
            mostrarToast(data.success); // Mostrar mensaje de éxito
            // Limpiar los campos del formulario después de la solicitud AJAX
            $("#Fecha").val('');
            $("#transaccion").val('');
            $("#Monto").val('');
          } else if ('error' in data) {
            mostrarToast(data.error); // Mostrar mensaje de error
          } else {
            console.error("Respuesta inesperada del servidor:", data);
          }
        } catch (error) {
          console.error("Error al analizar la respuesta JSON:", error);
          // Si hay un error al analizar la respuesta, mostramos un mensaje genérico
          mostrarToast("Error al procesar la respuesta del servidor");
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        // Si hay un error en la solicitud AJAX, mostramos un mensaje genérico
        mostrarToast("Error en la solicitud AJAX");
      }
    });
  }

// Función para Notificaciones
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
              data = JSON.parse(data);
              console.log("Datos recibidos del servidor: ", data);
              if (data.error) {
                var errorMessage = data.error;
                mostrarToast(errorMessage);
                $("#Dia-Anterior_oculto").val('');
                $("#Mes-Anterior_oculto").val('');
                $("#Año-Anterior_oculto").val('');
                $("#Dia-Actual_oculto").val('');
                $("#Mes-Actual_oculto").val('');
                $("#Año-Actual_oculto").val('');
                $("#libro_1").val('');
                $("#Depósito").val('');
                $("#Cheques-Anulados").val('');
                $("#Notas-de-Crédito").val('');
                $("#Ajustes").val('');
                $("#Subtotal").val('');
                $("#SUB_TOTAL").val('');
                $("#Cheques-girados").val('');
                $("#Notas-Débitos").val('');
                $("#Ajustes2").val('');
                $("#Subtotal2").val('');
                $("#SALDO_CONCILIADO").val('');
                $("#SALDO_BANCO").val('');
                $("#Depósitos-Tránsito").val('');
                $("#Cheques_en_Circulación").val('');
                $("#Ajustes3").val('');
                $("#Subtotal3").val('');
                $("#sub3V").val('');
                $("#SaldoT").val('');
                $("#Libro_Pasado").text("SALDO SEGÚN LIBRO AL ");
                $("#LibroActual").text("SALDO CONCILIADO SEGÚN LIBRO AL ");
                $("#LibroActual1").text("SALDO EN BANCO AL ");
                $("#LibroActual2").text("SALDO CONCILIADO IGUAL A BANCO AL ");
                $("#SALDO_BANCO").prop("disabled", true);
              } else {
                $('#Dia-Anterior_oculto').val(data["La respuesta es"].DayA);
                $('#Mes-Anterior_oculto').val(data["La respuesta es"].MesA);
                $('#Año-Anterior_oculto').val(data["La respuesta es"].AgnoA);
                $('#Dia-Actual_oculto').val(data["La respuesta es"].Dia);
                $('#Mes-Actual_oculto').val(data["La respuesta es"].Mes);
                $('#Año-Actual_oculto').val(data["La respuesta es"].Agno);
                $("#Libro_Pasado").text("SALDO SEGÚN LIBRO AL " + data["La respuesta es"].Libro_Pasado);
                $("#LibroActual").text("SALDO CONCILIADO SEGÚN LIBRO AL " + data["La respuesta es"].LibroActual);
                $("#LibroActual1").text("SALDO EN BANCO AL " + data["La respuesta es"].LibroActual);
                $("#LibroActual2").text("SALDO CONCILIADO IGUAL A BANCO AL " + data["La respuesta es"].LibroActual);
                $("#libro_1").val(data["La respuesta es"].saldo_anterior);
                $("#Depósito").val(data["La respuesta es"].masdepositos);
                $("#Cheques-Anulados").val(data["La respuesta es"].maschequesanulados);
                $("#Notas-de-Crédito").val(data["La respuesta es"].masnotascredito);
                $("#Ajustes").val(data["La respuesta es"].masajusteslibro);
                $("#Subtotal").val(data["La respuesta es"].sub1);
                $("#SUB_TOTAL").val(data["La respuesta es"].subtotal1);
                $("#Cheques-girados").val(data["La respuesta es"].menoschequesgirados);
                $("#Notas-Débitos").val(data["La respuesta es"].menosnotasdebito);
                $("#Ajustes2").val(data["La respuesta es"].menosajusteslibro);
                $("#Subtotal2").val(data["La respuesta es"].sub2);
                $("#SALDO_CONCILIADO").val(data["La respuesta es"].saldolibros);
                $("#Depósitos-Tránsito").val(data["La respuesta es"].masdepositostransito);
                $("#Cheques_en_Circulación").val(data["La respuesta es"].menoschequescirculacion);
                $("#Ajustes3").val(data["La respuesta es"].masajustesbanco);
                $("#Subtotal3").val(data["La respuesta es"].sub3);
                $("#sub3V").val(data["La respuesta es"].sub3V);
                //$("#SALDO_BANCO").val(data.saldobanco);
                //$("#SALDO-CONCILIADO-IGUAL-A").val(data.saldo_conciliado);
                $("#SALDO_BANCO").prop("disabled", false);
              }
            }catch (error) {
              console.error("Error al analizar la respuesta JSON:", error);
              // Si hay un error al analizar la respuesta, no hacemos nada
          }
          },
        })
}
var typingTimer; // Temporizador para retraso de envio al server
var doneTypingInterval = 200; // Intervalo de tiempo en milisegundos

function SumaConciliacion(event) {
    clearTimeout(typingTimer); // Reiniciar el temporizador en cada pulsación de tecla
    typingTimer = setTimeout(function() {
        var SaldoBanco = $("#SALDO_BANCO").val();
        var Saldo3 = $('#sub3V').val();

        $.ajax({
            url: "c_ConciliacionSuma.php",
            type: "POST",
            data: { SALDO_BANCO: SaldoBanco, sub3V: Saldo3 },
            success: function(data) {
                try {
                    data = JSON.parse(data);
                    console.log("Datos recibidos del servidor: ", data);
                    var total = parseFloat(data['La suma en total es']['Total']);
                    var formattedTotal = total.toFixed(2);
                    if (total < 0) {
                        formattedTotal = '(' + total + ')';
                    }
                    $('#SaldoT').val(formattedTotal);
                } catch (error) {
                    console.error("Error al analizar la respuesta JSON:", error);
                }
            },
        });
    }, doneTypingInterval); // Configurar un nuevo temporizador
}


function GrabarConciliacion(event){
  event.preventDefault();

  // Validar campos vacíos
  var camposVacios2 = false;
  $("#FRConciliacion input[type='text']").each(function() {
    if ($(this).val() === '') {
      camposVacios2 = true;
      return false; // Salir del bucle si se encuentra un campo vacío
    }
  });
  
  if (camposVacios2) {
    mostrarToast("Por favor, complete todos los campos.");
    return; // Detener la ejecución si hay campos vacíos
  }
  var Comparacion1= $("#SALDO_CONCILIADO").val();
  var Comparacion2 = $("#SaldoT").val();
  if(Comparacion1==Comparacion2){
    $.ajax({
      type: "POST",
      url: "c_GrabarConciliacion.php",
      data: $("#FRConciliacion").serialize(),
      dataType: 'json', // Esperamos recibir datos en formato JSON
      success: function(response) {
          if (response.success) {
              // El servidor devuelve éxito al guardar el cheque
              mostrarToast("La conciliacion se guardó correctamente.");
          } else {
              console.log("Respuesta inesperada del servidor:", response);
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
          mostrarToast("Error al conectar con el servidor. Intente de nuevo más tarde.");
      }
  });
    $("#Dia-Anterior_oculto").val('');
    $("#Mes-Anterior_oculto").val('');
    $("#Año-Anterior_oculto").val('');
    $("#Dia-Actual_oculto").val('');
    $("#Mes-Actual_oculto").val('');
    $("#Año-Actual_oculto").val('');
    $("#libro_1").val('');
    $("#Depósito").val('');
    $("#Cheques-Anulados").val('');
    $("#Notas-de-Crédito").val('');
    $("#Ajustes").val('');
    $("#Subtotal").val('');
    $("#SUB_TOTAL").val('');
    $("#Cheques-girados").val('');
    $("#Notas-Débitos").val('');
    $("#Ajustes2").val('');
    $("#Subtotal2").val('');
    $("#SALDO_CONCILIADO").val('');
    $("#SALDO_BANCO").val('');
    $("#Depósitos-Tránsito").val('');
    $("#Cheques_en_Circulación").val('');
    $("#Ajustes3").val('');
    $("#Subtotal3").val('');
    $("#SaldoT").val('');
    $("#Libro_Pasado").text("SALDO SEGÚN LIBRO AL ");
    $("#LibroActual").text("SALDO CONCILIADO SEGÚN LIBRO AL ");
    $("#LibroActual1").text("SALDO EN BANCO AL ");
    $("#LibroActual2").text("SALDO CONCILIADO IGUAL A BANCO AL ");
  }else{
    mostrarToast("Verifique los datos, la conciliacion no se puede guardar por incoherencia de datos.");
  }
}

function Reportes(event) {
  event.preventDefault();
  var file = $("#archivo")[0].files[0]; // Obtiene el archivo seleccionado
  var formData = new FormData(); // Crea un objeto FormData para enviar el archivo
  formData.append('archivo', file); // Agrega el archivo al objeto FormData

  $.ajax({
      type: "POST",
      url: "c_Asistencia.php",
      data: formData, // Envía el objeto FormData que contiene el archivo
      contentType: false, // Importante: No establezcas el tipo de contenido
      processData: false, // Importante: No proceses los datos
      success: function(data) {
          try {
              console.log("Datos recibidos del servidor:", data);
          } catch (error) {
              console.error("Error al analizar la respuesta JSON:", error);
          }
      },
  }); 
}

function PedirReporte(event) {
  event.preventDefault();
  var F1 = $("#Fecha1").val();
  var F2 = $("#Fecha2").val();
  var N= 1;
  var y= 2;
  console.log(F1,F2);
  // Verificar que las fechas sean válidas (no NaN)
  if (!F1 || !F2) {
      mostrarToast("Por favor ingrese fechas válidas.");
      return;
  }
  var dateF1 = new Date(F1);
  var dateF2 = new Date(F2);

  // Verificar que F1 sea menor que F2
  if (dateF1 >= dateF2) {
    mostrarToast("La fecha de inicio debe ser anterior a la fecha de fin.");
    return;
  }else{
    $.ajax({
      type: "POST",
      url: "c_ArchivoPDF.php",
      data: $("#FR_Reportes").serialize(),
      dataType: 'text', // Cambiado a 'text' temporalmente
      success: function (response) {
          console.log("Respuesta del servidor:", response);
          try {
              var jsonResponse = JSON.parse(response);
              if (jsonResponse.success) {
                  window.open(jsonResponse.pdf_url, '_blank');
              } else {
                  alert(jsonResponse.error);
              }
          } catch (e) {
              console.error("Error al analizar JSON:", e, response);
              alert("Error inesperado en la respuesta del servidor.");
          }
      },
      error: function (xhr, status, error) {
          console.error('Error en la solicitud AJAX:', status, error);
          alert('Ocurrió un error al generar el reporte. Intente de nuevo.');
      }
  });
  }
}