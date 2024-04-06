function actualizarReloj() {
    var now = new Date();
    var horas = now.getHours(); 
    var minutos = now.getMinutes();
    var segundos = now.getSeconds();

    horas = horas < 10 ? "0" + horas : horas;
    minutos = minutos < 10 ? "0" + minutos : minutos; 
    segundos = segundos < 10 ? "0" + segundos: segundos;

    var timeString = horas + ":" + minutos + ":" + segundos; 
    document.getElementById("reloj").innerHTML = timeString;
}
setInterval(actualizarReloj, 1000);
actualizarReloj();