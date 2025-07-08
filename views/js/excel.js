// Importer ExcelJS
const ExcelJS = require('exceljs');
const fs = require('fs');

// Créer un nouveau classeur Excel
const workbook = new ExcelJS.Workbook();
const worksheet = workbook.addWorksheet('Feuille1');

// Ajouter des en-têtes
worksheet.columns = [
  { header: 'ID', key: 'id', width: 10 },
  { header: 'Nom', key: 'nom', width: 20 },
  { header: 'Email', key: 'email', width: 30 },
];

// Ajouter des données
const donnees = [
  { id: 1, nom: 'Rakoto', email: 'rakoto@example.com' },
  { id: 2, nom: 'Rabe', email: 'rabe@example.com' },
  { id: 3, nom: 'Rasoa', email: 'rasoa@example.com' },
];

donnees.forEach((data) => {
  worksheet.addRow(data);
});

// Enregistrer le fichier Excel
workbook.xlsx.writeFile('test.xlsx')
  .then(() => {
    console.log('Fichier Excel créé : test.xlsx');
  })
  .catch((err) => {
    console.error('Erreur lors de la création du fichier Excel :', err);
  });
