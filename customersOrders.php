<?php
include_once("functions/getOrders.php");
include_once("functions/updateOrderQuantity.php");
include_once("functions/deleteOrder.php");
include_once("functions/updatePanier.php");
include_once("functions/deletePanier.php");
$CustomerOrders = getOrders($conn);
$bill = 0;?>
<!DOCTYPE html>
  <html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	  <meta name="viewport" content="width=device-width, initial-scale=1"/>
	  <title>Drink Order App</title>

	  <!-- CSS  -->
	  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	<!--  <meta http-equiv="refresh" content="10"></meta>-->
    </head>

    <body>
    	<nav class="red" role="navigation">
		    <div class="nav-wrapper container">
		      <ul id="nav-mobile" class="sidenav">
		        <li class="red white-text"><a href="index.html" class="white-text">Ma Dj&eacute; Aha</a></li>
		        <li><a href="cart.html"> <i class="material-icons md-light">shopping_cart</i> Panier de Commandes</a></li>
		        <li><a href="order.html"> <i class="material-icons md-light">add</i> Ajouter une commande</a></li>
		      </ul>
		      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons md-light">menu</i></a>
		    </div>
		</nav>

		<div id="index-banner" class="parallax-container">
		    <div class="section no-pad-bot">
		      <div class="container ">

			    <?php foreach ($CustomerOrders as $Customer) { ?>		
				<ul class = "collapsible">
				<li>
		        <div class="row center collapsible-header">
		        	<h5 class="md-title"><?php echo "Commande N°".$Customer->panier_id.", Client ".$Customer->name." Table ".$Customer->table."(".$Customer->time.")";?> </h5>
				</div>
		        <div class="row center collapsible-body">
					<h6>
					<form method="post" action="refresh.php">
					   <input type="hidden" name="panier_id" value="<?php echo $Customer->panier_id;?>"/>
					   <button type="submit" name="updatePanier" class="waves-effect btn-flat "><i class="material-icons orange600">done</i></button>
					   <button data-target="modalDeletePanier" data-id="<?php echo $Customer->panier_id;?>"class="waves-effect btn btn-flat modal-trigger panier-id "><i class="material-icons orange600">cancel</i></button>
					   <!--<a href="order.html" title="Servie"> Servie<i class="material-icons small orange600 hoverable" style="margin-right:10px;">done</i></a>
					   <a href="order.html" title="Annulée">Annul&eacute;e<i class="material-icons small orange600 hoverable" style="margin-right:10px;">cancel</i></a>-->
					</form>
					</h6>
				    <table>
				        <thead>
				          <tr>
				              <th>Breuvage</th>
				              <th>Quantité</th>
				              <th>Prix</th>
				          </tr>
				        </thead>
						<tbody>
                        <?php
						$bill = 0;
						foreach ($Customer->order as $order) { ?>
				        
				          <tr>
				            <td><?php echo "$order->format de $order->drink";?></td>
				            <td><?php echo $order->quantity;?></td>
				            <td>$<?php echo $order->price;?></td>
				            <td>
							   <a href="#modal1" title="Modifier" data-id="<?php echo $order->id_commande;?>" class="waves-effect waves-light modal-trigger order-id" ><i class="material-icons small orange600 hoverable">edit</i></a>
							   <a href="#modal2" title="Supprimer" data-id="<?php echo $order->id_commande;?>" class="waves-effect waves-light modal-trigger order-id" ><i class="material-icons small red600 hoverable">delete_forever</i></a>
							</td>
						  </tr>
						  <?php 
						  $bill += $order->price; } ?>
						  <tr style="height: 60px; border-bottom: none">
				          	<td></td>
				          	<td></td>
				            <th>Total</th>
				            <th>$<?php echo $bill;?></th>
				            
				          </tr>
				        </tbody>
				      </table>
		        </div>
				</li>
				</ul>
                <?php } ?>
		      </div>
		    </div>
		    <!-- <div class="parallax"><img src="openBar1.jpg" alt="Unsplashed background img 1"></div> -->
		</div>
<!-- Modal Trigger -->
  <!-- Modal Trigger -->
 <!-- Modal Trigger -->

		        <!-- Modal Structure -->
				  <div id="modal1" class="modal">
				    <div class="modal-content">
				      
					<div class="row center">
				          <h6 class="header col s12 red-text">Mettre a jour la Commande</h6>
				        </div>
				      <div class="row">
					    <form class="col s12" method="post" action="refresh.php">

					      <div class="row center">
						  <input type="hidden" id="order_id" name="order_id" value=""/>
					          <div class="input-field col s12 white">
							    <select name="quantity">
							      <option class="white-text" value="" disabled selected>Quantit&eacute;</option>
							      <option value="1">1</option>
							      <option value="2">2</option>
							      <option value="3">3</option>
							    </select>
							  </div>
					        </div>
					      <div class="row">
						    <button class="waves-effect btn red left">Annuler</button> 
							<button type="submit" name="updateOrder" class="waves-effect btn red right">Enregistrer</button>
					      </div>
					    </form>
					  </div>
				    </div>
				    
				  </div>

				  <!-- Modal Structure -->
				  <div id="modal2" class="modal modal-fixed-footer">
				  <form method="post" action="refresh.php">
					<div class="modal-content">
					  <h4>Supprimer la commande ?</h4>
					  <input type="hidden" id="order_id" name="order_id" value=""/>
					</div>
					<div class="modal-footer">
					  <button type="submit" name="deleteOrder" class="waves-effect btn ">Oui</button>
					  <button class="modal-action modal-close waves-effect btn">Non</button>
					</div>
				  </form>
				  </div>
				  
				  <!-- Modal Structure -->
				  <div id="modalDeletePanier" class="modal modal-fixed-footer">
				  <form method="post" action="refresh.php">
					<div class="modal-content">
					  <h4>Supprimer le panier ?</h4>
					  <input type="text" id="panier_id" name="panier_id" value=""/>
					</div>
					<div class="modal-footer">
					  <button type="submit" name="deletePanier" class="waves-effect btn red"><i class="material-icons ">done</i></button>
					  <button class="modal-action modal-close waves-effect btn red "><i class="material-icons ">cancel</i></button>
					</div>
				  </form>
				  </div>				  
				    
				  </div>
				  
		      </div>
		    </div>
		    <!-- <div class="parallax"><img src="openBar1.jpg" alt="Unsplashed background img 1"></div> -->
		</div>
		

		  <footer class="page-footer brown">
		    
		    <div class="footer-copyright">
		      <div class="container center">
		      ©  
		      <script type="text/javascript">document.write(new Date().getFullYear());</script> CTC, All rights reserved.
		      </div>
		    </div>
		  </footer>
      <!--  Scripts-->
	  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	  <script src="js/materialize.js"></script>
	  <script src="js/init.js"></script>
	  <script>
        $(document).ready(function(){
            $('.collapsible').collapsible();
        });
		$(document).on("click", ".order-id", function () {
     var order = $(this).data('id');
     $(".modal-content #order_id").val( order );	 
     // As pointed out in comments, 
     // it is superfluous to have to manually call the modal.
     // $('#addBookDialog').modal('show');
        });
        $(document).on("click", ".panier-id", function () {
     var panier = $(this).data('id');
     $(".modal-content #panier_id").val( panier );
	    });
	  </script>
    </body>	
  </html>