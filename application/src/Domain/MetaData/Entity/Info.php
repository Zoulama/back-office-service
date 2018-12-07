<?php
namespace  Tsi\Domain\MetaData\Entity;

class Info implements \JsonSerializable {

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $version;

    /**
     * @var array
     */
    private $dependencies;

    public function __construct()
    {
        $this->dependencies = array();
    }

    /**
     * Set the name and version of the service
     * @param string $name
     * @param string $version
     */
    public function setBaseInfo(string $name, string $version) {
        $this->name = trim($name);
        $this->version = trim($version);
    }

    /**
     * @param string $name
     * @param string $version
     */
    public function addDependency(string $name, string $version) {
        $this->dependencies[] = ['name' => $name, 'version' => $version];
    }

    public function jsonSerialize() {
        return [
            'service'      => ['name' => $this->name, 'version' => $this->version],
            'dependencies' => $this->dependencies
        ];
    }

}