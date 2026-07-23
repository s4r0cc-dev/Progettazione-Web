// --- MOSTRA MESSAGGIO (OVERLAY MSG) ---
function showMsg(msg, divMsg, isError = false, duration = 3000) {
    if(!divMsg) return;

    divMsg.innerHTML = ""; 
    divMsg.style.display = "block";
    divMsg.style.color = isError ? "red" : "green";
        
    const msgText = document.createElement("p");
    msgText.textContent = msg;
    divMsg.appendChild(msgText);

    // --- SCOMPARE DOPO 3 SECONDI ---
    setTimeout(() => {
        divMsg.innerHTML = "";
        divMsg.style.display = "none";
    }, duration);
}