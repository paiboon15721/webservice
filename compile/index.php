<?php
require '../core/init.php';

$pathBlueprints = '../blueprints';
$pathModels = '../models';
$pathServices = '../services';

echo 'compiling...<br />';

//Delete All models
$files = glob($pathModels . '/*');
foreach ($files as $file) {
    if (is_file($file))
        unlink($file);
}

//Delete All services
$files = glob($pathServices . '/*');
foreach ($files as $file) {
    if (is_file($file))
        unlink($file);
}

//Generate
$files = glob($pathBlueprints . '/*');
foreach ($files as $file) {
    $className = basename($file, ".json");
    echo $file . '<br />';
    $json = file_get_contents($file);
    $blueprint = json_decode($json);

    //Generate models
    $myfile = fopen($pathModels . '/' . $className . '.php', 'w') or die('Unable to open file!');
    $txt = '<?php' . "\n\n"
        . 'class ' . $className . "\n"
        . '{' . "\n";
    $properties = $blueprint->properties;
    foreach ($properties as $property) {
        $txt .= '   public $' . $property . ';' . "\n";
    }
    $txt .= "\n" . '   public static function get(array $parameters)' . "\n"
        . '   {' . "\n"
        . '       return WebService::getObject(' . "\n"
        . '           array(' . "\n"
        . "             'serviceName' => '" . $blueprint->serviceName . "'," . "\n"
        . "             'serviceNumber' => '" . $blueprint->serviceNumber . "'," . "\n"
        . "             'startAt' => " . $blueprint->startAt . ',' . "\n"
        . "             'parameters' => " . '$parameters,' . "\n"
        . "             'class' => " . '__CLASS__,' . "\n"
        . '            )' . "\n"
        . '         );' . "\n"
        . '     }' . "\n"
        . '}';
    fwrite($myfile, $txt);
    fclose($myfile);

    //Generate services
    $myfile = fopen($pathServices . '/get' . $className . '.php', 'w') or die('Unable to open file!');
    $txt = '<?php' . "\n"
        . "require '../core/init.php';" . "\n"
        . "header('Content-Type: application/json');\n"
        . 'echo ' . $className . '::get(' . "\n"
        . ' array(' . "\n";
    $parameters = $blueprint->parameters;
    foreach ($parameters as $parameter) {
        $txt .= '       Input::get(' . "'" . $parameter . "'),\n";
    }
    $txt .= '   )' . "\n"
        . ')->getJSON();';
    fwrite($myfile, $txt);
    fclose($myfile);
}
echo 'finished!!';
