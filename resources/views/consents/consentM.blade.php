@extends('../layouts/public') <!-- Extiende el layout public.blade.php -->
@section('content')

<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<script>  
    const CIUDAD = "Torrevieja"
    // JSON con textos en ES y EN
    const textos = {
        es: {
            city: CIUDAD,
            titulo: "Consentimiento de Uso",
            granText: "Por el presente documento reconozco que la empresa ACTIVIDADES NÁUTICAS TORREVIEJA, S.L operadora de la actividad de iniciación a la moto náutica me ha explicado en qué consiste la actividad, me ha explicado las instrucciones de uso, las medidas de seguridad y todo el procedimiento a seguir durante el desarrollo de la excursión para su correcto desarrollo. Así mismo, he sido informado de las limitaciones y los supuestos en los que no se puede usar la moto acuática, tales como el estar bajo los efectos del alcohol, drogas, tener mermadas las capacidades físicas o mentales, etc... Me hago responsable de cualquier daño ocasionado al material que aquí se me presta y me comprometo a abonar la rotura del mismo, si éste se rompiera por no seguir las indicaciones de los monitores de la empresa. Igualmente reconozco que me ha sido traducido este texto, el cual firmo dándome por enterado de todo su contenido y otorgando mi plena conformidad y consentimiento. Eximo a la empresa de cualquier responsabilidad de la perdida de objetos realizando la actividad.",
            granText2: "Le informamos que sus datos personales, que puedan constar en este contrato, serán incorporados a un fichero bajo nuestra responsabilidad, con la finalidad de informarle de los productos y servicios que ofrece ACTIVIDADES NÁUTICAS TORREVIEJA, S.L. Así mismo nos permite utilizar cualquier foto que se le haga durante la actividad para nuestra promoción. Si desea ejercitar sus derechos de acceso, rectificación, cancelación y oposición, puede dirigirse por escrito a: Flyboard Torrevieja, Paseo Vistalegre s/n - 03181 Torrevieja (Alicante).Vía correo electrónico a protecciondedatos@flyboardtorrevieja.com con el asunto: BAJA.",
            ticketPlaceholder: "Ticket Nº",
            enviar: "Enviar",
            numClientes: "Número de Clientes",
            actividades: "Actividades",
            parasailing: "PARASAILING",
            hinchable: "HINCHABLE",
            flyboard: "FLYBOARD",
            numPersonas: "Número de personas",
            tipoHinchable: "Tipo de Hinchable",
            tiempoFlyboard: "Tiempo en minutos",
            menores: "Consentimiento para Menores",
            menorEdad: "Menor de Edad",
            padreTutor: "Padre/Tutor Legal",
            firma: "Firma",
            fecha: "Fecha",
            enviarFormulario: "Enviar",
            nombreApellido: "Nombre y Apellido",
            dni: "DNI",
            telefono: "Teléfono",
            email: "Email",
            limpiarFirma: "Limpiar",
            cliente: "Cliente",
            fechaNacimiento: "Fecha de Nacimiento",
            generarTicket: "Generar Ticket"

        },
        en: {
            city: CIUDAD,
            titulo: "Usage Consent",
            granText: "By this document I acknowledge that the company ACTIVIDADES NÁUTICAS TORREVIEJA, S.L., operator of the jet ski initiation activity, has explained to me what the activity consists of, the instructions for use, safety measures, and the whole procedure to be followed throughout its development for the correct use of the aforesaid.I have also been informed about the limitations and the situations in which the device is not to be used, such as being under the effects of alcohol or drugs, experiencing a decrease of physical or mental faculties, etc. I am responsible for any damage caused to the material I am provided by the operator and I accept to pay the reparations in case of not following the indications of the instructors. I have been translated this text, which I sign to indicate approval and conformity after being aware of and understanding all its content. I exempt the company from any responsibility for the loss of objects by performing the activity.",
            granText2: "We inform you that your personal data, which may appear in this contract, will be incorporated into a file under our responsibility, with the purpose of informing you about the products and services offered by ACTIVIDADES NÁUTICAS TORREVIEJA, S.L. Additionally, you allow us to use any photo taken of you during the activity for our promotion. If you wish to exercise your rights of access, rectification, cancellation, and opposition, you can contact us in writing at: Flyboard Torrevieja, Paseo Vistalegre s/n - 03181 Torrevieja (Alicante), or via email at protecciondedatos@flyboardtorrevieja.com with the subject: UNSUBSCRIBE.",
            ticketPlaceholder: "Ticket No.",
            enviar: "Send",
            numClientes: "Number of Clients",
            actividades: "Activities",
            parasailing: "PARASAILING",
            hinchable: "INFLATABLE",
            flyboard: "FLYBOARD",
            numPersonas: "Number of people",
            tipoHinchable: "Type of Inflatable",
            tiempoFlyboard: "Flyboard time (minutes)",
            menores: "Consent for Minors",
            menorEdad: "Minor",
            padreTutor: "Parent/Legal Guardian",
            firma: "Signature",
            fecha: "Date",
            enviarFormulario: "Submit",
            nombreApellido: "Name and Surname",
            dni: "ID Number",
            telefono: "Phone",
            email: "Email",
            limpiarFirma: "Clear",
            cliente: "Client",
            fechaNacimiento: "Bith date",
            generarTicket: "Create Ticket"

        }
    };
</script>

<!-- Estilos CSS para el formulario -->
<style>
 
    .row { display: flex; flex-wrap: wrap; margin-bottom: 15px; }
    .col { padding: 5px; }
    .header .col { padding: 10px; }
    .title { text-align: center; font-size: 18px; margin: 20px 0; font-weight: bold; }
    .section { margin-bottom: 20px; }
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="number"] {
        border: none;
        border-bottom: 1px dotted #000;
        padding: 2px 5px;
        outline: none;
    }
    .price-box { display: flex; justify-content: space-between; max-width: 400px; margin-top: 10px; }
    .sign-box {
        border: 1px solid #000;
        display: block;
        width: 100%;
        height: 100px;
        touch-action: none;
    }
    .btn {
        padding: 10px 15px;
        margin: 5px;
        border: none;
        border-radius: 5px;
        background: #007bff;
        color: #fff;
        cursor: pointer;
    }
    .btn-secondary { background: #6c757d; }
    .footer { font-size: 12px; margin-top: 20px; }
    .no-print { text-align: center; margin-top: 20px; }
    input{margin: 10px 5px;}
    .signatures-row {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: space-between;
    gap: 20px;
    margin-top: 20px;
}

.signature-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.signature-container canvas.sign-box {
    width: 50%;
    height: 100px;
    border: 1px solid #000;
    box-sizing: border-box;
}

    
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<!-- Contenido del formulario -->
<body class="imprimit">

    <!-- HTML contenido -->
    <div class="container p-5">
        <form method="POST" action="{{ route('consent.submit') }}">
            @csrf
            <!-- Encabezado -->
            <div class="header row">
                <div class="col" style="flex: 3;">
                    <strong>ACTIVIDADES NÁUTICAS TORREVIEJA, S.L.</strong><br>
                    CIF: B54909668<br>
                    Avda. Vistalegre s/n (Real Club Náutico de Torrevieja)<br>
                    03181 – Torrevieja – Alicante – España<br>
                    Tel.: +34 655 023 039
                </div>
                <div class="col" style="flex: 1; text-align: right;">
                    <label>Nº SOCIO CLUB NÁUTICO:</label>
                    <input type="text" name="socio_club" style="min-width: 80px;"><br><br>
                    <label>Nº DE TICKET:</label>
                    <input type="text" name="ticket" style="min-width: 80px;">
                </div>
            </div>

            <!-- Título -->
            <div class="title">
                EXCURSIÓN PARA LA INTRODUCCIÓN A LA MOTO NÁUTICA
            </div>

            <!-- Texto del Contrato -->
            <div class="section">
                <div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 20px; background-color: #f9f9f9; padding: 15px;">
                    <div style="flex: 1; min-width: 48%; padding-right: 15px;">
                        <div style="margin-bottom: 1px;">
                            <label style="color: #654321; font-weight: 500; display: inline-block; width: 160px;">Nombre y Apellidos</label>
                            <input type="text" name="nombre_contrato" style="width: 65%; border: none; border-bottom: 1px dotted #000;">
                        </div>
                        
                        <div style="margin-bottom: 1px;">
                            <label style="color: #654321; font-weight: 500; display: inline-block; width: 160px;">Dirección</label>
                            <input type="text" name="direccion" style="width: 65%; border: none; border-bottom: 1px dotted #000;">
                        </div>
                        
                        <div style="margin-bottom: 1px;">
                            <label style="color: #654321; font-weight: 500; display: inline-block; width: 160px;">Población</label>
                            <input type="text" name="poblacion" style="width: 65%; border: none; border-bottom: 1px dotted #000;">
                        </div>
                        
                        <div style="margin-bottom: 1px;">
                            <label style="color: #654321; font-weight: 500; display: inline-block; width: 160px;">País</label>
                            <input type="text" name="pais" style="width: 65%; border: none; border-bottom: 1px dotted #000;">
                        </div>
                    </div>
                    
                    <div style="flex: 1; min-width: 48%;">
                        <div style="margin-bottom: 1px;">
                            <label style="color: #654321; font-weight: 500; display: inline-block; width: 160px;">DNI/Pasaporte/NIE</label>
                            <input type="text" name="documento_identidad" style="width: 65%; border: none; border-bottom: 1px dotted #000;">
                        </div>
                        
                        <div style="margin-bottom: 1px;">
                            <label style="color: #654321; font-weight: 500; display: inline-block; width: 160px;">Tel.</label>
                            <input type="tel" name="telefono" style="width: 65%; border: none; border-bottom: 1px dotted #000;">
                        </div>
                        
                        <div style="margin-bottom: 1px;">
                            <label style="color: #654321; font-weight: 500; display: inline-block; width: 160px;">Provincia</label>
                            <input type="text" name="provincia" style="width: 65%; border: none; border-bottom: 1px dotted #000;">
                        </div>
                        
                        <div style="margin-bottom: 1px;">
                            <label style="color: #654321; font-weight: 500; display: inline-block; width: 160px;">Email</label>
                            <input type="email" name="email" style="width: 65%; border: none; border-bottom: 1px dotted #000;">
                        </div>
                        
                       
                    </div>
                </div>
                
                <p style="font-size: 0.85em; line-height: 1.3;">
                Reconozco que ACTIVIDADES NÁUTICAS TORREVIEJA, S.L. me ha explicado en qué consiste la actividad de moto náutica, las instrucciones, medidas de seguridad y limitaciones de uso (como no estar bajo efectos de alcohol o drogas). Me responsabilizo de los daños al material por mal uso y acepto abonar su reparación si procede. También confirmo que el texto me ha sido traducido, lo entiendo y doy mi consentimiento. Eximo a la empresa de responsabilidad por pérdida de objetos durante la actividad.                </p>
                <p style="font-size: 0.85em; line-height: 1.3;">
                I acknowledge that ACTIVIDADES NÁUTICAS TORREVIEJA, S.L. has explained to me the details of the jet ski activity, including instructions, safety measures, and usage limitations (such as not being under the influence of alcohol or drugs). I take responsibility for any damage to the provided equipment due to misuse and agree to cover the repair costs if necessary. I also confirm that this text has been translated for me, that I understand it fully, and that I give my consent. I release the company from any liability for the loss of personal belongings during the activity.
                </p>
            </div>

            <!-- Datos Personales -->
            <div class="section">
                <h4>DATOS PERSONALES</h4>
                <div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 20px; background-color: #f9f9f9; padding: 15px;">
                    <div style="flex: 1; min-width: 48%; padding-right: 15px;">
                        <div style="margin-bottom: 1px;">
                            <label style="color: #654321; font-weight: 500; display: inline-block; width: 130px; vertical-align: top;">Nombre y<br>Apellidos:</label>
                            <input type="text" name="nombre_apellidos" style="width: 60%; border: none; border-bottom: 1px dotted #000;">
                        </div>
                        
                        <div style="margin-bottom: 1px;">
                            <label style="color: #654321; font-weight: 500; display: inline-block; width: 130px;">Dirección:</label>
                            <input type="text" name="direccion" style="width: 60%; border: none; border-bottom: 1px dotted #000;">
                        </div>
                        
                        <div style="margin-bottom: 1px;">
                            <label style="color: #654321; font-weight: 500; display: inline-block; width: 130px;">Población:</label>
                            <input type="text" name="poblacion" style="width: 60%; border: none; border-bottom: 1px dotted #000;">
                        </div>
                    </div>
                    
                    <div style="flex: 1; min-width: 48%;">
                        <div style="margin-bottom: 1px;">
                            <label style="color: #654321; font-weight: 500; display: inline-block; width: 130px;">Email</label>
                            <input type="email" name="email" style="width: 60%; border: none; border-bottom: 1px dotted #000;">
                        </div>
                        
                        <div style="margin-bottom: 1px;">
                            <label style="color: #654321; font-weight: 500; display: inline-block; width: 130px;">País:</label>
                            <input type="text" name="pais" style="width: 60%; border: none; border-bottom: 1px dotted #000;">
                        </div>
                        
                        <div style="margin-bottom: 1px;">
                            <label style="color: #654321; font-weight: 500; display: inline-block; width: 130px;">Fecha nacimiento:</label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" onchange="verificarEdad()" style="width: 60%; border: none; border-bottom: 1px dotted #000;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos de la Actividad -->
            <div class="section">
                <h4>DATOS DE LA ACTIVIDAD</h4>
                <div>
                    <label>Moto nº:</label>
                    <input type="text" name="moto_num" style="min-width: 60px;">
                    &nbsp;&nbsp;&nbsp;
                    <label>Número de Personas:</label>
                    <input type="number" name="numero_personas" style="min-width: 60px;">
                    &nbsp;&nbsp;&nbsp;
                    <label>Tiempo de la excursión:</label>
                    <input type="text" name="tiempo_excursion" style="min-width: 100px;">
                </div>
                <br>
                <div>
                    <label>OFERTA COMBINADA:</label>
                    <input type="number" name="oferta_combinada" id="oferta_combinada" onchange="calcularTotal()" style="min-width: 200px;"> €
                </div>
                <div>
                    <label>FOTOS O GOPRO:</label>
                    <input type="number" name="fotos_gopro" id="fotos_gopro" onchange="calcularTotal()" style="min-width: 200px;"> €
                </div>
                <br>
                <div>
                    <input type="checkbox" name="pago_tarjeta"> <label style="font-weight:normal;">Pago con tarjeta</label>
                    &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="pago_efectivo"> <label style="font-weight:normal;">Pago en efectivo</label>
                </div>
                <br>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div class="price-box" style="flex: 1;">
                        <div>PRECIO <span id="precio_base">0.00</span> €</div>
                        <div>IVA 21% <span id="iva">0.00</span> €</div>
                        <div style="border-top: 1px solid #000; padding-top: 5px;">TOTAL <span id="precio_total">0.00</span> €</div>
                    </div>
                
                    <!-- Imagen de moto de agua -->
                    <div style="flex: 1; text-align: right;">
                        <img src="/img/moto de agua.PNG" alt="Moto de Agua" style="width: 300px; height: auto;">
                    </div>
                </div>

            </div>

            <!-- Consentimiento -->
            <div class="section">
                <p>
                Consiento participar en la actividad de Jetski, confirmo que me han informado de las medidas de seguridad y asumo voluntariamente el riesgo de posibles lesiones o daños.
                </p>
            </div>

            <!-- Fechas y Firmas -->
            <div class="section row">
                <div class="col" style="flex: 2;">
                    En Torrevieja, a 
                    <input type="text" name="dia" style="min-width: 30px;"> de 
                    <input type="text" name="mes" style="min-width: 120px;"> de 202
                    <input type="text" name="anio" style="min-width: 20px;">
                </div>
            </div>

            <div class="signatures-row">
                <div class="signature-container">
                    <label>Firma del Participante:</label>
                    <canvas class="sign-box" id="signature-pad-participant"></canvas>
                    <button type="button" class="btn btn-secondary no-print" onclick="clearSignature('signature-pad-participant')">Limpiar Firma</button>
                </div>
                <div class="signature-container" id="firma_tutor_container">
                    <label>Firma del Tutor Legal:</label>
                    <canvas class="sign-box" id="signature-pad-tutor"></canvas>
                    <button type="button" class="btn btn-secondary no-print" onclick="clearSignature('signature-pad-tutor')">Limpiar Firma</button>
                </div>
            </div>

            <div class="section" id="nombre_tutor_container" style="margin-top: 15px;">
                <div class="col">
                    <label>Nombre del tutor legal:</label>
                    <input type="text" name="nombre_tutor" id="nombre_tutor" style="min-width: 250px;">
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                Los datos personales recogidos serán tratados de acuerdo con la normativa vigente en materia de protección de datos. Para ejercer sus derechos de acceso, rectificación, cancelación u oposición, contacte a protecciondedatos@flyboardtorrevieja.com. Si no está de acuerdo con el tratamiento de sus datos, marque la casilla: <input type="checkbox" name="no_consentimiento">
            </div>

            <!-- Botones -->
            <div class="no-print">
                <button type="submit" class="btn btn-primary">Enviar</button>
                <button type="button" class="btn btn-secondary" onclick="printBody()">Imprimir</button>

            </div>
        </form>
    </div>

    <!-- Firma con el dedo o ratón -->
    <script>
        // Inicializar los pads de firma al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar los pads de firma
            initSignaturePad('signature-pad-participant');
            initSignaturePad('signature-pad-tutor');
            
            // Calcular el total inicialmente
            calcularTotal();
            
            // Verificar la edad si ya hay una fecha
            verificarEdad();
        });

        function initSignaturePad(canvasId) {
            var canvas = document.getElementById(canvasId);
            if (!canvas) {
                console.error('Canvas no encontrado:', canvasId);
                return;
            }
            
            var ctx = canvas.getContext('2d');
            var drawing = false;

            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                ctx.scale(ratio, ratio);
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            // Mouse events
            canvas.addEventListener('mousedown', function(e) {
                drawing = true;
                ctx.beginPath();
                ctx.moveTo(e.offsetX, e.offsetY);
            });
            canvas.addEventListener('mousemove', function(e) {
                if (!drawing) return;
                ctx.lineTo(e.offsetX, e.offsetY);
                ctx.stroke();
            });
            canvas.addEventListener('mouseup', function() { drawing = false; });
            canvas.addEventListener('mouseout', function() { drawing = false; });

            // Touch events
            canvas.addEventListener('touchstart', function(e) {
                e.preventDefault();
                drawing = true;
                const rect = canvas.getBoundingClientRect();
                const touch = e.touches[0];
                ctx.beginPath();
                ctx.moveTo(touch.clientX - rect.left, touch.clientY - rect.top);
            });
            canvas.addEventListener('touchmove', function(e) {
                e.preventDefault();
                if (!drawing) return;
                const rect = canvas.getBoundingClientRect();
                const touch = e.touches[0];
                ctx.lineTo(touch.clientX - rect.left, touch.clientY - rect.top);
                ctx.stroke();
            });
            canvas.addEventListener('touchend', function() { drawing = false; });
        }

        function clearSignature(canvasId) {
            var canvas = document.getElementById(canvasId);
            if (!canvas) {
                console.error('Canvas no encontrado:', canvasId);
                return;
            }
            var ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }

        // Función para calcular automáticamente el total con IVA
        function calcularTotal() {
            const ofertaCombinada = parseFloat(document.getElementById('oferta_combinada')?.value) || 0;
            const fotosGopro = parseFloat(document.getElementById('fotos_gopro')?.value) || 0;
            
            const precioBase = ofertaCombinada + fotosGopro;
            const iva = precioBase * 0.21;
            const total = precioBase + iva;
            
            if (document.getElementById('precio_base')) {
                document.getElementById('precio_base').textContent = precioBase.toFixed(2);
            }
            if (document.getElementById('iva')) {
                document.getElementById('iva').textContent = iva.toFixed(2);
            }
            if (document.getElementById('precio_total')) {
                document.getElementById('precio_total').textContent = total.toFixed(2);
            }
        }

        // Función para verificar la edad y mostrar/ocultar campos de tutor
        function verificarEdad() {
            const fechaNacimientoInput = document.getElementById('fecha_nacimiento');
            if (!fechaNacimientoInput) {
                console.error('Elemento fecha_nacimiento no encontrado');
                return;
            }
            
            const fechaNacimiento = fechaNacimientoInput.value;
            const firmaTutorContainer = document.getElementById('firma_tutor_container');
            const nombreTutorContainer = document.getElementById('nombre_tutor_container');
            
            if (!firmaTutorContainer || !nombreTutorContainer) {
                console.error('Contenedores de tutor no encontrados');
                return;
            }
            
            // Si no hay fecha, mantener los campos visibles por defecto
            if (!fechaNacimiento) {
                return;
            }
            
            const hoy = new Date();
            const fechaNac = new Date(fechaNacimiento);
            let edad = hoy.getFullYear() - fechaNac.getFullYear();
            const mes = hoy.getMonth() - fechaNac.getMonth();
            
            if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNac.getDate())) {
                edad--;
            }
            
            console.log("Edad calculada:", edad);
            
            if (edad < 18) {
                // Si es menor de edad, mostrar los campos del tutor
                firmaTutorContainer.style.display = 'block';
                nombreTutorContainer.style.display = 'block';
                if (document.getElementById('nombre_tutor')) {
                    document.getElementById('nombre_tutor').required = true;
                }
            } else {
                // Si es mayor de edad, ocultar los campos del tutor
                firmaTutorContainer.style.display = 'none';
                nombreTutorContainer.style.display = 'none';
                if (document.getElementById('nombre_tutor')) {
                    document.getElementById('nombre_tutor').required = false;
                }
            }
        }
    </script>

    <!-- Script para imprimir el contenido -->
    <script>
        function checkFields() {
            let missing = [];
            const fieldsToCheck = [
                { name: 'nombre_contrato', label: 'Nombre del contrato' },
                { name: 'documento_identidad', label: 'Documento de Identidad' },
                { name: 'telefono', label: 'Teléfono' },
                { name: 'nombre_apellidos', label: 'Nombre y Apellidos' },
                { name: 'direccion', label: 'Dirección' },
                { name: 'poblacion', label: 'Población' },
                { name: 'provincia', label: 'Provincia' },
                { name: 'pais', label: 'País' },
                { name: 'email', label: 'Email' },
                { name: 'moto_num', label: 'Moto Nº' },
                { name: 'numero_personas', label: 'Número de Personas' },
                { name: 'tiempo_excursion', label: 'Tiempo de la excursión' },
                { name: 'dia', label: 'Día' },
                { name: 'mes', label: 'Mes' },
                { name: 'anio', label: 'Año' }
            ];
            fieldsToCheck.forEach(field => {
                const inputElem = document.querySelector(`input[name="${field.name}"]`);
                if (!inputElem || !inputElem.value.trim()) {
                    missing.push(field.label);
                }
            });
                // Comprobación del consentimiento obligatorio
            const consentimiento = document.querySelector('input[name="no_consentimiento"]');
            if (!consentimiento || !consentimiento.checked) {
                missing.push("Consentimiento de tratamiento de datos");
            }

            if (missing.length > 0) {
                alert("Los siguientes campos son obligatorios:\n" + missing.join("\n"));
                return false;
            }
            if (missing.length > 0) {
                alert("Los siguientes campos son obligatorios:\n" + missing.join("\n"));
                return false;
            }
            return true;
        }

        function printBody() {
            // Verificar que los campos obligatorios estén rellenados
            if (!checkFields()) {
                return;
            }
            // Obtenemos el contenedor principal
            const content = document.querySelector('.imprimit');
            if (!content) return;

            // Clonamos todo el contenido (para no alterar el original)
            const contentClone = content.cloneNode(true);

            // ───────────────────────────────────────────────────────────────────
            // 1. Eliminar elementos que NO se deben imprimir:
            //    - Botones (si usan clase .no-print)
            //    - Footer (si usa clase .footer)
            //    - Header, si tuvieras
            // ───────────────────────────────────────────────────────────────────
            contentClone.querySelectorAll(`
    .no-print, .footer, head, header, footer, nav, 
    .header, .cabecera-extra, .info-top, .bg-grisSuave, 
    #csrfToken, input[name="csrf-token"], meta[name="csrf-token"], 
    input[type="hidden"]
`).forEach(el => el.remove());



            // ───────────────────────────────────────────────────────────────────
            // 2. Capturar firma y reemplazar canvas por imagen
            //    (esto asume que tus canvas tienen ID 'signature-pad-participant' y 'signature-pad-tutor')
            // ───────────────────────────────────────────────────────────────────

            // Firma del participante
            const signatureParticipant = document.getElementById('signature-pad-participant');
            if (signatureParticipant) {
                const dataUrlParticipant = signatureParticipant.toDataURL('image/png');
                const participantImage = document.createElement('img');
                participantImage.src = dataUrlParticipant;
                participantImage.style.border = '1px solid #000'; // opcional, para verse igual
                // Buscar el canvas clon en el DOM clonado y reemplazarlo
                const participantCanvasClone = contentClone.querySelector('#signature-pad-participant');
                if (participantCanvasClone) {
                participantCanvasClone.replaceWith(participantImage);
                }
            }

            // Firma del tutor
            const signatureTutor = document.getElementById('signature-pad-tutor');
            if (signatureTutor) {
                const dataUrlTutor = signatureTutor.toDataURL('image/png');
                const tutorImage = document.createElement('img');
                tutorImage.src = dataUrlTutor;
                tutorImage.style.border = '1px solid #000'; // opcional
                // Buscar el canvas clon en el DOM clonado y reemplazarlo
                const tutorCanvasClone = contentClone.querySelector('#signature-pad-tutor');
                if (tutorCanvasClone) {
                tutorCanvasClone.replaceWith(tutorImage);
                }
            }

            // ───────────────────────────────────────────────────────────────────
            // 3. Reemplazar cada input por un texto (span) con el valor
            //    y para los checkbox mostrar "Sí" o "No".
            // ───────────────────────────────────────────────────────────────────
            const inputs = contentClone.querySelectorAll('input');
            inputs.forEach(input => {
                const span = document.createElement('span');
                if (input.type === 'checkbox') {
                // Mostramos "Sí" / "No" según su estado
                span.textContent = input.checked ? 'Sí' : 'No';
                } else {
                // Para texto, email, tel, etc.
                span.textContent = input.value;
                }
                input.parentNode.replaceChild(span, input);
            });
            // 6. Construir el nombre del archivo basado en los valores de ciertos inputs
            const dni = document.querySelector('input[name="documento_identidad"]').value || 'IdNotFound';
            const fullname = document.querySelector('input[name="nombre_contrato"]').value || 'NameNotFound';
            const now = new Date();
            const day = ('0' + now.getDate()).slice(-2);
            const month = ('0' + (now.getMonth() + 1)).slice(-2);
            const year = now.getFullYear();
            const fecha = `${day}${month}${year}`;
            const filename = `${dni}_${fullname}_${fecha}_motoagua.pdf`;
            // ───────────────────────────────────────────────────────────────────
            // 4. Abrir nueva ventana, inyectar el contenido clonado y llamar a print
            // ───────────────────────────────────────────────────────────────────
            const printWindow = window.open('', '', 'height=800,width=900');
            printWindow.document.write(`<html><head><title>${filename}</title>`);
            printWindow.document.write(
                '<style>' +
                'body { font-family: Arial, sans-serif; margin: 20px; } ' +
                '.container { max-width: 900px; margin: auto; } ' +
                '</style>'
            );
            printWindow.document.write('</head><body>');
            printWindow.document.write(contentClone.innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();

            // Esperar un poco antes de imprimir, para asegurar que cargue todo
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 500);
            }

    </script>


</body>


@endsection