console.log("Script de Bloqueo Canva cargado");
function agregarEventosCanvasBloqueo(canvasId) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;

        let scrollX = 0;
        let scrollY = 0;
        let isDrawing = false;

        function bloquearScroll(e) {
            if (!isDrawing) return;
            e.preventDefault();
            
            scrollX = window.scrollX || document.documentElement.scrollLeft;
            scrollY = window.scrollY || document.documentElement.scrollTop;
            
            document.body.style.overflow = 'hidden'; 
        }

        function desbloquearScroll() {
            if (!isDrawing) return;
            
            document.body.style.overflow = ''; 
            
            isDrawing = false;
        }

        function handleStart(e) {
            isDrawing = true;
            bloquearScroll(e);
        }

        // Mouse events
        canvas.addEventListener('mousedown', handleStart);
        canvas.addEventListener('mouseup', desbloquearScroll);
        canvas.addEventListener('mouseleave', desbloquearScroll);
        
        // Touch events
        canvas.addEventListener('touchstart', handleStart, { passive: false });
        canvas.addEventListener('touchend', desbloquearScroll);
        canvas.addEventListener('touchcancel', desbloquearScroll);
        canvas.addEventListener('touchmove', (e) => {
            if (isDrawing) e.preventDefault();
        }, { passive: false });
        
        // Prevent scrolling on the whole document while drawing
        document.addEventListener('scroll', (e) => {
            if (isDrawing) e.preventDefault();
        }, { passive: false });
    }

// Exponer al ámbito global
window.agregarEventosCanvasBloqueo = agregarEventosCanvasBloqueo;