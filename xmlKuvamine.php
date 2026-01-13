<?php
$opilased=simplexml_load_file("opilase.xml");
?>
<!DOCTYPE html>
<html>

<head>
    <title>XML faili kuvamine - Opilased.xml</title>
</head>
<body>
<h1>XML faili kuvamine - Opilased.xml</h1>
<?php
//1.opilase nimi
echo "1. opilase nimi: ".$opilased->opilane[0]->nimi;
?>
<table>
    <tr>
        <th>Õpilase nimi</th>
        <th>Isikukood</th>
        <th>Eriala</th>
        <th>Elukoht</th>
    </tr>
    <?php
    foreach($opilased->opilane as $opilane){
        echo "<tr>";
        echo "<td>".$opilane->nimi."</td>";
        echo "<td>".$opilane->isikukood."</td>";
        echo "<td>".$opilane->eriala."</td>";
        echo "<td>".$opilane->elukoht->linn.", ".$opilane->elukoht->maakond."</td>";
    }
    ?>
</table>
</body>
</html>