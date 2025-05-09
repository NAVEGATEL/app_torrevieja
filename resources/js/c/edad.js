console.log("Script de Control de edad cargado");
function esMenorDeEdad(fechaNacimiento) {
    const fechaNac = new Date(fechaNacimiento);
    const hoy = new Date();
    const edad = hoy.getFullYear() - fechaNac.getFullYear();
    const mes = hoy.getMonth() - fechaNac.getMonth();
    return (
        edad < 18 ||
        (edad === 18 && mes < 0) ||
        (edad === 18 && mes === 0 && hoy.getDate() < fechaNac.getDate())
    );
}

// Exponer al ámbito global
window.esMenorDeEdad = esMenorDeEdad;
