<?php
if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'Ajouter Registre' :
			newIndexElement(databaseConnection());
			exit;
		case 'Modifier Registre' :
			modifierIndexElement(databaseConnection());
			exit;
		case 'Supprimer Registre' :
			supprimerIndexElement(databaseConnection());
			exit;
		case 'Ajouter Fichier' :
			nouvFichier();
			exit;
		case 'Supprimer Fichier' :
			suppFichier();
			exit;
		case 'Obtenir Fichier' :
			exit(obtFichier());
		case 'Modifier Fichier' :
			modFichier();
			exit;
		case 'Ajouter Lien' :
			ajouterLien(databaseConnection());
			exit;
		case 'Supprimer Lien' :
			supprimerLien(databaseConnection());
			exit;
		case 'Obtenir Lien Information' :
			exit(obtLienInformation(databaseConnection()));
		case 'Modifier Lien' :
			modifierLien(databaseConnection());
			exit;
		case 'Ajouter Lien Vertical' :
			verticalnewlink();
			exit;
		case 'Supprimer Lien Vertical' :
			verticalsupplink();
			exit;
		case 'Obtenir Info Position' :
			exit(obtInfoLienVertical());
		case 'Modifier Lien Vertical' :
			modlinkvertical();
			exit;
		case 'Voir les Modifications' :
			modFichierPreview();
			exit;
	}
}

function newIndexElement($conn) {
	$fichier = filter_input(INPUT_POST, 'fichier', FILTER_SANITIZE_STRING);
	$colspan = $_POST['colspan'];
	$rowspan = $_POST['rowspan'];
	$position = $_POST['position'];
	$lastcols = ($_POST['lastcols'] == 'true'?1:0);
	
	
	if (filter_var($colspan,FILTER_VALIDATE_INT) and filter_var($rowspan,FILTER_VALIDATE_INT) and
		filter_var($position,FILTER_VALIDATE_INT) and (filter_var($lastcols, FILTER_VALIDATE_INT) or filter_var($lastcols, FILTER_VALIDATE_INT) === 0)) {
			$insert_stmt = $conn->prepare("INSERT INTO displaymenu (nomFichier,colspan,rowspan,position,lastCols) VALUES (?,?,?,?,?)");
			$insert_stmt->bind_param('siiii',$fichier,$colspan,$rowspan,$position,$lastcols);
			$insert_stmt->execute();
	}
	
	$conn->close();
}

function modifierIndexElement($conn) {
	$fichierId = $_POST['itemid'];
	$fichier = filter_input(INPUT_POST, 'fichier', FILTER_SANITIZE_STRING);
	$colspan = $_POST['colspan'];
	$rowspan = $_POST['rowspan'];
	$position = $_POST['position'];
	$lastcols = ($_POST['lastcols'] == 'true'?1:0);
	
	
	if (filter_var($fichierId,FILTER_VALIDATE_INT) and filter_var($colspan,FILTER_VALIDATE_INT) and filter_var($rowspan,FILTER_VALIDATE_INT) and
		filter_var($position,FILTER_VALIDATE_INT) and (filter_var($lastcols, FILTER_VALIDATE_INT) or filter_var($lastcols, FILTER_VALIDATE_INT) === 0)) {
			$insert_stmt = $conn->prepare("UPDATE displaymenu SET nomFichier = ?, colspan = ?, rowspan = ?, position = ?, lastCols = ? where itemId = ?");
			$insert_stmt->bind_param('siiiii',$fichier,$colspan,$rowspan,$position,$lastcols,$fichierId);
			$insert_stmt->execute();
	}
	
	$conn->close();
}

function supprimerIndexElement($conn) {
	$fichierId = $_POST['itemid'];
	
	if (filter_var($fichierId,FILTER_VALIDATE_INT)) {
			$insert_stmt = $conn->prepare("DELETE FROM displaymenu where itemId = ?");
			$insert_stmt->bind_param('i',$fichierId);
			$insert_stmt->execute();
	}
	
	$conn->close();
}


function nouvFichier() {
	$fichier = "../" . filter_input(INPUT_POST, 'fichier', FILTER_SANITIZE_STRING);

	if ($fp = fopen($fichier,"w+")) {
		fwrite($fp,"<style>\n   .default {\n   width: 100%\n   max-height : 100%;\n}\n</style>\n\n <a href...>\n   <img ... >\n </a>");
		fclose($fp);
	}
}

function suppFichier() {
	$fichier = "../" . filter_input(INPUT_POST, 'fichier', FILTER_SANITIZE_STRING);
	unlink($fichier);
}

function obtFichier() {
	$fichier = "../" . filter_input(INPUT_POST, 'fichier', FILTER_SANITIZE_STRING);
	$content = file_get_contents($fichier);
	
	return $content;
}

function modFichier() {
	$fichier = "../" . filter_input(INPUT_POST, 'fichier', FILTER_SANITIZE_STRING);
	$content = $_POST['content'];
	if ($fp = fopen($fichier,"w+")) {
		fwrite($fp,$content);
		fclose($fp);
		unlink('../preview' . filter_input(INPUT_POST, 'fichier', FILTER_SANITIZE_STRING));
	}
}

function modFichierPreview() {
	$fichier = "../preview" . filter_input(INPUT_POST, 'fichier', FILTER_SANITIZE_STRING);
	$content = $_POST['content'];
	if ($fp = fopen($fichier,"w+")) {
		fwrite($fp,$content);
		fclose($fp);
	}
}

function ajouterLien($conn) {
	$nomlien = utf8_decode($_POST['nomlien']);
	$lien = $_POST['lien'];
	$position = $_POST['position'];
	$maxPosition = 1;
	
	$sql = "select max(renderHtmlPosition) as max from lienmenuderoulant";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		$value = $result->fetch_assoc();
		$maxPosition = $value['max'];
	}
	
	if ($position <= $maxPosition) {
		for ($i = $maxPosition; $position <= $i; $i--) {
			$insert_stmt = $conn->prepare("UPDATE lienmenuderoulant set renderHtmlPosition = ? where renderHtmlPosition = ?");
			$newval = $i + 1;
			$insert_stmt->bind_param('ii', $newval, $i);
			$insert_stmt->execute();
		}
	}
	
	$insert_stmt = $conn->prepare("INSERT INTO lienmenuderoulant (nomLien,lien,renderHtmlPosition) VALUES (?,?,?)");
	$insert_stmt->bind_param('ssi',$nomlien,$lien,$position);
	$insert_stmt->execute();
	
	$conn->close();
}

function supprimerLien($conn) {
	$id = $_POST['idlien'];
	$maxPosition = 1;
	$itemPosition = 0;
	
	$sql = "select max(renderHtmlPosition) as max from lienmenuderoulant";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		$value = $result->fetch_assoc();
		$maxPosition = $value['max'];
	}
	
	$insert_stmt = $conn->prepare("select renderHtmlPosition from lienmenuderoulant where menuId = ?");
	$insert_stmt->bind_param('i',$id);
	$insert_stmt->execute();
	$insert_stmt->store_result();
	$result = $insert_stmt->fetch();
	$itemPosition = $result['renderHtmlPosition'];
	
	$insert_stmt = $conn->prepare("DELETE FROM lienmenuderoulant where menuId = ?");
	$insert_stmt->bind_param('i',$id);
	$insert_stmt->execute();

	if ($itemPosition < $maxPosition) {
		for ($i = $itemPosition; $i < $maxPosition; $i++) {
			$insert_stmt = $conn->prepare("UPDATE lienmenuderoulant set renderHtmlPosition = ? where renderHtmlPosition = ?");
			$newval = $i + 1;
			$insert_stmt->bind_param('ii', $i, $newval);
			$insert_stmt->execute();
		}
	}
}

function obtLienInformation($conn) {
	$idlien = $_POST['idlien'];
	
	$insert_stmt = $conn->prepare("select renderHtmlPosition,nomLien,lien from lienmenuderoulant where menuId = ?");
	$insert_stmt->bind_param('i',$idlien);
	$insert_stmt->execute();
	$insert_stmt->bind_result($itemPosition, $itemTitre,$itemLien);
	$result = $insert_stmt->fetch();
	
	$conn->close();
	
	$bus = array();
	$bus['titre'] = utf8_encode($itemTitre);
	$bus['lien'] = utf8_encode($itemLien);
	$bus['position'] = $itemPosition;

	return html_entity_decode(json_encode($bus));
}

function modifierLien($conn) {
	$idlien = $_POST['idlien'];
	$titre = utf8_decode($_POST['titre']);
	$lien = utf8_decode($_POST['lien']);
	$position = $_POST['position'];
	$positionDB = 0;
	$maxPosition = 1;
	
	$insert_stmt = $conn->prepare("select renderHtmlPosition from lienmenuderoulant where menuId = ?");
	$insert_stmt->bind_param('i',$idlien);
	$insert_stmt->execute();
	$insert_stmt->bind_result($positionDB);
	$insert_stmt->fetch();
	
	$conn->close();
	$conn = databaseConnection();
	//Same position - Easy!
	if ($positionDB == $position) {
		$insert_stmt2 = $conn->prepare("update lienmenuderoulant set nomLien = ?, lien = ?  where menuId = ?");
		$insert_stmt2->bind_param('ssi', $titre, $lien, $idlien);
		$insert_stmt2->execute();
	} else {
		//Get the max Position
		$sql = "select max(renderHtmlPosition) as max from lienmenuderoulant";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			$value = $result->fetch_assoc();
			$maxPosition = $value['max'];
		}
		//Easy!
		if ($position > $maxPosition) {
			$newposition = $maxPosition + 1;
			$insert_stmt = $conn->prepare("UPDATE lienmenuderoulant SET nomLien = ?, lien = ?, renderHtmlPosition = ? where menuId = ?");
			$insert_stmt->bind_param('ssii', $titre,$lien, $newposition ,$idlien);
			$insert_stmt->execute();
			
			for ($i = $positionDB; $i <= $maxPosition; $i++) {
				$insert_stmt = $conn->prepare("UPDATE lienmenuderoulant set renderHtmlPosition = ? where renderHtmlPosition = ?");
				$newval = $i + 1;
				$insert_stmt->bind_param('ii', $i, $newval);
				$insert_stmt->execute();
			}
		} else {
			//Put current position at the end
			$max = $maxPosition + 1;
			$insert_stmt = $conn->prepare("UPDATE lienmenuderoulant SET renderHtmlPosition = ? where renderHtmlPosition = ?");
			$insert_stmt->bind_param('ii', $max ,$position);
			$insert_stmt->execute();
			
			//Set the new value at the current position
			$insert_stmt = $conn->prepare("UPDATE lienmenuderoulant SET nomLien = ?, lien = ?, renderHtmlPosition = ? where menuId = ?");
			$insert_stmt->bind_param('ssii', $titre,$lien, $position ,$idlien);
			$insert_stmt->execute();
			
			//Value at the end take the position of the value that took his place
			$insert_stmt = $conn->prepare("UPDATE lienmenuderoulant SET renderHtmlPosition = ? where renderHtmlPosition = ?");
			$insert_stmt->bind_param('ii', $positionDB ,$max);
			$insert_stmt->execute();
		}
	}
	$conn->close();
}

function getmaxposition() {
	$sql = "select max(renderHtmlPosition) as max from verticalmenu";
	$conn = databaseConnection();
	$result = $conn->query($sql);
	
	$value = $result->fetch_assoc();
	$conn->close();
	
	return $value['max'];
}

function insertValueVerticalMenu($nomLien,$lien,$layer,$renderHtmlPosition,$htmlCouleur,$newPage) {
	$conn = databaseConnection();
	$insert_stmt = $conn->prepare("INSERT INTO verticalmenu (nomLien,lien,layer,renderHtmlPosition,htmlCouleur, openNewPage) VALUES (?,?,?,?,?,?)");
	$insert_stmt->bind_param('ssiisi',$nomLien,$lien,$layer,$renderHtmlPosition,$htmlCouleur,$newPage);
	$insert_stmt->execute();
	$conn->close();
}

function moveValueForInsertLayerOne($Position) {  
	$maxPosition = getmaxposition();
	for($i = $maxPosition; $Position <= $i; $i--) {
		$conn = databaseConnection();
		$insert_stmt = $conn->prepare("UPDATE verticalmenu SET renderHtmlPosition = ?  where renderHtmlPosition = ?");
		$newVal = $i + 1;
		$insert_stmt->bind_param('ii',$newVal,$i);
		$insert_stmt->execute();
		$conn->close();
	}
}

function moveValueForInsertLayerTwo($Position) {  
	$maxPosition = getmaxposition();
	for($i = $maxPosition; $Position < $i; $i--) {
		$conn = databaseConnection();
		$insert_stmt = $conn->prepare("UPDATE verticalmenu SET renderHtmlPosition = ?  where renderHtmlPosition = ?");
		$newVal = $i + 1;
		$insert_stmt->bind_param('ii',$newVal,$i);
		$insert_stmt->execute();
		$conn->close();
	}
}

function MoveFirstLayer() {
	$titre = $_POST['titre'];
	$link = $_POST['link'];
	$position = $_POST['position'];
	$layer = $_POST['layer'];
	$htmlcolor = $_POST['htmlcolor'];
	$newpage = ($_POST['newpage'] == 'true'?1:0);
	$maxPosition = getmaxposition();
	$positionValide = false;
	
	//Highest Position
	if ($position > $maxPosition) {
		$position = $maxPosition + 1;
		insertValueVerticalMenu($titre,$link,$layer,$position,$htmlcolor,$newpage);
	} else {
		$sql = "select renderHtmlPosition from verticalmenu where layer = 1";
		$conn = databaseConnection();
		$result = $conn->query($sql);
							
		if ($result->num_rows > 0) {
			while($current = $result->fetch_assoc()) {
				if ($position == $current['renderHtmlPosition']) {
					$positionValide = true;
					break;
				}
			}
		}
		$conn->close();
		if ($positionValide == true) {
			moveValueForInsertLayerOne($position);
			insertValueVerticalMenu($titre,$link,$layer,$position,$htmlcolor,$newpage);
		}
	}
}

function MoveSecondLayer() {
	$titre = $_POST['titre'];
	$link = $_POST['link'];
	$position = $_POST['position'];
	$layer = $_POST['layer'];
	$htmlcolor = $_POST['htmlcolor'];
	$newpage = ($_POST['newpage'] == 'true'?1:0);
	$positionValide = false;
	
	$sql = "select renderHtmlPosition from verticalmenu where layer = 1 or layer = 2";
	$conn = databaseConnection();
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		while($current = $result->fetch_assoc()) {
			if ($position == $current['renderHtmlPosition']) {
				$positionValide = true;
				break;
			}
		}
	}
	$conn->close();
	
	if ($positionValide == true) {
		moveValueForInsertLayerTwo($position);
		insertValueVerticalMenu($titre,$link,$layer,$position + 1,$htmlcolor,$newpage);
	}
}

function MoveThirdLayer() {
	$titre = $_POST['titre'];
	$link = $_POST['link'];
	$position = $_POST['position'];
	$layer = $_POST['layer'];
	$htmlcolor = $_POST['htmlcolor'];
	$newpage = ($_POST['newpage'] == 'true'?1:0);
	$positionValide = false;
	
	$sql = "select renderHtmlPosition from verticalmenu where layer = 2 or layer = 3";
	$conn = databaseConnection();
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		while($current = $result->fetch_assoc()) {
			if ($position == $current['renderHtmlPosition']) {
				$positionValide = true;
				break;
			}
		}
	}
	$conn->close();
	
	if ($positionValide == true) {
		moveValueForInsertLayerTwo($position);
		insertValueVerticalMenu($titre,$link,$layer,$position + 1,$htmlcolor,$newpage);
	}
}

function verticalnewlink() {
	$layer = $_POST['layer'];
	
	if ($layer == 1) {
		 MoveFirstLayer();
	} else if ($layer == 2) {
		MoveSecondLayer();
	} else {
		MoveThirdLayer();
	}
}

function getLayerOfPosition($position) {
	$conn = databaseConnection();
	
	$insert_stmt = $conn->prepare("select layer from verticalmenu where renderHtmlPosition = ?");
	$insert_stmt->bind_param('i',$position);
	$insert_stmt->execute();
	
	$insert_stmt->bind_result($itemPosition);
	$insert_stmt->fetch();
	
	$conn->close();
	
	return $itemPosition;
}

function DeletePosition($Position) {
	$conn = databaseConnection();
	$insert_stmt = $conn->prepare("DELETE FROM verticalmenu where renderHtmlPosition = ?");
	$insert_stmt->bind_param('i',$Position);
	$insert_stmt->execute();
	$conn->close();
}

function moveValuesAfterDelete($Position) {  
	$maxPosition = getmaxposition(); 
	for($i = $Position + 1; $i <= $maxPosition; $i++) {
		$conn = databaseConnection();
		$insert_stmt = $conn->prepare("UPDATE verticalmenu SET renderHtmlPosition = ?  where renderHtmlPosition = ?");
		$newVal = $i - 1;
		$insert_stmt->bind_param('ii',$newVal,$i);
		$insert_stmt->execute();
		$conn->close();
	}
}

function verticalsupplink() {
	$position = $_POST['position'];
	$maxPosition = getmaxposition();
	
	if ($position >= $maxPosition) {
		DeletePosition($maxPosition);
	} else {
		$nextLayer = getLayerOfPosition($position + 1);
		$currentLayer = getLayerOfPosition($position);
		
		if ($currentLayer >= $nextLayer) {
			DeletePosition($position);
			moveValuesAfterDelete($position);
		}
	}
}

function obtInfoLienVertical() {
	$position = $_POST['position'];
	
	$conn = databaseConnection();
	$insert_stmt = $conn->prepare("select nomLien,lien,htmlCouleur,openNewPage from verticalmenu where renderHtmlPosition = ?");
	$insert_stmt->bind_param('i',$position);
	$insert_stmt->execute();
	$insert_stmt->bind_result($nomLien, $lien,$htmlCouleur,$openNewPage);
	$result = $insert_stmt->fetch();
	
	$conn->close();
	
	$bus = array();
	$bus['titre'] = utf8_encode($nomLien);
	$bus['lien'] = $lien;
	$bus['couleur'] = $htmlCouleur;
	$bus['newpage'] = ($openNewPage == 1)?true:false;

	return html_entity_decode(json_encode($bus));
}

function modlinkvertical() {
	$titre = utf8_decode($_POST['titre']);
	$lien = $_POST['lien'];
	$htmlcolor = $_POST['htmlcolor'];
	$newpage = ($_POST['newpage'] == 'true'?1:0);
	$position = $_POST['position'];
	
	$conn = databaseConnection();
	$insert_stmt = $conn->prepare("UPDATE verticalmenu SET nomLien = ?, lien = ?, htmlCouleur = ?, openNewPage = ? where renderHtmlPosition = ?");
	$insert_stmt->bind_param('sssii',$titre,$lien,$htmlcolor,$newpage,$position);
	$insert_stmt->execute();
	$conn->close();
}
?>
