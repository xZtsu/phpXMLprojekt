<?php
function LisaOpilane()
{
    $xmlDoc = new DOMDocument("1.0", "UTF-8");
    $xmlDoc->formatOutput = true;

    if (file_exists("opilased.xml")) {
        $xmlDoc->load("opilased.xml");
        $root = $xmlDoc->documentElement;
    } else {
        $root = $xmlDoc->createElement("opilased");
        $xmlDoc->appendChild($root);
    }

    // <opilane>
    $opilane = $xmlDoc->createElement("opilane");
    $root->appendChild($opilane);

    // simple fields
    $opilane->appendChild($xmlDoc->createElement("nimi", $_POST["nimi"]));
    $opilane->appendChild($xmlDoc->createElement("isikukood", $_POST["isikukood"]));
    $opilane->appendChild($xmlDoc->createElement("eriala", $_POST["eriala"]));

    // <elukoht>
    $elukoht = $xmlDoc->createElement("elukoht");
    $elukoht->appendChild($xmlDoc->createElement("linn", $_POST["linn"]));
    $elukoht->appendChild($xmlDoc->createElement("maakond", $_POST["maakond"]));
    $opilane->appendChild($elukoht);

    // <pilt>
    $opilane->appendChild($xmlDoc->createElement("pilt"));

    // AINED (multiple!)
    for ($i = 0; $i < count($_POST["nimetus"]); $i++) {
        if (!empty($_POST["nimetus"][$i])) {
            $aine = $xmlDoc->createElement("aine");
            $aine->appendChild($xmlDoc->createElement("nimetus", $_POST["nimetus"][$i]));
            $aine->appendChild($xmlDoc->createElement("hinne", $_POST["hinne"][$i]));
            $opilane->appendChild($aine);
        }
    }

    $xmlDoc->save("opilased.xml");
}

    if(isset($_POST["submit"]))
    {
        LisaOpilane();
        header("Location: " . $_SERVER["PHP_SELF"]);
    }
$opilased=simplexml_load_file("opilased.xml");



//õpilase otsing
function erialaOtsing($paring){
    global $opilased;
    $tulemus=array();
    foreach($opilased->opilane as $opilane) {
        if (substr(strtolower($opilane->eriala), 0, strlen($paring))
            == strtolower($paring)) {
            array_push($tulemus, $opilane);
        } else if (substr(strtolower($opilane->nimi), 0, strlen($paring))
            == strtolower($paring)) {
            array_push($tulemus, $opilane);
        } else if (substr(strtolower($opilane->isikukood), 0, strlen($paring))
            == strtolower($paring)) {
            array_push($tulemus, $opilane);
        }
    }
    return $tulemus;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>XML faili kuvamine - Opilased.xml</title>
</head>
<link rel="stylesheet" href="tableStyle.css">
<body>
<h1>XML faili kuvamine - Opilased.xml</h1>
<?php
//1.õpilase nimi
//echo "1.õpilase nimi: ".$opilased->opilane[0]->nimi;
//kõik õpilased
?>
<form action="?" method="post">
    <label for="otsing">Otsi:</label>
    <input type="text" name="otsing" id="otsing" placeholder="Nimi | Eriala | isikukood">
    <input type="submit" value="OK">
</form>
<?php
//otsingu tulemus:
if(!empty($_POST['otsing'])){
    $tulemus=erialaOtsing($_POST['otsing']);

      echo "  <table>
    <tr>
        <th>Õpilase nimi</th>
        <th>Isikukood</th>
        <th>Eriala</th>
        <th>Elukoht</th>
        <th>Aine</th>
    </tr>";
foreach($tulemus as $opilane){
            echo "<tr>";
        echo "<td>".$opilane->nimi."</td>";
        echo "<td>".$opilane->isikukood."</td>";
        echo "<td>".$opilane->eriala."</td>";
        echo "<td>".$opilane->elukoht->linn.", ".
            $opilane->elukoht->maakond."</td>";
    echo "<td>";
    foreach ($opilane->aine as $aine) {
        echo $aine->nimetus . " (hinne " . $aine->hinne . ")<br>";
    }
    echo "</td>";
        echo "</tr>";
    }
    echo "</table>";

} else {
?>
<table>
    <tr>
        <th>Õpilase nimi</th>
        <th>Isikukood</th>
        <th>Eriala</th>
        <th>Elukoht</th>
        <th>Aine</th>
    </tr>
    <?php
    foreach($opilased->opilane as $opilane){
        echo "<tr>";
        echo "<td>".$opilane->nimi."</td>";
        echo "<td>".$opilane->isikukood."</td>";
        echo "<td>".$opilane->eriala."</td>";
        echo "<td>".$opilane->elukoht->linn.", ".
            $opilane->elukoht->maakond."</td>";
        echo "<td>";
        foreach ($opilane->aine as $aine) {
            echo $aine->nimetus . " (hinne " . $aine->hinne . ")<br>";
        }
        echo "</td>";

        echo "</tr>";
    }
    }
    ?>
</table>
<h2>Õpilase sisestamine</h2>
<table>
    <form action="" method="post" name="vorm1">
        <tr>
            <td><label for="nimi">Nimi:</label></td>
            <td><input type="text" name="nimi" id="nimi" ></td>
        </tr>
        <tr>
            <td><label for="eriala">Eriala:</label></td>
            <td><input type="text" name="eriala" id="eriala" ></td>
        </tr>
        <tr>
            <td><label for="isikukood">Isikukood:</label></td>
            <td><input type="text" name="isikukood" id="isikukood" ></td>
        </tr>
        <tr>
            <td><label for="linn">Linn</label></td>
            <td><input type="text" name="linn" id="linn" ></td>
        </tr>
        <tr>
            <td><label for="maakond">Maakond:</label></td>
            <td><input type="text" name="maakond" id="maakond" ></td>
        </tr>
        <tr>
        <tr>
            <td>Aine nimetus 1:</td>
            <td><input type="text" name="nimetus[]"></td>
        </tr>
        <tr>
            <td>Hinne 1:</td>
            <td><input type="text" name="hinne[]"></td>
        </tr>
        <tr>
            <td>Aine nimetus 2:</td>
            <td><input type="text" name="nimetus[]"></td>
        </tr>
        <tr>
            <td>Hinne 2:</td>
            <td><input type="text" name="hinne[]"></td>
        </tr>


        <tr>
            <td><input type="submit" name="submit" id="submit" value="Sisesta"></td>
            <td></td>
        </tr>
    </form>
   
</body>
</html>
