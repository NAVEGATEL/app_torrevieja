@extends('../layouts/public') <!-- Extiende el layout public.blade.php -->
@section('content')

<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<!-- ###################################################################################################### -->
<script>  
    const CIUDAD = "Alicante"
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
            granText: "By this document I acknowledge that the company ACTIVIDADES NÁUTICAS TORREVIEJA, S.L., operator of the jet ski initiation activity, has explained to me what the activity consists of, the instructions for use, safety measures, and the procedure to follow during the excursion for its proper development. I have also been informed about the limitations and cases where the jet ski cannot be used, such as being under the influence of alcohol, drugs, or having impaired physical or mental abilities, etc... I take responsibility for any damage caused to the material provided here and agree to pay for any breakages caused by not following the instructions given by the company's monitors. I also acknowledge that this text has been translated for me, which I sign to confirm my full understanding and consent. I release the company from any responsibility for the loss of objects during the activity.",
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

@include('consents.main')

@endsection