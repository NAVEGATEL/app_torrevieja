<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger">
            <img src="..." class="rounded me-2" alt="...">
            <strong class="me-auto text-light">Tamaño imagen NO valido</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            El tamaño del archivo es demasiado grande. Tiene que ser menor de 1MB!
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<script>
    function validateFileSize(input) {
        if (input.files && input.files[0]) {
            var fileSize = input.files[0].size;
            var maxSize = 1048576; // 1MB in bytes

            if (fileSize > maxSize) {
                input.value = '';
                const toastLiveExample = document.getElementById('liveToast')
                const toast = new bootstrap.Toast(toastLiveExample)
                toast.show()
                return false;
            }
        }
        return true;
    }
</script>