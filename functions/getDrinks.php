<?php
include_once('connection.php');

$sql_request = 
"SELECT * 
FROM  Drinks";
/*"SELECT Produit.nom_Produit AS Produit,
        Produit.id_Produit,
		Format.nom_Format AS Format, 
		Format.id_Format, 
		Prix_par_Format.prix AS Prix, 
		Category.nom_Category AS Categorie,
		Category.id_Category
FROM Produit, Format, Prix_par_Format, Category
WHERE Prix_par_Format.id_Produit = Produit.id_Produit
AND Produit.id_Categorie = Category.id_Category
AND Prix_par_Format.id_Format = Format.id_Format
ORDER By (Category.nom_Category) ASC,(Produit.nom_Produit) ASC"*/

$stmt = $conn->prepare($sql_request);
$stmt->execute();
$db_Drinks = $stmt->fetchAll();

$AllDrinks = array();
$Drinks_line = array();

foreach ($db_Drinks as $db_Drink) {
$Drink = new stdClass();
$Drink->categorie = $db_Drink['Categorie'];
$Drink->id_categorie = $db_Drink['id_Category'];
$Drink->produit = $db_Drink['Produit'];
$Drink->id_produit = $db_Drink['id_Produit'];
$Drink->format = $db_Drink['Format'];
$Drink->id_format = $db_Drink['id_Format'];
$Drink->prix = $db_Drink['Prix'];
$AllDrinks[] = $Drink;
}

return $AllDrinks;
// foreach ($AllDrinks as $Drink)
// {
// echo "<br/>-".$Drink->format." de ".$Drink->produit." (".$Drink->categorie.") Price : ".$Drink->prix;
// }
?>