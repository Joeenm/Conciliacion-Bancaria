function Entrar(event){
    // Validar campos vacíos
    event.preventDefault();
    var camposVacios = false;
    $("#FRLogin input[type='text'], #FRLogin input[type='password']").each(function() {
      if ($(this).val() === '') {
        camposVacios = true;
        return false; // Salir del bucle si se encuentra un campo vacío
      }
    });

    if (camposVacios) {
      mostrarToast("Por favor, complete todos los campos.");
      return; // Detener la ejecución si hay campos vacíos
    }
    var usuario = $("#userName").val();
    var contra =$("#Clave").val();
    console.log("Usuario(desde ajax): " + usuario)
    console.log("contra(desde ajax): " + contra)
    $.ajax({
        type: "POST",
        url: "c_login.php",
        data: { userName: usuario, Clave: contra },
        success: function(data) {
            console.log("Datos recibidos del servidor: ", data);
            try {
                data = JSON.parse(data);
                console.log("Datos recibidos del servidor: ", data);
                if (data.error) {
                    // Si hay un error en la respuesta, muestra una notificación con el mensaje de error recibido
                    mostrarToast(data.error);
                } else {
                    // Si la respuesta es exitosa, redirige al usuario a la página de inicio
                    window.location.href = "/Proyecto-I/Inicio/index.php";
                }
            } catch(error) {
                console.error("Error al analizar la respuesta JSON:", error);
                // Si hay un error al analizar la respuesta, muestra una notificación genérica
                mostrarToast("Error al procesar la respuesta del servidor");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            // Si hay un error en la solicitud AJAX, muestra una notificación genérica
            mostrarToast("Error en la solicitud AJAX");
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
  const inputFields = document.querySelectorAll("#userName, #Clave");

  inputFields.forEach(function(inputField) {
      inputField.addEventListener("input", function() {
          if (this.value.length > 9) {
              this.value = this.value.slice(0, 9); // Limita la longitud a 9 caracteres
          }
      });
  });
});

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