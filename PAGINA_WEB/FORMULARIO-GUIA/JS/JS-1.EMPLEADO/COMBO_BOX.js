function redireccionar() {
    var seleccion = document.getElementById("REDIRIGIR_COMBO-BOX").value;
    //aqui se selecciona el elemento que se seleccionó en el combo-box y para ello, va atomar el nombre
    //del "value" asignado que son:"CARGO","TELEFONO","EMAIL"

    if (seleccion === "CARGO") {//seleciiona el primer varlue, el de cargo
        window.location.href = "../1.4.CARGO_EMPLEADO/Index_1.4.CARGO.php";

    } /*else if (seleccion === "TELEFONO") {//seleciiona el segundo varlue, el de telefono
        window.location.href = "../1.2.TELEFONO_EMPLEADO/Index_1.2.TELEFONO_EMPLEADO.PHP";

    } else if (seleccion === "EMAIL") {//seleciiona el tercer varlue, el de email
        window.location.href = "../1.3.EMAIL_EMPLEADO/Index_1.3.EMAIL_EMPLEADO.PHP";
    }*/
}