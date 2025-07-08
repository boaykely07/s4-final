<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BNI Madagascar - Statistiques : Intérêts gagnés par mois</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #0f766e 0%, #059669 50%, #10b981 100%); }
        .sidebar-gradient { background: linear-gradient(180deg, #0f766e 0%, #134e4a 100%); }
        .glass-effect { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
        .hover-scale { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-scale:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); }
        .menu-item { transition: all 0.3s ease; }
        .menu-item:hover { background: rgba(255, 255, 255, 0.1); transform: translateX(8px); }
        .dropdown-enter { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .dropdown-enter.open { max-height: 200px; }
        .floating-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .currency-pulse { animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
        .mobile-menu { transform: translateX(-100%); transition: transform 0.3s ease; }
        .mobile-menu.open { transform: translateX(0); }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <!-- Mobile Menu Button -->
    <button id="mobile-menu-btn"
        class="lg:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
        <svg class="w-6 h-6 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-40 bg-white shadow-xl border-b border-gray-200">
        <div class="w-full px-4 sm:px-6 lg:pl-4 lg:pr-8">
            <div class="flex items-center h-20">
                <div class="flex items-center space-x-3 pl-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 via-teal-600 to-emerald-500 rounded-xl shadow-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">BNI</span>
                    </div>
                    <div class="text-2xl font-black text-teal-700 tracking-wide">BNI MADAGASCAR</div>
                </div>
                <div class="flex-grow"></div>
            </div>
        </div>
    </nav>
    <!-- Mobile Navigation Menu -->
    <div id="mobile-menu" class="mobile-menu lg:hidden fixed top-0 left-0 h-full w-80 sidebar-gradient z-30 shadow-2xl">
        <div class="pt-20 pb-6">
            <div class="px-6 mb-8">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 via-teal-600 to-emerald-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xs">BNI</span>
                    </div>
                    <div class="text-white font-bold text-lg">MENU</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sidebar -->
    <div class="fixed top-20 left-0 w-72 h-full sidebar-gradient shadow-2xl z-20 hidden lg:block">
        <div class="p-6 space-y-2">
            <a href="../fonds/insertionFonds.html"
                class="menu-item flex items-center space-x-4 p-4 rounded-xl bg-white bg-opacity-20 text-white group">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition-all duration-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                    </svg>
                </div>
                <div>
                    <div class="font-semibold">FONDS ACTUELS</div>
                    <div class="text-sm text-teal-100 opacity-75">Gérer vos fonds</div>
                </div>
            </a>
            <a href="../prets/listePrets.html"
                class="menu-item flex items-center space-x-4 p-4 rounded-xl text-white hover:bg-white hover:bg-opacity-10 group">
                <div class="w-10 h-10 bg-white bg-opacity-10 rounded-lg flex items-center justify-center group-hover:bg-opacity-20 transition-all duration-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                    </svg>
                </div>
                <div>
                    <div class="font-semibold">PRÊTS</div>
                    <div class="text-sm text-teal-100 opacity-75">Demandes de prêts</div>
                </div>
            </a>
            <a href="../prets/simulateurPret.html"
                class="menu-item flex items-center space-x-4 p-4 rounded-xl text-white hover:bg-white hover:bg-opacity-10 group">
                <div class="w-10 h-10 bg-white bg-opacity-10 rounded-lg flex items-center justify-center group-hover:bg-opacity-20 transition-all duration-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 14.5v-5h2l-3-4-3 4h2v5h2z" />
                    </svg>
                </div>
                <div>
                    <div class="font-semibold">SIMULATEUR</div>
                    <div class="text-sm text-teal-100 opacity-75">Simuler un prêt</div>
                </div>
            </a>
            <a href="interets_gagnes.php"
                class="menu-item flex items-center space-x-4 p-4 rounded-xl text-white hover:bg-white hover:bg-opacity-10 group">
                <div class="w-10 h-10 bg-white bg-opacity-10 rounded-lg flex items-center justify-center group-hover:bg-opacity-20 transition-all duration-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z" />
                    </svg>
                </div>
                <div>
                    <div class="font-semibold">STATISTIQUES</div>
                    <div class="text-sm text-teal-100 opacity-75">Intérêts gagnés</div>
                </div>
            </a>
        </div>
    </div>
    <!-- Main Content -->
    <div class="lg:ml-72 mt-20 min-h-screen">
        <div class="p-6 lg:p-8">
            <div class="floating-card rounded-2xl shadow-2xl mb-8 overflow-hidden max-w-3xl mx-auto">
                <div class="bg-gradient-to-r from-teal-600 to-emerald-600 p-8">
                    <div class="text-white">
                        <h1 class="text-4xl font-bold mb-2">Intérêts gagnés par mois</h1>
                        <p class="text-xl text-teal-100">Statistiques et visualisation des intérêts</p>
                    </div>
                </div>
                <div class="p-8">
                    <div class="mb-6 flex flex-col md:flex-row md:items-center md:space-x-6 space-y-4 md:space-y-0">
                        <label class="block text-gray-700 font-semibold">Début : <input type="month" id="mois_debut" class="ml-2 border border-gray-300 rounded px-3 py-2"></label>
                        <label class="block text-gray-700 font-semibold">Fin : <input type="month" id="mois_fin" class="ml-2 border border-gray-300 rounded px-3 py-2"></label>
                        <button onclick="chargerInteretsMois()" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-lg shadow-lg transition-all duration-300">Filtrer</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table id="table-interets-mois" class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700">
                                    <th onclick="sortTable(0)" class="py-2 px-4 border-b cursor-pointer">Mois/Année</th>
                                    <th onclick="sortTable(1)" class="py-2 px-4 border-b cursor-pointer">Intérêts gagnés</th>
                                    <th onclick="sortTable(2)" class="py-2 px-4 border-b cursor-pointer">Nb prêts</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div id="pagination" class="mt-4"></div>
                    <canvas id="chartInterets" height="80" class="mt-8"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Currency Rates Footer -->
    <div class="fixed bottom-0 left-0 right-0 lg:left-72 bg-gradient-to-r from-teal-700 to-teal-800 text-white shadow-2xl border-t border-teal-600">
        <div class="flex flex-col sm:flex-row items-center justify-between p-4 space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-6">
                <div class="font-bold text-lg">COURS DE DEVISES</div>
                <div class="flex space-x-8">
                    <div class="text-center currency-pulse">
                        <div class="font-bold text-lg">EURO</div>
                        <div class="text-emerald-300 font-semibold">5 044,10 Ar</div>
                    </div>
                    <div class="text-center currency-pulse">
                        <div class="font-bold text-lg">USD</div>
                        <div class="text-emerald-300 font-semibold">4 464,77 Ar</div>
                    </div>
                </div>
                <div class="text-sm text-teal-200">Mis à jour le 2025-04-30</div>
            </div>
            <button class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold shadow-lg hover-scale transition-all duration-300 flex items-center space-x-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                </svg>
                <span>TROUVER UNE AGENCE</span>
            </button>
        </div>
    </div>
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