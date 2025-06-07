import './bootstrap';
import Swal from 'sweetalert2';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();



Echo.channel('resign-channel')
    .listen('.resign.updated', (e) => {
        console.log("Data resign berubah:", e.data);
        // Update tampilan HTML (gunakan Vue/React/Blade sesuai kebutuhan)
        document.getElementById('resign-info').innerText = JSON.stringify(e.data);
    });

