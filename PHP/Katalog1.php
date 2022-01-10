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
	<h1>Willkommen in unserer Bibliotek </h1>
	<div id="researchBar"> research bar
	</div>
	<div id="element">
		<?php
		
		//connection to the mySQL server
			$servername = "localhost";
			$username = "G09";
			$password = "ws21roge";
			$dbname = "g09";
			
			try{
				$bdd = new mysqli($servername, $username, $password);
				//$bdd->set_charset("utf8mb4");
			}catch(Exception $e){
				$error = die('Error : ' . $e->getMessage());
				debug_to_console($error);
			}
			
			//debug_to_console("db connected");

			try{
				$query = "SELECT * FROM g09.buecher1";
				$result = $bdd -> query($query);
			}catch(Exception $e){
				$error = die('Error : ' . $e->getMessage());
				debug_to_console($error);
			}
			
			//debug_to_console("query to get the data is successfull");

		//display items from database
			echo "<table>
				<tr>
					<th>Büchertitel</th>
					<th>Autorennamen</th
				</tr>";

			$data = array();	
			while($row = $result->fetch_assoc()){
				$data = array(
					$row["Produkttitel"] => $row["Autorname"],
				);
				foreach ($data as $x => $value) {
					//get the ProductID
					$id = get_id($x, $bdd);

					//display the result in the table
					echo "<tr>
							<td><a href='Katalog1.php?detailid=" . $id . "'>$x</a></td>
							<td>$value</td>
						</tr>";
				}
			}

		//allow to write in the consol
			function debug_to_console( $data ) {
				$output = $data;
				if ( is_array( $output ) )
					$output = implode( ',', $output);
			
				echo "<script>console.log( 'Debug : " . $output . "' );</script>";
			}

		//get the product id
			function get_id($obj, $bdd){
	
				$query = "SELECT ID FROM g09.buecher1 WHERE `Produkttitel` = '$obj'";;
				$result = $bdd -> query($query);
				//debug_to_console("query to get the book id is successfull");
				
				$id = "test";
				// Fetch result
				$num = $result->num_rows;
				//debug_to_console("nombre ligne récupérée : ".$num);
				while($row = $result->fetch_assoc()) {
					$id = $row["ID"];
				}
				//debug_to_console("book : ".$obj." id : ".$id);

				$result -> free_result();
				return $id;
			}
		?>

		</div>
</body>
</html>