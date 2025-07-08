<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques : Intérêts gagnés par mois</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; cursor: pointer; }
        #pagination { margin: 15px 0; text-align: center; }
        #pagination button { margin: 0 2px; padding: 4px 10px; }
        .active-page { font-weight: bold; background: #007bff; color: #fff; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>Intérêts gagnés par mois</h1>
    <div style="margin-bottom: 20px;">
        <label>Début : <input type="month" id="mois_debut"></label>
        <label>Fin : <input type="month" id="mois_fin"></label>
        <button onclick="chargerInteretsMois()">Filtrer</button>
    </div>
    <table id="table-interets-mois">
        <thead>
            <tr>
                <th onclick="sortTable(0)">Mois/Année</th>
                <th onclick="sortTable(1)">Intérêts gagnés</th>
                <th onclick="sortTable(2)">Nb prêts</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div id="pagination"></div>
    <canvas id="chartInterets" height="80" style="margin-top:30px;"></canvas>
    <script>
    const apiBase = "http://localhost/s4-final/ws";
    let interetsData = [];
    let currentPage = 1;
    const rowsPerPage = 10;
    let currentSort = {col: 0, asc: true};
    let chart;

    function ajax(method, url, data, callback) {
        const xhr = new XMLHttpRequest();
        xhr.open(method, apiBase + url, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                callback(JSON.parse(xhr.responseText));
            }
        };
        xhr.send(data);
    }

    function chargerInteretsMois() {
        const debut = document.getElementById("mois_debut").value;
        const fin = document.getElementById("mois_fin").value;
        if (!debut || !fin) return alert("Sélectionnez une période.");
        const [annee_debut, mois_debut] = debut.split("-");
        const [annee_fin, mois_fin] = fin.split("-");
        ajax("GET", `/interetsMois?mois_debut=${mois_debut}&annee_debut=${annee_debut}&mois_fin=${mois_fin}&annee_fin=${annee_fin}`, null, (data) => {
            interetsData = data;
            currentPage = 1;
            renderTable();
            renderChart();
        });
    }

    function renderTable() {
        let data = [...interetsData];
        // Tri
        data.sort((a, b) => {
            let vA = Object.values(a)[currentSort.col];
            let vB = Object.values(b)[currentSort.col];
            if (currentSort.col === 1 || currentSort.col === 2) { vA = parseFloat(vA); vB = parseFloat(vB); }
            return currentSort.asc ? (vA > vB ? 1 : -1) : (vA < vB ? 1 : -1);
        });
        // Pagination
        const start = (currentPage - 1) * rowsPerPage;
        const pageData = data.slice(start, start + rowsPerPage);
        const tbody = document.querySelector("#table-interets-mois tbody");
        tbody.innerHTML = "";
        pageData.forEach(e => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${e.mois_annee}</td>
                <td>${parseFloat(e.total_interets).toFixed(2)}</td>
                <td>${e.nb_prets}</td>
            `;
            tbody.appendChild(tr);
        });
        renderPagination(data.length);
    }

    function renderPagination(totalRows) {
        const nbPages = Math.ceil(totalRows / rowsPerPage);
        let html = '';
        for (let i = 1; i <= nbPages; i++) {
            html += `<button onclick="gotoPage(${i})" class="${i === currentPage ? 'active-page' : ''}">${i}</button> `;
        }
        document.getElementById("pagination").innerHTML = html;
    }
    function gotoPage(page) { currentPage = page; renderTable(); }

    function sortTable(col) {
        if (currentSort.col === col) currentSort.asc = !currentSort.asc;
        else { currentSort.col = col; currentSort.asc = true; }
        renderTable();
    }

    function renderChart() {
        const ctx = document.getElementById('chartInterets').getContext('2d');
        const labels = interetsData.map(e => e.mois_annee);
        const data = interetsData.map(e => parseFloat(e.total_interets));
        if (chart) chart.destroy();
        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Intérêts gagnés',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    }
    </script>
</body>
</html>