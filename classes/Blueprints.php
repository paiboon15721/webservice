<?php

class Blueprints
{
    public static $path = '../blueprints';

    private $blueprintName;
    private $serviceName;
    private $serviceNumber;
    private $returnDataStartAt;
    private $parameters;
    private $properties;
    private $description;

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getBlueprintName()
    {
        return $this->blueprintName;
    }

    /**
     * @param mixed $blueprintName
     */
    public function setBlueprintName($blueprintName)
    {
        $this->blueprintName = $blueprintName;
    }

    /**
     * @return mixed
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * @param mixed $serviceName
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
    }

    /**
     * @return mixed
     */
    public function getServiceNumber()
    {
        return $this->serviceNumber;
    }

    /**
     * @param mixed $serviceNumber
     */
    public function setServiceNumber($serviceNumber)
    {
        $this->serviceNumber = $serviceNumber;
    }

    /**
     * @return mixed
     */
    public function getReturnDataStartAt()
    {
        return $this->returnDataStartAt;
    }

    /**
     * @param mixed $returnDataStartAt
     */
    public function setReturnDataStartAt($returnDataStartAt)
    {
        $this->returnDataStartAt = $returnDataStartAt;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param mixed $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param mixed $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    public static function find($blueprintName)
    {
        $blueprintPath = Blueprints::$path . '/' . $blueprintName . '.json';
        if (is_file($blueprintPath)) {
            $blueprintContent = json_decode(file_get_contents($blueprintPath));
            $blueprint = new Blueprints();
            $blueprint->setBlueprintName($blueprintName);
            $blueprint->setServiceName($blueprintContent->serviceName);
            $blueprint->setServiceNumber($blueprintContent->serviceNumber);
            $blueprint->setParameters($blueprintContent->parameters);
            $blueprint->setReturnDataStartAt($blueprintContent->returnDataStartAt);
            $blueprint->setProperties($blueprintContent->properties);
            $blueprint->setDescription($blueprintContent->description);
            return $blueprint;
        }
        return false;
    }

    public function insert()
    {
        return $this->insertOrUpdate();
    }

    public function update()
    {
        return $this->insertOrUpdate();
    }

    private function insertOrUpdate()
    {
        if (trim($this->blueprintName) <> '') {
            $blueprintFile = fopen(Blueprints::$path . '/' . $this->blueprintName . '.json', 'w') or die('Unable to open file!');
            $blueprintContent = JSONObject::encode(array_slice(get_object_vars($this), 1));
            fwrite($blueprintFile, $blueprintContent);
            fclose($blueprintFile);
        }
        return Blueprints::getAll();
    }

    public function delete()
    {
        $blueprintPath = Blueprints::$path . '/' . $this->blueprintName . '.json';
        if (is_file($blueprintPath)) {
            unlink($blueprintPath);
            return Blueprints::getAll();
        }
        return false;
    }

    public static function getAll()
    {
        $blueprintsPath = glob(Blueprints::$path . '/*');
        $blueprintsName = array_map(
            function ($blueprintPath) {
                return array("blueprintName" => basename($blueprintPath, ".json"));
            }, $blueprintsPath);
        $blueprintsContent = array();
        foreach ($blueprintsPath as $blueprintPath) {
            $blueprintContent = (array)json_decode(file_get_contents($blueprintPath));
            array_push($blueprintsContent, $blueprintContent);
        }
        $blueprintsInformation = array_map(
            function ($blueprintsName, $blueprintsContent) {
                return array_merge($blueprintsName, $blueprintsContent);
            }
            , $blueprintsName, $blueprintsContent);
        return JSONObject::encode($blueprintsInformation);
    }

    public static function compile()
    {
        $pathModels = '../models';
        $pathServices = '../services';

        //Delete All models
        $files = glob($pathModels . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        //Delete All services
        $files = glob($pathServices . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        //Generate
        $files = glob(Blueprints::$path . '/*');
        foreach ($files as $file) {
            $className = basename($file, ".json");
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
                . "             'returnDataStartAt' => '" . $blueprint->returnDataStartAt . "'," . "\n"
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
        return true;
    }

    public static function deployServices()
    {
        /*
        $sftp = new Net_SFTP('172.16.224.205');
        if (!$sftp->login('tuxedo', 'tuxedo')) {
            exit('Login Failed');
        }
        */
        /*
        $ftp_server = 'ssh2.sftp://172.16.224.205';
        $ftp_username = 'tuxedo';
        $ftp_userpass = 'tuxedo';
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
        return true;
        */
    }

    public function getJSON()
    {
        return JSONObject::encode(get_object_vars($this));
    }

}