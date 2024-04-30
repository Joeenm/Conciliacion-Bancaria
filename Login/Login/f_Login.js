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
      alert("Por favor, complete todos los campos.");
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
                    // Si hay un error en la respuesta, muestra una alerta con el mensaje de error recibido
                    alert("Error: " + data.error);
                } else {
                    window.location.href = "/Proyecto-I/Inicio/index.php";
                }
            } catch(error) {
                console.error("Error al analizar la respuesta JSON:", error);
            }
        }
    });
}