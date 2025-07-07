<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Taux</h1>
    
    Rapport Final
    <table id="table-tauxInteret">
        <thead>
        <tr>
            <th>ID</th>
            <th>id_types_pret</th>
            <th>pourcentage</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Filtres pour la période -->
    <!-- (Suppression du filtre et du tableau des intérêts par mois) -->

    <h2>Intérêts par prêt</h2>
    <table id="table-interetsPrets">
      <thead>
        <tr>
          <th>ID Prêt</th>
          <th>Client</th>
          <th>Type</th>
          <th>Montant (€)</th>
          <th>Taux (%)</th>
          <th>Durée (mois)</th>
          <th>Intérêt total (€)</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>

    <script>

    const apiBase = "http://localhost/s4-final/ws";

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

    function chargerTaux() {
      ajax("GET", "/tauxInteret", null, (data) => {
        const tbody = document.querySelector("#table-tauxInteret tbody");
        tbody.innerHTML = "";
        data.forEach(e => {
          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td>${e.id_taux}</td>
            <td>${e.id_types_pret}</td>
            <td>${e.pourcentage}</td>
          `;
          tbody.appendChild(tr);
        });
      });
    }


    function chargerInteretsPrets() {
      ajax("GET", "/interetsPrets", null, (data) => {
        const tbody = document.querySelector("#table-interetsPrets tbody");
        tbody.innerHTML = "";
        data.forEach(e => {
          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td>${e.id_prets}</td>
            <td>${e.nom_clients} ${e.prenom_clients}</td>
            <td>${e.nom_type_pret}</td>
            <td>${e.montant_prets}</td>
            <td>${e.pourcentage}</td>
            <td>${e.duree_en_mois}</td>
            <td>${parseFloat(e.interet_total).toFixed(2)}</td>
          `;
          tbody.appendChild(tr);
        });
      });
    }
    chargerTaux();
    chargerInteretsPrets();


    </script>
</body>
</html>