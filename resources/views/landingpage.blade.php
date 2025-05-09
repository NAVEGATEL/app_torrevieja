@extends('../layouts/public')

@section('content')
<style>
    .language-toggle {
        position: absolute;
        top: 15px;
        right: 20px;
        z-index: 1000;
        display: flex;
    }

    .language-toggle img {
        width: 32px;
        height: auto;
        cursor: pointer;
        margin-left: 10px;
    }

    .uniform-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 8px;
    }

    @media (max-width: 768px) {
        .uniform-img {
            height: 180px;
        }
        .language-toggle img {
            width: 28px;
            margin-left: 8px;
        }
    }

    @media (max-width: 576px) {
        .uniform-img {
            height: 150px;
        }
        .language-toggle {
            top: 10px;
            right: 10px;
        }
    }
</style>

<div class="language-toggle">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7c/Spain_flag_icon.svg/2048px-Spain_flag_icon.svg.png" alt="Español" onclick="switchToSpanish()" title="Español">
    <img src="https://thumbs.dreamstime.com/b/bot%C3%B3n-del-lenguaje-ingl%C3%A9s-7315218.jpg" alt="English" onclick="switchToEnglish()" title="English">
</div>

<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1 id="main-title">Bienvenido</h1>
            <p id="intro-text">Selecciona el consentimiento para la actividad que vas a realizar.</p>
        </div>

        <section class="col-12 text-center mt-5">
            <p id="consent-general" class="mb-4">
                <strong>Elige tu ciudad:</strong>
            </p>
            <div class="row justify-content-center">

                <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4 text-center">
                    <img src="https://hanssonhertzell.se/media/images/news/o_1gvj9bio61lh210rt1t3vttdl8s.jpg" class="uniform-img img-fluid mb-3">
                    <a href="/consentT" class="btn btn-primary btn-lg w-100 py-3 py-sm-4 shadow rounded-pill" id="btn-torrevieja">
                        Consentimientos Torrevieja
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4 text-center">
                    <img src="https://media.istockphoto.com/id/1272108805/es/foto/playa-y-costa-del-postiguet-en-alicante-espa%C3%B1a.jpg?s=612x612&w=0&k=20&c=lBVUFH1OP_noV-wx_mt9RSU8iFsmmX9Di7c42PWZnU0=" class="uniform-img img-fluid mb-3">
                    <a href="/consentA" class="btn btn-success btn-lg w-100 py-3 py-sm-4 shadow rounded-pill" id="btn-alicante">
                        Consentimientos Alicante
                    </a>
                </div>

            </div>

            <p id="consent-moto" class="mt-4 mb-3">
                <strong>¿Actividad en moto de agua?</strong>
            </p>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-3 text-center">
                    <img src="/img/motoagua.png" class="uniform-img img-fluid mb-3">
                    <a href="/consentMoto" class="btn btn-info btn-lg w-100 py-3 py-sm-4 shadow rounded-pill" id="btn-moto">
                        Consentimientos Moto de agua
                    </a>
                </div>
            </div>

        </section>
    </div>
</div>

<script>
    function switchToEnglish() {
        document.getElementById('main-title').textContent = 'Welcome';
        document.getElementById('intro-text').textContent = 'Select the consent for your chosen activity.';
        document.getElementById('consent-general').innerHTML = '<strong>Select your city:</strong>';
        document.getElementById('btn-torrevieja').textContent = 'Torrevieja Consents';
        document.getElementById('btn-alicante').textContent = 'Alicante Consents';
        document.getElementById('consent-moto').innerHTML = '<strong>Jet ski activity?</strong>';
        document.getElementById('btn-moto').textContent = 'Jet Ski Consents';
    }

    function switchToSpanish() {
        document.getElementById('main-title').textContent = 'Bienvenido';
        document.getElementById('intro-text').textContent = 'Selecciona el consentimiento para la actividad que vas a realizar.';
        document.getElementById('consent-general').innerHTML = '<strong>Elige tu ciudad:</strong>';
        document.getElementById('btn-torrevieja').textContent = 'Consentimientos Torrevieja';
        document.getElementById('btn-alicante').textContent = 'Consentimientos Alicante';
        document.getElementById('consent-moto').innerHTML = '<strong>¿Actividad en moto de agua?</strong>';
        document.getElementById('btn-moto').textContent = 'Consentimientos Moto de agua';
    }
</script>
@endsection
