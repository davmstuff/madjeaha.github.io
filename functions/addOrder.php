<?php
include_once('connection.php');
/*
$CustomerOrder class :
- name 
- table_id
-orders = array of order.
Order class :
- id_drink
- Quantity
- id_format
*/
function placeOrder($CustomerOrder, $conn)
{
$timestamp = time();
$formattedDateTime = date("Y-m-j H:i:s",$timestamp);
$request = "INSERT INTO
            Panier VALUES ('', $CustomerOrder->table_id, '$CustomerOrder->name', '$formattedDateTime', 0);";			
$stmt = $conn->prepare($request);
$result = $stmt->execute();

$request = "SELECT id_Panier
            FROM Panier
 			WHERE Heure_Creation = '$formattedDateTime' AND
            Nom_Client = '$CustomerOrder->name' ;";
$stmt = $conn->prepare($request);
$stmt->execute();
$db_idPaniers = $stmt->fetchAll();
$LatestRegisteredOrderFromClient = 0;
foreach ($db_idPaniers as $db_idPanier)
   {
   $LatestRegisteredOrderFromClient = $db_idPanier['id_Panier'];
   }
foreach ($CustomerOrder->orders as $order)
   {
   $request = "INSERT INTO Commande VALUES ('', $order->id_drink, $order->quantity, $order->id_format, $LatestRegisteredOrderFromClient);";
   echo $request."<br/>";
   $stmt = $conn->prepare($request);
   $stmt->execute();
   }
}
$CustomerOrder = new stdClass();
$CustomerOrder->name = "Sorel";
$CustomerOrder->table_id = 2;
$ClientOrder = new stdClass();
$ClientOrder->id_drink = 1;
$ClientOrder->quantity = 3;
$ClientOrder->id_format = 1;

$CustomerOrder->orders[] = $ClientOrder;

placeOrder($CustomerOrder,$conn);
/*

[Panier]

$Last_Panier_id = $conn->insert_id;	  

[Commande]
INSERT INTO `u932683326_aha`.`Commande` (`id_Commande`, `id_Produit`, `quantite_Produit`, `id_Format`) VALUES (NULL, "$Product_id", "$Quantity", "$Format");
$CommandesId = array();
//stack up commande_ids	 
$CommandesId[] = $conn->insert_id;	  

[Contenu_commande]
//boucle for
foreach ($CommandesId as $commandeId)
INSERT INTO `u932683326_aha`.`Contenu_Panier` (`id_Panier`, `id_Commande`) VALUES ($Last_Panier_id, $commandeId);

$request = "INSERT INTO activities_rating VALUES ('',$id_activity,1,$review_score,'$review_text',now())";
//echo $request;
$stmt = $conn->prepare($request);
$result = $stmt->execute();
if($result)
{
	$json['result']=1;
}
else
{
	$json['result']=-1;
}
*/
?>