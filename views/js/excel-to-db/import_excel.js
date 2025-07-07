// Importer les modules
const ExcelJS = require('exceljs');
const mysql = require('mysql2/promise');

// Configuration de la connexion MySQL
const db = mysql.createPool({
  host: 'localhost',
  user: 'root',     // Remplace par ton utilisateur MySQL
  password: '',     // Remplace par ton mot de passe MySQL
  database: 'test_db',
});

// Fonction pour importer les données Excel
const importerExcel = async () => {
  try {
    // Charger le fichier Excel
    const workbook = new ExcelJS.Workbook();
    await workbook.xlsx.readFile('../test.xlsx');
    const worksheet = workbook.getWorksheet('Feuille1');

    // Parcourir les lignes du fichier Excel
    for (let i = 2; i <= worksheet.rowCount; i++) {
      const row = worksheet.getRow(i);
      const nom = row.getCell(2).value;
      const email = row.getCell(3).value;

      // Insérer dans la base de données
      await db.query('INSERT INTO users (nom, email) VALUES (?, ?)', [nom, email]);
      console.log(`Données insérées : ${nom}, ${email}`);
    }

    console.log('Importation terminée avec succès !');
  } catch (err) {
    console.error('Erreur lors de l\'importation :', err);
  } finally {
    process.exit(); // Fermer la connexion
  }
};

// Exécuter l'importation
importerExcel();
