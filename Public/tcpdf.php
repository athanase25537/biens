<?php

require_once('../TCPDF/tcpdf.php');

$pdf = new \TCPDF();

// Configurer les informations du document
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Eliot Faggianelli');
$pdf->SetTitle("Quittance de Loyer du $dateEmission");

// Supprime les en-têtes et pieds de page par défaut
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Ajouter une page
$pdf->AddPage();

// Définir le contenu
$html = <<<EOD
<h1 style="text-align: center;">Quittance de Loyer du $dateEmission</h1>
<p><strong>Propriétaire :</strong> Eliot Faggianelli</p>
<p><strong>Adresse :</strong> 33 rue du 8 Mai 1945, Meyzieu 69330</p>

<h2>Informations du Locataire</h2>
<p><strong>Locataire :</strong> David Lor</p>
<p><strong>Adresse du locataire :</strong> 6 rue Gutenberg, Décines-Charpieu 69150</p>
<p><strong>Adresse de location :</strong> 6 rue Gutenberg, Décines-Charpieu 69150</p>

<h2>Détails du Paiement</h2>
<table border="1" cellpadding="5">
    <tr>
        <td><strong>Date de paiement</strong></td>
        <td>$datePaiement</td>
    </tr>
    <tr>
        <td><strong>Montant du loyer mensuel</strong></td>
        <td>$montant €</td>
    </tr>
    <tr>
        <td><strong>Montant des charges mensuelles</strong></td>
        <td>$montantCharge €</td>
    </tr>
    <tr>
        <td><strong>Montant payé (loyer)</strong></td>
        <td>$montantLoyerPayer €</td>
    </tr>
    <tr>
        <td><strong>Montant payé (charges)</strong></td>
        <td>$montantChargePayer €</td>
    </tr>
    <tr>
        <td><strong>Impayé mois précédent</strong></td>
        <td>$montantImpayer €</td>
    </tr>
    <tr>
        <td><strong>Reste à payer</strong></td>
        <td>$resteAPayer €</td>
    </tr>
</table>

<p>
La présente quittance certifie que le locataire a payé les sommes mentionnées ci-dessus pour le mois du $dateEmission.
Cette quittance ne couvre pas les impayés, qui restent dus.
</p>

<p style="text-align: right;">
Fait à 33 rue du 8 Mai 1945, Meyzieu 69330, le $createdAt<br>
<strong>Eliot Faggianelli</strong>
</p>
EOD;

// Ajouter le contenu au PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Générer et afficher le fichier PDF
$pdf->Output("quittance_loyer_$filename.pdf", 'D');
