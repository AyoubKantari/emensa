<?php
/**
 * Diese Datei enthält alle SQL Statements für die Tabelle "gerichte"
 */
function db_gericht_select_all() {
    try {
        $link = connectdb();
        $sql = 'SELECT id, name, beschreibung, bildname FROM gericht ORDER BY name';
        $result = mysqli_query($link, $sql);
        $data = mysqli_fetch_all($result, MYSQLI_BOTH);
        mysqli_close($link);
    }
    catch (Exception $ex) {
        $data = array(
            'id'=>'-1',
            'error'=>true,
            'name' => 'Datenbankfehler '.$ex->getCode(),
            'beschreibung' => $ex->getMessage());
    }
    finally {
        return $data;
    }
}

function db_gericht_select_expensive() {
    $link = connectdb();
    $sql = "SELECT name, preisintern, bildname FROM gericht WHERE preisintern > 2 
         ORDER BY name DESC";
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($link);
    return $data;
}

function db_gericht_select_for_homepage() {
    $link = connectdb();
    $sql = "SELECT id, name, beschreibung, preisintern, preisextern, bildname
            FROM gericht 
            ORDER BY name 
            LIMIT 5";
    $result = mysqli_query($link, $sql);
    $gerichte = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($gerichte as &$gericht) {
        $gericht_id = $gericht['id'];
        $sql_all = "SELECT code 
                    FROM gericht_hat_allergen 
                    WHERE gericht_id = $gericht_id";
        $result_all = mysqli_query($link, $sql_all);
        $allergene = mysqli_fetch_all($result_all, MYSQLI_ASSOC);
        $gericht['allergene'] = array_column($allergene, 'code');
    }
    mysqli_close($link);
    return $gerichte;
}
