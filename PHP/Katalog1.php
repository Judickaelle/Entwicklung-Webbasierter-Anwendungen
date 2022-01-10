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
	<div class="search-container">
		<form action="katalog1.php" method="GET">
			<input type="text" id="search" placeholder="Search.." name="search">
			<button id="submit" type="submit">Submit</button>
		</form>
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


		//condition to display only what is needed on the web page
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			debug_to_console("url parsé : ".parse_url($actual_link, PHP_URL_QUERY));
			if(is_null(parse_url($actual_link, PHP_URL_QUERY)) != 1){
				//condition to check wether more information on a special book should be displayed or not
				if(contains(parse_url($actual_link, PHP_URL_QUERY),"detailid")){
					$detailId = $_GET['detailid'];
					display_more_information($bdd);
					display_all_book($bdd);
				}elseif(contains(parse_url($actual_link, PHP_URL_QUERY),"search")){
				//following part will display only the researched book if they exist
					$searchItem = $_GET['search'];
					debug_to_console("searchItem : ".$searchItem);
					$searchsuccessfull = search($searchItem, $bdd);
					if($searchsuccessfull === false){
						echo "<p style='color:red;'> No result found </p>";
						display_all_book($bdd);
					}
				}
			}else{
				display_all_book($bdd);
			}
			
			function search($searchItem, $bdd){
				$success = true;
				try{
					//$searchQuery = "SELECT * FROM g09.buecher1 WHERE `Autorname` like `%'$searchItem'%` OR `Produkttitel` like `%'$searchItem'%` ";
					$searchQuery = "SELECT * FROM g09.buecher1 WHERE `Autorname` LIKE '%$searchItem%' OR `Produkttitel` LIKE '%$searchItem%'";
					$searchResult = $bdd -> query($searchQuery);
				}catch(Exception $e){
					$error = die('Error : ' . $e->getMessage());
					debug_to_console($error);
				}

				$num = $searchResult->num_rows;
				if($num > 0){
					display_book($searchResult, $bdd);
				}else{
					$success = false;
				}
				return $success;	
			}

			function display_all_book($bdd){
				try{
					$query = "SELECT * FROM g09.buecher1";
					$result = $bdd -> query($query);
				}catch(Exception $e){
					$error = die('Error : ' . $e->getMessage());
					debug_to_console($error);
				}
				display_book($result, $bdd);
			}

		//function to display the books in a table 
			function display_book($result, $bdd){
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
			}
			

		//function to display more information about the book after clicking on the link
			function display_more_information($bdd){
				$detailId = $_GET['detailid'];
				$query = "SELECT * FROM g09.buecher1 WHERE `ID` = '$detailId'";;
				$result = $bdd -> query($query);
				//debug_to_console("query to get the book id is successfull");

				$bookdetail=array();
				while($row = $result->fetch_assoc()) {
					$bookdetail = array (
						$row["ID"],
						$row["Produktcode"],
						$row["Produkttitel"],
						$row["Autorname"],
						$row["Verlagsname"],
						$row["PreisNetto"],
						$row["Mwstsatz"],
						$row["PreisBrutto"],
						$row["Lagerbestand"],
						$row["Kurzinhalt"],
						$row["Gewicht"],
						$row["LinkGrafik"],
					);
				}

				echo "<div id='bookDetail'>
					<ul>
						<li> Book ID : ".$bookdetail[0]." </li>
						<li> Produktcode : ".$bookdetail[1]." </li>
						<li> Produkttitel : ".$bookdetail[2]." </li>
						<li> Autorname :  ".$bookdetail[3]." </li>
						<li> Verlagsname :  ".$bookdetail[4]." </li>
						<li> PreisNetto : ".$bookdetail[5]." </li>
						<li> Mwstsatz :  ".$bookdetail[6]." </li>
						<li> PreisBrutto :  ".$bookdetail[7]." </li>
						<li> Lagerbestand :  ".$bookdetail[8]." </li>
						<li> Kurzinhalt :  ".$bookdetail[9]."] </li>
						<li> Gewicht :  ".$bookdetail[10]." </li>
						<li> LinkGrafik :  ".$bookdetail[11]." </li>
					</ul>";
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
	
				$query = "SELECT ID FROM g09.buecher1 WHERE `Produkttitel` = '$obj'";
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
		
		//check wether a string contain a particular substring
			function contains($haystack, $needle){
				$OR = '||';
				$result = false;
			   
				$ORpos = strpos($needle, $OR, 0);
				if($ORpos !== false){ //ORs exist in the needle string
					$needle_arr = explode($OR, $needle);
					for($i=0; $i < count($needle_arr); $i++){
						$pos = strpos($haystack, trim($needle_arr[$i]));
						if($pos !== false){
							$result = true;
							break;
						}
					}       
				} else {
					$pos = strpos($haystack, trim($needle));
					if($pos !== false){
					  $result = true;
					}
				}
			  return($result);
			}
		?>

		</div>
</body>
</html>