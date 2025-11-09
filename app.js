// Fonction pour rafraîchir les données
window.refreshData = function(){

  // 1️⃣ Récupérer les services
  fetch('api.php?a=list_services')
    .then(res => res.json())
    .then(services => {
      const svcDiv = document.getElementById('svc');
      if(!svcDiv) return;

      svcDiv.innerHTML = '';
      services.forEach(s => {
        const slots = s.slots.map(sl => `<li>${sl}</li>`).join('');
        svcDiv.innerHTML += `
          <div class="service-card">
            <b>${s.name}</b> (${s.type})<br>
            Slots: <ul>${slots}</ul>
          </div>
        `;
      });
    });

  // 2️⃣ Récupérer les bookings de l'utilisateur
  fetch('api.php?a=list_bookings')
    .then(res => res.json())
    .then(bookings => {
      const bkDiv = document.getElementById('bk');
      if(!bkDiv) return;

      if(bookings.length === 0){
        bkDiv.innerHTML = '<i>Aucune réservation</i>';
        return;
      }

      bkDiv.innerHTML = '';
      bookings.forEach(b => {
        bkDiv.innerHTML += `
          <div class="booking-card">
            Booking ID: ${b.id} | Service ID: ${b.service} | Slot: ${b.slot}
          </div>
        `;
      });
    });
};
