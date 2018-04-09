	<?php
	include_once("functions/getOrders.php");
    include_once("functions/updateOrderQuantity.php");
    include_once("functions/deleteOrder.php");
    include_once("functions/updatePanier.php");
    include_once("functions/deletePanier.php");
	?>
	<?php
	 if (isset($_POST['deleteOrder']))
	    {
	    if (isset($_POST['order_id']))
		   {
		   $order_id = $_POST['order_id'];
		   echo "The deleted Command id is $order_id";
		   unset($_POST['delete']);
		   }
	    }
	?>
	<?php
	 if (isset($_POST['updateOrder']))
	    {
	    if (isset($_POST['order_id']))
		   {
		   $order_id = $_POST['order_id'];
		   $order_quantity = $_POST['quantity'];
		   echo "The update Command id is $order_id and the new quantity is $order_quantity";
		   unset($_POST['update']);
		   }
	    }
	?>
		<?php
	 if (isset($_POST['updatePanier']))
	    {
	    if (isset($_POST['panier_id']))
		   {
		   $panier_id = $_POST['panier_id'];
		   echo "The update Panier id is $panier_id";
		   updatePanier($panier_id, $conn);
		   unset($_POST['updatePanier']);
		   }
	    }
	?>
	<?php
	 if (isset($_POST['deletePanier']))
	    {
	    if (isset($_POST['panier_id']))
		   {
		   $panier_id = $_POST['panier_id'];
		   echo "The deleted Panier id is $panier_id";
		   unset($_POST['deletePanier']);
		   }
	    }
	?>
	<?php
	header('Location: http://localhost/MaDjeAha/MaDjeAha/madjeaha.github.io/customersOrders.php',true);
	?>