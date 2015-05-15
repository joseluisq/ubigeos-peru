<?php

include 'JLDatabase.php';

$host = 'localhost';
$dbname = 'dbutils';
$username = 'root';
$password = 'lnm';

$db = JLDatabase::getInstance();
$db->setDriver('mysql');
$db->setDatabaseName($dbname);
$db->setHostName($host);
$db->setUserName($username);
$db->setPassword($password);
$db->connect();

$dbh = $db->getConnection();

// Departamentos
$sql = '
SELECT  `id_ubigeo` ,  `nombre_ubigeo` ,  `codigo_ubigeo` ,  `etiqueta_ubigeo` ,  `buscador_ubigeo` ,  `numero_hijos_ubigeo` ,  `nivel_ubigeo` ,  `id_padre_ubigeo`
FROM  `ubigeo`
WHERE  `id_padre_ubigeo` = 2533
ORDER BY  `ubigeo`.`nombre_ubigeo` ASC
';

$sth = $dbh->prepare($sql);
$sth->execute();
$departaments = $sth->fetchAll(PDO::FETCH_ASSOC);
$provinces = array();
$provinces2 = array();
$districts = array();

// Provincias
foreach ($departaments as $departament) {
	$sql = '
    SELECT  `id_ubigeo` ,  `nombre_ubigeo` ,  `codigo_ubigeo` ,  `etiqueta_ubigeo` ,  `buscador_ubigeo` ,  `numero_hijos_ubigeo` ,  `nivel_ubigeo` ,  `id_padre_ubigeo`
    FROM  `ubigeo`
    WHERE  `id_padre_ubigeo` = ?
    ORDER BY  `ubigeo`.`nombre_ubigeo` ASC
  ';
	$sth = $dbh->prepare($sql);
	$sth->execute(array($departament['id_ubigeo']));
	$provinces[$departament['id_ubigeo']] = $sth->fetchAll(PDO::FETCH_ASSOC);
};

// Distritos
$sql = '
  SELECT  `id_ubigeo` ,  `nombre_ubigeo` ,  `codigo_ubigeo` ,  `etiqueta_ubigeo` ,  `buscador_ubigeo` ,  `numero_hijos_ubigeo` ,  `nivel_ubigeo` ,  `id_padre_ubigeo`
  FROM  `ubigeo`
  WHERE  `id_padre_ubigeo` = ?
  ORDER BY  `ubigeo`.`nombre_ubigeo` ASC
';

foreach ($provinces as $province) {
	foreach ($province as $province_one) {
		$sth = $dbh->prepare($sql);
		$sth->execute(array($province_one['id_ubigeo']));
		$districts[$province_one['id_ubigeo']] = $sth->fetchAll(PDO::FETCH_ASSOC);
	};
};

// echo json_encode($departaments);
// echo json_encode($provinces);
// echo json_encode($districts);
