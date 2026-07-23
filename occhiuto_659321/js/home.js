document.addEventListener("DOMContentLoaded", () => {
    const track = document.querySelector('.carousel-track');
    const slides = Array.from(track.children);
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');

    // --- VARIABILE DI STATO PER TRACCIARE L'INDICE DELLA SLIDE CORRENTE ---
    let currentIndex = 0;

    // --- AGGIORNAMENTO VISUALE DEL CAROSELLO ---
    // --- Applica la trasformazione CSS per scorrere le slide orizzontalmente ---
    const updateCarousel = () => {
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
    };

    // --- REINDIRIZZAMENTO PAGINA FILM ---
    // --- Seleziona sia le card del carosello che i titoli della programmazione ---
    const elementiCliccabili = document.querySelectorAll('.film-card, .titolo-film');

    elementiCliccabili.forEach(elemento => {
        elemento.addEventListener('click', (e) => {
            const urlSpecifico = e.currentTarget.getAttribute('data-url');
            if (urlSpecifico) {
                // --- REINDIRIZZATO ALLA PAGINA DI DETTAGLIO DEL FILM ---
                window.location.href = urlSpecifico;
            }
        });
    });

    // --- GESTIONE BOTTONI CAROSELLO ---
    // --- INCREMENTA L'INDICE SE NON E' ALL'ULTIMA SLIDE ---
    nextBtn.addEventListener('click', () => {
        if (currentIndex < slides.length - 1) {
            currentIndex++;
            updateCarousel();
        }
    });

    // --- DECREMENTA L'INDICE SE NON E' ALLA PRIMA SLIDE ---
    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });
});