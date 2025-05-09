@extends('../layouts/public') <!-- Extiende el layout public.blade.php -->
@section('content')
<!-- Meta tag CSRF para las peticiones AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Asegurarnos de que Bootstrap esté cargado -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

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
            granText: "By this document I acknowledge that the company ACTIVIDADES NÁUTICAS TORREVIEJA, S.L., operator of the jet ski initiation activity, has explained to me what the activity consists of, the instructions for use, safety measures, and the whole procedure to be followed throughout its development for the correct use of the aforesaid.I have also been informed about the limitations and the situations in which the device is not to be used, such as being under the influence of alcohol or drugs, experiencing a decrease of physical or mental faculties, etc. I am responsible for any damage caused to the material I am provided by the operator and I accept to pay the reparations in case of not following the indications of the instructors. I have been translated this text, which I sign to indicate approval and conformity after being aware of and understanding all its content. I exempt the company from any responsibility for the loss of objects by performing the activity.",
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

    /* Añadir estilos para los campos con error */
    input.campo-error {
        border: 2px solid #ff0000 !important;
        background-color: rgba(255, 0, 0, 0.05);
    }
    .canvas-error {
        border: 2px solid #ff0000 !important;
    }
    .campo-obligatorio {
        color: red;
        font-size: 11px;
        display: none;
        margin-top: 2px;
    }
</style>

<!-- Contenido del formulario -->
<body class="imprimit">

    <!-- HTML contenido -->
    <div class="container p-5">
        <form id="formularioMoto" method="POST" action="#" onsubmit="return false;">
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
                <button type="button" class="btn btn-primary" id="submitBtn">Enviar</button>
                <button type="button" class="btn btn-secondary" onclick="rellenarDatosEjemplo()">Rellenar con datos de ejemplo</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap y scripts necesarios -->
    <script>
        // Verificar que Bootstrap está disponible
        window.addEventListener('load', function() {
            if (typeof bootstrap === 'undefined') {
                console.error('Bootstrap no está disponible. Cargando versión de respaldo...');
                // Intentamos cargar Bootstrap si no está disponible
                const cssLink = document.createElement('link');
                cssLink.rel = 'stylesheet';
                cssLink.href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css';
                document.head.appendChild(cssLink);
                
                const scriptTag = document.createElement('script');
                scriptTag.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js';
                document.head.appendChild(scriptTag);
                
                scriptTag.onload = function() {
                    console.log('Bootstrap cargado con éxito');
                    // Inicializar los botones después de cargar Bootstrap
                    initButtonHandlers();
                };
            } else {
                console.log('Bootstrap ya está disponible');
                // Inicializar los botones directamente
                initButtonHandlers();
            }
            
            // Añadir manejadores para eventos del modal
            document.body.addEventListener('click', function(e) {
                // Cuando se hace click en el botón de cerrar o el backdrop del modal
                if (e.target.hasAttribute('data-bs-dismiss') || 
                    e.target.classList.contains('modal') && e.target.id === 'previewModal') {
                    closePreviewModal();
                }
            });
        });
        
        function closePreviewModal() {
            const modalElement = document.getElementById('previewModal');
            if (modalElement) {
                // Si es un modal Bootstrap, cerrarlo correctamente
                if (typeof bootstrap !== 'undefined') {
                    try {
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    } catch (e) {
                        console.warn('Error al cerrar el modal:', e);
                    }
                }
                
                // Limpiar el contenido para liberar memoria
                const previewContent = document.getElementById('previewContent');
                if (previewContent) {
                    previewContent.innerHTML = '';
                }
            }
        }
        
        function initButtonHandlers() {
            // Configurar el botón de envío
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.addEventListener('click', function(event) {
                    console.log("Botón de enviar clickeado");
                    printBody(event);
                });
            } else {
                console.error("No se encontró el botón de envío");
            }
            
            // Configurar el botón de procesar formulario
            const processFormBtn = document.getElementById('processFormBtn');
            if (processFormBtn) {
                processFormBtn.addEventListener('click', function(event) {
                    procesarFormulario();
                });
            } else {
                console.error("No se encontró el botón de procesar formulario");
            }
        }
    </script>

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
        // Función para mostrar toasts en lugar de alertas
        function showToast(message, type = 'success') {
            console.log(`Toast (${type}): ${message}`);
            
            // Crear el contenedor de toasts si no existe
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                document.body.appendChild(toastContainer);
            }
            
            // Crear ID único para este toast
            const toastId = 'toast-' + new Date().getTime();
            
            // Determinar el color del toast según el tipo
            let bgClass = 'bg-success';
            if (type === 'error') {
                bgClass = 'bg-danger';
            } else if (type === 'warning') {
                bgClass = 'bg-warning';
            } else if (type === 'info') {
                bgClass = 'bg-info';
            }
            
            // Crear el HTML del toast
            const toastHtml = `
                <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header ${bgClass} text-white">
                        <strong class="me-auto">${type === 'error' ? 'Error' : 'Éxito'}</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
            
            // Añadir el toast al contenedor
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);
            
            // Si bootstrap no está disponible, simplemente mostrar un alert
            if (typeof bootstrap === 'undefined') {
                alert(`${type.toUpperCase()}: ${message}`);
                return;
            }
            
            // Inicializar y mostrar el toast
            try {
                const toast = new bootstrap.Toast(document.getElementById(toastId), {
                    delay: 5000
                });
                toast.show();
                
                // Eliminar el toast del DOM después de ocultarse
                const toastEl = document.getElementById(toastId);
                toastEl.addEventListener('hidden.bs.toast', () => {
                    toastEl.remove();
                });
            } catch (error) {
                console.error("Error al mostrar toast:", error);
                alert(`${type.toUpperCase()}: ${message}`);
            }
        }

        function checkFields() {
            let missing = [];
            // Primero, quitar las clases de error de todos los campos
            document.querySelectorAll('input, canvas').forEach(field => {
                field.classList.remove('campo-error', 'canvas-error');
                // Ocultar mensajes de error previos
                const errorMsg = field.parentElement.querySelector('.campo-obligatorio');
                if (errorMsg) errorMsg.style.display = 'none';
            });
            
            // Lista de campos obligatorios con su selector y mensaje
            const fieldsToCheck = [
                { selector: 'input[name="nombre_contrato"]', label: 'Nombre del contrato' },
                { selector: 'input[name="documento_identidad"]', label: 'Documento de Identidad' },
                { selector: 'input[name="telefono"]', label: 'Teléfono' },
                { selector: 'input[name="nombre_apellidos"]', label: 'Nombre y Apellidos' },
                { selector: 'input[name="direccion"]', label: 'Dirección' },
                { selector: 'input[name="poblacion"]', label: 'Población' },
                { selector: 'input[name="provincia"]', label: 'Provincia' },
                { selector: 'input[name="pais"]', label: 'País' },
                { selector: 'input[name="email"]', label: 'Email' },
                { selector: 'input[name="moto_num"]', label: 'Moto Nº' },
                { selector: 'input[name="numero_personas"]', label: 'Número de Personas' },
                { selector: 'input[name="tiempo_excursion"]', label: 'Tiempo de la excursión' },
                { selector: 'input[name="dia"]', label: 'Día' },
                { selector: 'input[name="mes"]', label: 'Mes' },
                { selector: 'input[name="anio"]', label: 'Año' }
            ];
            
            // Verificar cada campo y marcar con error si está vacío
            fieldsToCheck.forEach(field => {
                const inputElem = document.querySelector(field.selector);
                if (!inputElem || !inputElem.value.trim()) {
                    missing.push(field.label);
                    
                    // Marcar el campo con error
                    inputElem.classList.add('campo-error');
                    
                    // Añadir mensaje de campo obligatorio si no existe
                    let errorMsg = inputElem.parentElement.querySelector('.campo-obligatorio');
                    if (!errorMsg) {
                        errorMsg = document.createElement('div');
                        errorMsg.className = 'campo-obligatorio';
                        errorMsg.textContent = 'Campo obligatorio';
                        inputElem.insertAdjacentElement('afterend', errorMsg);
                    }
                    errorMsg.style.display = 'block';
                    
                    // Agregar evento para quitar el error cuando el usuario escriba
                    inputElem.addEventListener('input', function() {
                        if (this.value.trim()) {
                            this.classList.remove('campo-error');
                            const msg = this.parentElement.querySelector('.campo-obligatorio');
                            if (msg) msg.style.display = 'none';
                        }
                    });
                }
            });
                
            // Comprobar firma del participante
            const signatureParticipant = document.getElementById('signature-pad-participant');
            if (signatureParticipant) {
                const ctx = signatureParticipant.getContext('2d');
                const pixeles = ctx.getImageData(0, 0, signatureParticipant.width, signatureParticipant.height).data;
                if (!pixeles.some(pixel => pixel !== 0)) {
                    missing.push('Firma del participante');
                    signatureParticipant.classList.add('canvas-error');
                    
                    // Añadir mensaje de campo obligatorio
                    let errorMsg = signatureParticipant.parentElement.querySelector('.campo-obligatorio');
                    if (!errorMsg) {
                        errorMsg = document.createElement('div');
                        errorMsg.className = 'campo-obligatorio';
                        errorMsg.textContent = 'Firma obligatoria';
                        signatureParticipant.insertAdjacentElement('afterend', errorMsg);
                    }
                    errorMsg.style.display = 'block';
                }
            }
            
            // Comprobar firma del tutor si es necesaria
            const fechaNacimiento = document.getElementById('fecha_nacimiento')?.value;
            if (fechaNacimiento) {
                const fechaNac = new Date(fechaNacimiento);
                let edad = new Date().getFullYear() - fechaNac.getFullYear();
                if (edad < 18) {
                    const signatureTutor = document.getElementById('signature-pad-tutor');
                    if (signatureTutor) {
                        const ctx = signatureTutor.getContext('2d');
                        const pixeles = ctx.getImageData(0, 0, signatureTutor.width, signatureTutor.height).data;
                        if (!pixeles.some(pixel => pixel !== 0)) {
                            missing.push('Firma del tutor');
                            signatureTutor.classList.add('canvas-error');
                            
                            // Añadir mensaje de campo obligatorio
                            let errorMsg = signatureTutor.parentElement.querySelector('.campo-obligatorio');
                            if (!errorMsg) {
                                errorMsg = document.createElement('div');
                                errorMsg.className = 'campo-obligatorio';
                                errorMsg.textContent = 'Firma del tutor obligatoria';
                                signatureTutor.insertAdjacentElement('afterend', errorMsg);
                            }
                            errorMsg.style.display = 'block';
                        }
                    }
                    
                    const nombreTutor = document.getElementById('nombre_tutor');
                    if (!nombreTutor || !nombreTutor.value.trim()) {
                        missing.push('Nombre del tutor');
                        nombreTutor.classList.add('campo-error');
                        
                        // Añadir mensaje de campo obligatorio
                        let errorMsg = nombreTutor.parentElement.querySelector('.campo-obligatorio');
                        if (!errorMsg) {
                            errorMsg = document.createElement('div');
                            errorMsg.className = 'campo-obligatorio';
                            errorMsg.textContent = 'Campo obligatorio';
                            nombreTutor.insertAdjacentElement('afterend', errorMsg);
                        }
                        errorMsg.style.display = 'block';
                        
                        // Quitar error al escribir
                        nombreTutor.addEventListener('input', function() {
                            if (this.value.trim()) {
                                this.classList.remove('campo-error');
                                const msg = this.parentElement.querySelector('.campo-obligatorio');
                                if (msg) msg.style.display = 'none';
                            }
                        });
                    }
                }
            }
            
            // Comprobar que al menos un método de pago esté seleccionado
            const pagoTarjeta = document.querySelector('input[name="pago_tarjeta"]');
            const pagoEfectivo = document.querySelector('input[name="pago_efectivo"]');
            if (!pagoTarjeta.checked && !pagoEfectivo.checked) {
                missing.push('Método de pago');
                const pagoContainer = pagoTarjeta.closest('div');
                pagoContainer.classList.add('campo-error');
                
                // Añadir mensaje de campo obligatorio
                let errorMsg = pagoContainer.querySelector('.campo-obligatorio');
                if (!errorMsg) {
                    errorMsg = document.createElement('div');
                    errorMsg.className = 'campo-obligatorio';
                    errorMsg.textContent = 'Seleccione un método de pago';
                    pagoContainer.appendChild(errorMsg);
                }
                errorMsg.style.display = 'block';
                
                // Quitar error al seleccionar
                [pagoTarjeta, pagoEfectivo].forEach(elem => {
                    elem.addEventListener('change', function() {
                        if (pagoTarjeta.checked || pagoEfectivo.checked) {
                            pagoContainer.classList.remove('campo-error');
                            const msg = pagoContainer.querySelector('.campo-obligatorio');
                            if (msg) msg.style.display = 'none';
                        }
                    });
                });
            }

            if (missing.length > 0) {
                showToast("Hay campos obligatorios sin completar. Por favor, revisa los campos marcados en rojo.", "error");
                // Hacer scroll al primer campo con error
                const firstError = document.querySelector('.campo-error, .canvas-error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return false;
            }
            return true;
        }

        async function printBody(event) {
            if (event) event.preventDefault();
            
            console.log("Función printBody ejecutada");
            
            if (!checkFields()) {
                console.log("Validación de campos falló");
                return;
            }
            
            console.log("Validación de campos correcta, preparando vista previa");
            
            // Verificamos primero si existe el modal o lo creamos si no existe
            let previewModalElement = document.getElementById('previewModal');
            if (!previewModalElement) {
                console.warn("Modal no encontrado en el DOM. Creándolo dinámicamente...");
                
                // Crear el modal dinámicamente
                const modalHTML = `
                <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="previewModalLabel">Vista previa del formulario</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="previewContent" style="max-height: 65vh; overflow-y: auto;"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="processFormBtn">Confirmar y Descargar</button>
                            </div>
                        </div>
                    </div>
                </div>`;
                
                // Insertar el modal en el DOM
                document.body.insertAdjacentHTML('beforeend', modalHTML);
                previewModalElement = document.getElementById('previewModal');
                
                // Configurar el botón de procesar formulario
                document.getElementById('processFormBtn').addEventListener('click', function() {
                    procesarFormulario();
                });
            }
            
            // Ahora buscamos el contenedor de previsualización
            const previewContent = document.getElementById('previewContent');
            if (!previewContent) {
                console.error("No se encontró el contenedor de vista previa incluso después de crear el modal");
                alert("Error crítico: No se pudo crear el modal de vista previa");
                return;
            }
            
            // Para el contenido del formulario, intentamos varios selectores posibles
            let content = document.querySelector('body.imprimit');
            if (!content) {
                content = document.querySelector('form#formularioMoto');
                if (!content) {
                    content = document.querySelector('form');
                    if (!content) {
                        console.error("No se pudo encontrar el contenido del formulario");
                        alert("Error: No se pudo encontrar el contenido del formulario");
                        return;
                    }
                }
            }
            
            console.log("Contenido encontrado correctamente:", content);
            previewContent.innerHTML = ''; // Limpiar contenido anterior
            
            // Clonar el contenido
            const contentClone = content.cloneNode(true);
            
            // Eliminar elementos no necesarios en la vista previa
            contentClone.querySelectorAll(`
                .no-print, button, meta, script, 
                input[name="csrf-token"], meta[name="csrf-token"], 
                input[type="hidden"]
            `).forEach(el => el.remove());
            
            // Reemplazar canvas con imágenes en el clon
            const signatureParticipant = document.getElementById('signature-pad-participant');
            if (signatureParticipant) {
                const dataUrlParticipant = signatureParticipant.toDataURL('image/png');
                const img = document.createElement('img');
                img.src = dataUrlParticipant;
                img.style.border = '1px solid #000';
                img.style.width = '50%';
                img.style.height = '100px';
                const canvasElement = contentClone.querySelector('#signature-pad-participant');
                if (canvasElement && canvasElement.parentNode) {
                    canvasElement.parentNode.replaceChild(img, canvasElement);
                }
            }
            
            const signatureTutor = document.getElementById('signature-pad-tutor');
            if (signatureTutor && signatureTutor.closest('div').style.display !== 'none') {
                const dataUrlTutor = signatureTutor.toDataURL('image/png');
                const img = document.createElement('img');
                img.src = dataUrlTutor;
                img.style.border = '1px solid #000';
                img.style.width = '50%';
                img.style.height = '100px';
                const canvasElement = contentClone.querySelector('#signature-pad-tutor');
                if (canvasElement && canvasElement.parentNode) {
                    canvasElement.parentNode.replaceChild(img, canvasElement);
                }
            }
            
            // Reemplazar inputs con su valor como texto
            contentClone.querySelectorAll('input[type="text"], input[type="number"], input[type="tel"], input[type="email"], input[type="date"]').forEach(input => {
                const value = input.value || '';
                const span = document.createElement('span');
                span.textContent = value;
                span.style.fontWeight = 'bold';
                span.style.color = '#000';
                if (input.parentNode) {
                    input.parentNode.replaceChild(span, input);
                }
            });
            
            // Manejar checkboxes
            contentClone.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                const checked = checkbox.checked;
                const span = document.createElement('span');
                span.textContent = checked ? '✓' : '✗';
                span.style.fontWeight = 'bold';
                if (checkbox.parentNode) {
                    checkbox.parentNode.replaceChild(span, checkbox);
                }
            });
            
            // Aplicar algo de estilo al contenido del modal
            contentClone.style.transform = 'scale(0.8)';
            contentClone.style.transformOrigin = 'top left';
            
            // Añadir el contenido al modal
            previewContent.appendChild(contentClone);
            
            // Mostrar el modal
            try {
                console.log("Intentando abrir el modal...");
                if (typeof bootstrap === 'undefined') {
                    console.error("Bootstrap no está disponible. Cargando respaldo...");
                    
                    // Cargar Bootstrap si no está disponible y mostrar el modal después
                    const scriptTag = document.createElement('script');
                    scriptTag.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js';
                    scriptTag.onload = function() {
                        console.log("Bootstrap cargado. Abriendo modal...");
                        const bsModal = new bootstrap.Modal(previewModalElement);
                        bsModal.show();
                    };
                    document.head.appendChild(scriptTag);
                } else {
                    // Bootstrap ya está disponible, usar directamente
                    const bsModal = new bootstrap.Modal(previewModalElement);
                    bsModal.show();
                }
            } catch (error) {
                console.error("Error al mostrar modal con Bootstrap:", error);
                alert("No se pudo mostrar la vista previa. Procesando formulario directamente.");
                procesarFormulario();
            }
        }
        
        async function procesarFormulario() {
            console.log("Iniciando procesamiento del formulario");
            
            try {
                // Cerrar el modal si existe
                closePreviewModal();
                
                // Mostrar spinner de carga
                document.body.insertAdjacentHTML('beforeend', '<div id="loading-spinner" class="position-fixed w-100 h-100 d-flex justify-content-center align-items-center bg-white bg-opacity-75" style="top: 0; left: 0; z-index: 9999;"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Procesando...</span></div><div class="ms-2">Procesando formulario...</div></div>');
                console.log("Spinner de carga mostrado");
    
                const content = document.querySelector('.imprimit');
                if (!content) {
                    console.error("No se encontró el contenido del formulario");
                    document.getElementById('loading-spinner')?.remove();
                    showToast('Error: No se pudo encontrar el contenido del formulario', 'error');
                    return;
                }
    
                const contentClone = content.cloneNode(true);
                console.log("Contenido clonado correctamente");
    
                contentClone.querySelectorAll(`
                    .no-print, .footer, head, header, footer, nav, 
                    .header, .cabecera-extra, .info-top, .bg-grisSuave, 
                    #csrfToken, input[name="csrf-token"], meta[name="csrf-token"], 
                    input[type="hidden"]
                `).forEach(el => el.remove());
    
                // Reemplazar canvas con imágenes en el clon
                console.log("Procesando firmas...");
                const signatureParticipant = document.getElementById('signature-pad-participant');
                if (signatureParticipant) {
                    const dataUrlParticipant = signatureParticipant.toDataURL('image/png');
                    const img = document.createElement('img');
                    img.src = dataUrlParticipant;
                    img.style.border = '1px solid #000';
                    const clone = contentClone.querySelector('#signature-pad-participant');
                    if (clone) clone.replaceWith(img);
                }
    
                const signatureTutor = document.getElementById('signature-pad-tutor');
                if (signatureTutor && signatureTutor.parentNode.style.display !== 'none') {
                    const dataUrlTutor = signatureTutor.toDataURL('image/png');
                    const img = document.createElement('img');
                    img.src = dataUrlTutor;
                    img.style.border = '1px solid #000';
                    const clone = contentClone.querySelector('#signature-pad-tutor');
                    if (clone) clone.replaceWith(img);
                }
    
                // Reemplazar inputs con su valor como texto
                console.log("Procesando campos de entrada...");
                const inputs = contentClone.querySelectorAll('input');
                inputs.forEach(input => {
                    const span = document.createElement('span');
                    span.textContent = input.type === 'checkbox' ? (input.checked ? 'Sí' : 'No') : input.value;
                    input.parentNode.replaceChild(span, input);
                });
    
                // Construir nombre de archivo
                const dni = document.querySelector('input[name="documento_identidad"]').value || 'IdNotFound';
                const now = new Date();
                const day = ('0' + now.getDate()).slice(-2);
                const month = ('0' + (now.getMonth() + 1)).slice(-2);
                const year = now.getFullYear();
                const fecha = `${day}${month}${year}`;
                const timestamp = Math.floor(now.getTime() / 1000);
                const filename = `consent_moto_${dni}_${timestamp}.pdf`;
                
                // Guardar la fecha en localStorage
                localStorage.setItem('printDate', `${day}/${month}/${year}`);
    
                // Crear elemento con el contenido formateado para PDF
                console.log("Generando PDF...");
                const element = document.createElement('div');
                element.innerHTML = contentClone.innerHTML;
    
                const opt = {
                    margin: 0.5,
                    filename: filename,
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                };
    
                // Generar el PDF como data URL
                console.log("Generando data URL del PDF...");
                const pdfDataUrl = await html2pdf().set(opt).from(element).outputPdf('datauristring');
                console.log("PDF generado correctamente");
                
                // Enviar PDF al backend
                console.log("Enviando PDF al backend...");
                const backendResult = await enviarPDFAlBackend(pdfDataUrl, filename);
                console.log("Resultado del backend:", backendResult);
                
                // También guardar localmente
                console.log("Guardando PDF localmente...");
                html2pdf().set(opt).from(element).save();
                
                // Mostrar mensaje de éxito
                document.getElementById('loading-spinner')?.remove();
                showToast('¡Formulario enviado correctamente!', 'success');
                
                // Recargar después de un momento
                console.log("Recargando página en 3 segundos...");
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            } catch (error) {
                console.error('Error en procesarFormulario:', error);
                document.getElementById('loading-spinner')?.remove();
                showToast('Error al procesar el formulario: ' + error.message, 'error');
            }
        }

    async function enviarPDFAlBackend(pdfDataUrl, filename) {
        try {
            console.log("Iniciando envío al backend");
            // Recopilar datos para el backend
            const formData = new FormData();
            
            // Datos del cliente
            const clienteData = {
                nombre: document.querySelector('input[name="nombre_apellidos"]').value,
                dni: document.querySelector('input[name="documento_identidad"]').value,
                telefono: document.querySelector('input[name="telefono"]').value,
                email: document.querySelector('input[name="email"]').value,
                fecha_nacimiento: document.querySelector('input[name="fecha_nacimiento"]').value,
                actividad: 'Moto Náutica'
            };
            
            // Agregar datos al formData
            for (const [key, value] of Object.entries(clienteData)) {
                formData.append(key, value);
            }
            
            // Detalles de la actividad
            formData.append('moto_num', document.querySelector('input[name="moto_num"]').value);
            formData.append('numero_personas', document.querySelector('input[name="numero_personas"]').value);
            formData.append('tiempo_excursion', document.querySelector('input[name="tiempo_excursion"]').value);
            formData.append('precio_total', document.getElementById('precio_total')?.textContent || '0');
            
            // Si es menor de edad, incluir datos del tutor
            if (clienteData.fecha_nacimiento) {
                const fechaNac = new Date(clienteData.fecha_nacimiento);
                let edad = new Date().getFullYear() - fechaNac.getFullYear();
                if (edad < 18) {
                    formData.append('es_menor', 'true');
                    formData.append('nombre_tutor', document.getElementById('nombre_tutor').value);
                }
            }
            
            // Método de pago
            if (document.querySelector('input[name="pago_tarjeta"]').checked) {
                formData.append('metodo_pago', 'tarjeta');
            } else if (document.querySelector('input[name="pago_efectivo"]').checked) {
                formData.append('metodo_pago', 'efectivo');
            }
            
            // Agregar PDF
            formData.append('pdf_file', pdfDataUrl);
            formData.append('archivo_pdf', pdfDataUrl); // Nombre alternativo por si acaso
            
            // Obtener CSRF token
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (!metaTag) {
                console.error("CSRF token no encontrado");
                throw new Error("CSRF token no encontrado");
            }
            
            const csrfToken = metaTag.getAttribute('content');
            console.log("CSRF token obtenido");
            
            // Hacer la petición al servidor
            console.log("Enviando datos al servidor...");
            const response = await fetch('/consent/submitMoto', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData
            });
            
            if (!response.ok) {
                console.error("Respuesta del servidor no OK:", response.status);
                const errorText = await response.text();
                console.error("Error del servidor:", errorText);
                throw new Error(`Error HTTP: ${response.status}`);
            }
            
            const responseData = await response.json();
            console.log('Respuesta del servidor:', responseData);
            document.getElementById('loading-spinner')?.remove();
            return responseData;
            
        } catch (error) {
            console.error('Error al enviar el PDF al backend:', error);
            document.getElementById('loading-spinner')?.remove();
            showToast('Error al enviar el formulario al servidor: ' + error.message, 'error');
            return false;
        }
    }

    // Función para rellenar el formulario con datos de ejemplo
    function rellenarDatosEjemplo() {
        // Datos personales del contrato
        document.querySelector('input[name="nombre_contrato"]').value = "Juan García Martínez";
        document.querySelector('input[name="direccion"]').value = "Calle Marina 23";
        document.querySelector('input[name="poblacion"]').value = "Torrevieja";
        document.querySelector('input[name="pais"]').value = "España";
        document.querySelector('input[name="documento_identidad"]').value = "12345678A";
        document.querySelector('input[name="telefono"]').value = "666123456";
        document.querySelector('input[name="provincia"]').value = "Alicante";
        document.querySelector('input[name="email"]').value = "juan.garcia@example.com";
        
        // Datos del club y ticket
        document.querySelector('input[name="socio_club"]').value = "A-1234";
        document.querySelector('input[name="ticket"]').value = "T-" + Math.floor(1000 + Math.random() * 9000);
        
        // Datos personales adicionales
        document.querySelector('input[name="nombre_apellidos"]').value = "Juan García Martínez";
        document.querySelectorAll('input[name="direccion"]')[1].value = "Calle Marina 23";
        document.querySelectorAll('input[name="poblacion"]')[1].value = "Torrevieja";
        document.querySelectorAll('input[name="email"]')[1].value = "juan.garcia@example.com";
        document.querySelectorAll('input[name="pais"]')[1].value = "España";
        
        // Fecha de nacimiento (50% probabilidad de menor de edad)
        const esMenor = Math.random() > 0.5;
        const fechaNac = new Date();
        if (esMenor) {
            // Generar fecha para un menor (entre 12 y 17 años)
            fechaNac.setFullYear(fechaNac.getFullYear() - (12 + Math.floor(Math.random() * 6)));
        } else {
            // Generar fecha para un mayor de edad (entre 18 y 65 años)
            fechaNac.setFullYear(fechaNac.getFullYear() - (18 + Math.floor(Math.random() * 48)));
        }
        const fechaFormateada = fechaNac.toISOString().split('T')[0];
        document.getElementById('fecha_nacimiento').value = fechaFormateada;
        verificarEdad(); // Llamar para actualizar la visibilidad de los campos de tutor
        
        // Si es menor, rellenar datos del tutor
        if (esMenor) {
            document.getElementById('nombre_tutor').value = "María Martínez López";
        }
        
        // Datos de la actividad
        document.querySelector('input[name="moto_num"]').value = Math.floor(1 + Math.random() * 10);
        document.querySelector('input[name="numero_personas"]').value = Math.floor(1 + Math.random() * 3);
        document.querySelector('input[name="tiempo_excursion"]').value = "30 minutos";
        
        // Precios
        document.getElementById('oferta_combinada').value = 50;
        document.getElementById('fotos_gopro').value = 20;
        calcularTotal(); // Recalcular el total
        
        // Marcar un método de pago aleatorio
        document.querySelector('input[name="pago_tarjeta"]').checked = Math.random() > 0.5;
        document.querySelector('input[name="pago_efectivo"]').checked = !document.querySelector('input[name="pago_tarjeta"]').checked;
        
        // Fecha actual para el contrato
        const fechaActual = new Date();
        document.querySelector('input[name="dia"]').value = fechaActual.getDate();
        const meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
        document.querySelector('input[name="mes"]').value = meses[fechaActual.getMonth()];
        document.querySelector('input[name="anio"]').value = fechaActual.getFullYear().toString().substr(2);
        
        // Dibujar firmas simuladas en los canvas
        dibujarFirmaSimulada('signature-pad-participant');
        if (esMenor) {
            dibujarFirmaSimulada('signature-pad-tutor');
        }
        
        // Mostrar mensaje de confirmación
        showToast('Formulario rellenado con datos de ejemplo', 'info');
    }
    
    // Función para dibujar una firma simulada en el canvas
    function dibujarFirmaSimulada(canvasId) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Convertir las coordenadas del canvas a coordenadas de dispositivo
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;
        
        // Establecer estilo para la firma
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.strokeStyle = 'black';
        
        // Generar puntos para una firma simulada
        const startX = 20 * scaleX;
        const startY = 50 * scaleY;
        const width = (canvas.width / 2) * 0.8;
        const height = 30 * scaleY;
        
        ctx.beginPath();
        ctx.moveTo(startX, startY);
        
        // Generar una serie de puntos que simulan una firma
        let x = startX;
        const numPoints = 15;
        const segWidth = width / numPoints;
        
        for (let i = 0; i < numPoints; i++) {
            x += segWidth;
            let y = startY + (Math.random() - 0.5) * height;
            ctx.lineTo(x, y);
        }
        
        ctx.stroke();
    }
    </script>


</body>


@endsection