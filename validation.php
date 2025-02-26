<?php
session_start();


if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
    $_SESSION['panier']['nom'] = array();
    $_SESSION['panier']['prix'] = array();
}


if (isset($_GET['modele']) && isset($_GET['prix'])) {
    array_push($_SESSION['panier']['nom'], $_GET['modele']);
    array_push($_SESSION['panier']['prix'], floatval($_GET['prix']));
}


if (isset($_POST['supprimer'])) {
    $index = intval($_POST['supprimer']);
    if (isset($_SESSION['panier']['nom'][$index])) {
        $_SESSION['panier']['nom'][$index] = null;
        $_SESSION['panier']['prix'][$index] = null;
    }
}

$_SESSION['panier']['nom'] = array_values(array_filter($_SESSION['panier']['nom'], fn($item) => $item !== null));
$_SESSION['panier']['prix'] = array_values(array_filter($_SESSION['panier']['prix'], fn($item) => $item !== null));
?>

<html>
<head>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; CHARSET=utf-8" />
</head>
<body>
<center><H1>VOTRE PANIER</H1></center>

<?php if (!empty($_SESSION['panier']['nom'])): ?>
    <table border="1" align="center">
        <tr>
            <th>NUMERO</th>
            <th>DESIGNATION</th>
            <th>PRIX</th>
        </tr>
        <?php
        $total = 0;
        foreach ($_SESSION['panier']['nom'] as $index => $nom) {
            $prix = $_SESSION['panier']['prix'][$index];
            $total += $prix;
            echo "<tr>
                    <td>$index</td>
                    <td>$nom</td>
                    <td>$prix €</td>
                  </tr>";
        }
        ?>
    </table>
    <p align="center"><strong>TOTAL : <?= $total ?> €</strong></p>
<?php else: ?>
    <p align="center">Votre panier est vide.</p>
<?php endif; ?>

<form method="POST" action="" align="center">
    <label for="supprimer">Numéro de l'article à retirer :</label>
    <input type="number" name="supprimer" id="supprimer" min="0" required>
    <button type="submit">Valider</button>
</form>

<p align="center"><a href="sommaire.php">SOMMAIRE</a></p>
</body>
</html>
