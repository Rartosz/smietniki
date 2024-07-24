document.addEventListener('DOMContentLoaded', () => {
    const addTrashcanForm = document.getElementById('addTrashcanForm');
    const trashcanList = document.getElementById('trashcanList');
    
    // Load trashcans on page load
    loadTrashcans();

    addTrashcanForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const location = document.getElementById('location').value;
        const qrId = document.getElementById('qrId').value;
        
        fetch('add_trashcan.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `location=${location}&qr_id=${qrId}`
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            loadTrashcans();
        })
        .catch(error => console.error('Error:', error));

        addTrashcanForm.reset();
    });

    function loadTrashcans() {
        fetch('get_trashcans.php')
            .then(response => response.json())
            .then(data => {
                trashcanList.innerHTML = '';
                data.forEach(trashcan => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        <span class="location">${trashcan.location}</span>
                        <span class="qrCode">QR: ${trashcan.qr_id}</span>
                        <img src="qrcodes/${trashcan.qr_id}.png" alt="QR Code">
                        <button onclick="reportFull(${trashcan.id})">Zgłoś przepełnienie</button>
                        ${trashcan.status === 'Przepełniony' ? 
                            `<button onclick="resolveFull(${trashcan.id})">Zgłoś, że śmietnik został wysprzątany</button>` 
                            : ''
                        }
                    `;
                    trashcanList.appendChild(li);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    window.reportFull = function(id) {
        fetch('report_full.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}&report_full=true`
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            loadTrashcans();
        })
        .catch(error => console.error('Error:', error));
    }

    window.resolveFull = function(id) {
        fetch('report_full.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}&resolve_full=true`
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            loadTrashcans();
        })
        .catch(error => console.error('Error:', error));
    }
});
