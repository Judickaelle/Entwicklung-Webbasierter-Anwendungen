<html>
<head>
	<meta charset="UTF-8" />
	<title>EwA_WS2021-2022</title>
	<style>
		table {
		font-family: arial, sans-serif;
		border-collapse: collapse;
		width: 100%;
		}

		td, th {
		border: 1px solid #dddddd;
		text-align: left;
		padding: 8px;
		}
	</style>
</head>
<body>
	<div>
		Sie haben gewählt :
		<ul>
			<li><?php echo $_POST["ebuchquantity"]." ".$_POST["ebuch"]; ?></li>
			<li><?php echo $_POST["zbuchquantity"]." ".$_POST["zbuch"]; ?></li>
			<li><?php echo $_POST["dbuchquantity"]." ".$_POST["dbuch"]; ?></li>
		</ul>
		
		<?php 
			if ($_POST["ebuchquantity"]<0 or $_POST["zbuchquantity"]<0 or $_POST["dbuchquantity"]<0){
				echo "<p style='color:red;'> Achtung ! Es Gibt einen negativen Eingabewerten ! Der Preis des betroffenen Buches wird nicht berechnet.</p>";
			};	
			
			$phrase = "";
			
			$total = 0.0;
			$totalprice = 0.0;
			$totalWeight = 0.0;

			$selfPHPprice = 25.40;
			$selfPHPWeight = 800;
			$selfPHPQuantity = 0.0;

			$phpReferencePrice = 18;
			$phpReferenceWeight = 600;
			$phpReferenceQuantity = 0.0;

			$phpKochbuchPrice = 39;
			$phpKochbuchWeight = 1300;
			$phpKochbuchQuantity = 0.0;

			if($_POST["ebuchquantity"]>0){
				switch($_POST["ebuch"]){
					case "Self-PHP":
						$selfPHPQuantity =+ $_POST["ebuchquantity"];
						break;
					case "PHP-Referenz":
						$phpReferenceQuantity += $_POST["ebuchquantity"];
						break;
					case "PHP-Kochbuch":
						$phpKochbuchQuantity += $_POST["ebuchquantity"];
						break;
				}
			};

			if($_POST["zbuchquantity"]>0){
				switch($_POST["zbuch"]){
					case "Self-PHP":
						$selfPHPQuantity += $_POST["zbuchquantity"];
						break;
					case "PHP-Referenz":
						$phpReferenceQuantity += $_POST["zbuchquantity"]; 
						break;
					case "PHP-Kochbuch":
						$phpKochbuchQuantity += $_POST["zbuchquantity"]; 
						break;
				}
			}


			if($_POST["dbuchquantity"]>0){
				switch($_POST["dbuch"]){
					case "Self-PHP":
						$selfPHPQuantity += $_POST["dbuchquantity"]; 
						break;
					case "PHP-Referenz":
						$phpReferenceQuantity += $_POST["dbuchquantity"]; 
						break;
					case "PHP-Kochbuch":
						$phpKochbuchQuantity += $_POST["dbuchquantity"]; 
						break;
				}
			}

			$total = $selfPHPQuantity * $selfPHPprice + $phpReferenceQuantity * $phpReferencePrice + $phpKochbuchQuantity* $phpKochbuchPrice;
			$totalprice = $total + $total*0.07;

			$totalWeight = $selfPHPQuantity * $selfPHPWeight + $phpReferenceQuantity * $phpReferenceWeight + $phpKochbuchQuantity * $phpKochbuchWeight;
			
			
			echo "<span style='font-weight:bold'>Rechnung : </span><br><br>
				<table>
					<tr>
						<th>Article</th>
						<th>Unity price</th>
						<th>Unity weight</th>
						<th>Quantity</th>
						<th>Total price (€)</th>
						<th>Total weight (g)</th>
					</tr>
					<tr>
						<td>Self-PHP</td>
						<td>".$selfPHPprice."</td>
						<td>".$selfPHPWeight."</td>
						<td>".$selfPHPQuantity."</td>
						<td>".$selfPHPQuantity * $selfPHPprice."</td>
						<td>".$selfPHPQuantity * $selfPHPWeight."</td>
					</tr>
					<tr>
						<td>PHP-Reference</td>
						<td>".$phpReferencePrice."</td>
						<td>".$phpReferenceWeight."</td>
						<td>".$phpReferenceQuantity."</td>
						<td>".$phpReferenceQuantity * $phpReferencePrice."</td>
						<td>".$phpReferenceQuantity * $phpReferenceWeight."</td>
					</tr>
					<tr>
						<td>PHP-Kochbuch</td>
						<td>".$phpKochbuchPrice."</td>
						<td>".$phpKochbuchWeight."</td>
						<td>".$phpKochbuchQuantity."</td>
						<td>".$phpKochbuchQuantity* $phpKochbuchPrice."</td>
						<td>".$phpKochbuchQuantity * $phpKochbuchWeight."</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>TOTAL</td>
						<td>".$totalprice."*</td>
						<td>".$totalWeight."</td>
					</tr>
				</table>

				<br>*the total price has been calculated with a VAT of 7%";


				switch($_POST["userArrived"]){
					case "Stammkunde":
						$phrase .= "Schön, dass Sie unser Stammkunde sind!";
						break;
					case "Suchmachine":
						$phrase .= "Wir freuen uns, dass Sie uns über eine Suchmaschine finden.";
						break;
					case "Bekannter":
						$phrase .= "Was für eine Freude, einen Bekannten zu begrüßen.";
						break;
					case "Andere":
						$phrase .= "Herzliches Willkommen";
						break;
				}

				echo "<br><br><div>".$phrase." </div>";
		?>
	</div>
</body>
</html>