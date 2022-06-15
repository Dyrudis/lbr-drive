<?php

// Activation des rapports d'erreurs
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Connexion à la base de données
try {
    $mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');
} catch (mysqli_sql_exception $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// Fonction qui effectue un prepared statement
//
// Exemple d'utilisation :
// $result = query("SELECT * FROM x WHERE y = ?", "i", $var);
// 
// $result est de la forme [{"a": 0, "b": 1}, {"a": 2, "b": 3}, ...]
// Le nombre de lignes renvoyées est donc calculé avec count($result)
function query($query, $types = "", ...$vars)
{
    global $mysqli;
    $stmt = $mysqli->prepare($query);
    if ($types != "") {
        $stmt->bind_param($types, ...$vars);
    }
    $stmt->execute();
    $result = get_result($stmt);
    return $result;
}

// Fonction qui remplace $stmt->get_result()
function get_result($stmt)
{
    $result = array();
    $stmt->store_result();
    for ($i = 0; $i < $stmt->num_rows; $i++) {
        $metadata = $stmt->result_metadata();
        $params = array();
        while ($field = $metadata->fetch_field()) {
            $params[] = &$result[$i][$field->name];
        }
        call_user_func_array(array($stmt, 'bind_result'), $params);
        $stmt->fetch();
    }
    return $result;
}
