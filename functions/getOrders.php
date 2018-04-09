<?php
include_once('connection.php');

function getOrders($conn)
{
$sql_request = 
"SELECT * FROM Orders";
/*
Select Panier.id_Panier as Panier_id,
        Panier.Nom_Client as Client,
	    Panier.statut as Statut,
		Panier.Heure_creation as Date,
	    Tables.nom_Table as Nom_Table,
        Produit.nom_Produit as Boisson,
        Commande.quantite_Produit as Quantite,
        Format.nom_Format as Format,
        Prix_par_Format.prix*Commande.quantite_Produit as Prix
From  Panier,Produit,Format,Commande,Tables ,Prix_par_Format
Where Panier.id_Panier = Commande.id_Panier AND
      Panier.id_table = Tables.id_Table AND
      Produit.id_Produit = Commande.id_Produit AND
      Format.id_Format = Commande.id_Format AND
      Prix_par_Format.id_Produit = Produit.id_Produit AND
	  Panier.statut = 0 
	  ORDER BY (Panier.Heure_creation) ASC*/
$stmt = $conn->prepare($sql_request);
$stmt->execute();
$orders = $stmt->fetchAll();


$All_Clients = array();
$Orders_Arr = array();
$Clients_Info_Arr = array();
foreach ($orders as $order) 
   {
   $clientObject = new stdClass();
   $clientOrderObject = new stdClass();
   $clientObject->name = $order['Client'];
   $clientObject->panier_id = $order['Panier_id'];
   $clientObject->statut = $order['Statut'];
   $clientObject->table = $order['Nom_Table'];
   $date = explode(" ",$order['Date']);
   $clientObject->date = $date[0];
   $clientObject->time = $date[1];
   $clientOrderObject->drink = $order['Boisson'];
   $clientOrderObject->quantity = $order['Quantite'];
   $clientOrderObject->price = $order['Prix'];
   $clientOrderObject->format = $order['Format'];
   $clientOrderObject->id_commande = $order['Commande_id'];
   $clientObject->order[] = $clientOrderObject;
   
   $Orders_Arr[$order['Panier_id']][] = $clientOrderObject;
   $Clients_Info_Arr[$order['Panier_id']] = $clientObject;
   }

$Panier_id_arr = array_keys($Orders_Arr);

foreach($Panier_id_arr as $panier_id)
   {
   $client = $Clients_Info_Arr[$panier_id];
   $client->order = $Orders_Arr[$panier_id];
   $Clients_Info_Arr[$panier_id] = $client;
   }
return $Clients_Info_Arr;
}

 // foreach ($Clients_Info_Arr as $Customer)
 // {
 // echo "<br/>-".$Customer->panier_id." ".$Customer->name." Table : ".$Customer->table." Date : ".$Customer->time;
 // foreach ($Customer->order as $order)
  // {
  // echo "<br/>---".$order->drink;
  // echo "<br/>---".$order->quantity;
  // echo "<br/>---".$order->price;
  // echo "<br/>---".$order->format;
  // }
  // echo "<br/>------------------";
 // }
?>