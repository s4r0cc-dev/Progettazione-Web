document.addEventListener("DOMContentLoaded", () => {
    // --- DATI DEI FILM DA REINDERIZZARE ---
    const filmData = [
        { id: "COCO", titolo: "Coco" },
        { id: "ELIO", titolo: "Elio" },
        { id: "INSIDE-OUT-2", titolo: "Inside Out 2" },
        { id: "LILO-E-STITCH", titolo: "Lilo e Stitch" },
        { id: "LUCA", titolo: "Luca" },
        { id: "MONSTERS-UNIVERSITY", titolo: "Monsters University" },
        { id: "RATATOUILLE", titolo: "Ratatouille" },
        { id: "TOY-STORY-5", titolo: "Toy Story 5" },
        { id: "WALL-E", titolo: "Wall-E" },
        { id: "ZOOTROPOLIS-2", titolo: "Zootropolis 2" }
    ];
    const contentPage = document.querySelector(".content-page");

    // --- GENERAZIONE DINAMICA DEI CONTENITORI PER LE LOCANDINE ---
    function buildContainerLocandina() {
        for(let i = 0; i < filmData.length; i++) {
            // --- CREAZIONE ELEMENTO CARD ---
            const containerLocandina = document.createElement("div");
            containerLocandina.classList.add("locandina-card");

            // --- CREAZIONE E CONFIGURAZIONE IMMAGINE ---
            const imgLocandina = document.createElement("img");
            imgLocandina.src = `../img/${filmData[i].id}_locandina.jpg`;
            imgLocandina.alt = filmData[i].titolo;
            
            // --- CREAZIONE E CONFIGURAZIONE IMMAGINE ---
            imgLocandina.addEventListener("click", () => {
                pageAboutFilm(filmData[i].id);
            });
            containerLocandina.appendChild(imgLocandina);

            // --- CREAZIONE TITOLO LOCANDINA ---
            const titoloLocandina = document.createElement("h2");
            titoloLocandina.textContent = filmData[i].titolo;
            titoloLocandina.className = "titolo-locandina";
            
            containerLocandina.appendChild(titoloLocandina);
            contentPage.appendChild(containerLocandina);
        }
    }

    // --- FUNZIONE PER IL REINDIRIZZAMENTO ALLA PAGINA DEL DETTAGLIO FILM ---
    function pageAboutFilm(id) {
        window.location.href = `film.php?id_film=${id}`;
    }

    // --- ESECUZIONE DELLA FUNZIONE DI RENDER ---
    buildContainerLocandina();
});