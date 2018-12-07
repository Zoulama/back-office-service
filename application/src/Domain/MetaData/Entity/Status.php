<?php
namespace  Tsi\Domain\MetaData\Entity;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class StatusDependency implements \JsonSerializable
{
    public $name;
    public $status;
    public $url;

    public function __construct(string $name, bool $status, string $url) {
        $this->name = $name;
        $this->status = $status;
        $this->url = $url;
    }

    public function jsonSerialize()
    {
        return [
            'name'         => $this->name,
            'status'       => $this->status ? 1 : 0,
            'url'          => $this->url
        ];
    }
}

class StatusResource implements \JsonSerializable
{
    public $name;
    public $status;

    public function __construct(string $name, bool $status) {
        $this->name = $name;
        $this->status = $status;
    }

    public function jsonSerialize()
    {
        return [
            'name'         => $this->name,
            'status'       => $this->status ? 1 : 0,
        ];
    }
}

class Status implements \JsonSerializable {

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $startDate;

    /**
     * @var string
     */
    private $serviceStatus;

    /**
     * @var array
     */
    private $dependencies;

    /**
     * @var array
     */
    private $resources;

    public function __construct()
    {
        $this->dependencies = array();
        $this->resources = array();
    }

    private function computeStatus ()
    {
        $status = true;

        foreach ($this->resources as $index => $unused)
            $status &= $this->resources[$index]->status;

        foreach ($this->dependencies as $index => $unused)
            $status &= $this->dependencies[$index]->status;

        $this->serviceStatus = $status;
    }

    private function checkUrl ($url) : bool
    {
        try {
            $client = new Client(['base_uri' => $url, 'timeout' => 0.5]);
            $response = $client->request('GET', 'info');
            return ($response->getStatusCode() == 200);
        } catch (\Exception $e) {
            Log::error("Failed to access /info at " . $url . ": " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if a given database connection is up and available.
     * @param $name string name of the Lumen DB connection
     * @return bool
     */
    public static function checkDb ($name) : bool
    {
        try {
            DB::connection($name)->table(DB::raw('DUAL'))->first([DB::raw(1)]);
            return true;
        } catch(\Exception $e) {
            Log::error("Failed to connect to DB " . $name . ": " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if an array of env vars have non-empty values.
     * @param array $envVars array of env variable names
     * @return bool
     */
    public static function checkConfig (array $envVars) : bool
    {
        try {
            $result = true;
            foreach ($envVars as $envVar) {
                $result &= (isset($envVar) && $envVar != null && $envVar != "");
            }
            return $result;
        } catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Add a dependency on a non-service resource (database, file, etc.).
     * Helper static methods are available in this class to check the status of
     * a resource - eg. Status::checkDb
     * @param string $name
     * @param bool status
     */
    public function addResource(string $name, bool $status) {
        $this->resources[] = new StatusResource($name, $status);
    }

    /**
     * Add a dependency on another service compliant with the metadata signature.
     * Status is automatically computed by resolving a call to this service's /info
     * resource.
     * @param string $name
     * @param string $url
     */
    public function addDependency(string $name, string $url) {
        $this->dependencies[] = new StatusDependency($name, $this->checkUrl($url), $url);
    }

    public function jsonSerialize() {
        $this->computeStatus();
        return [
            'service_status'     => $this->serviceStatus ? 1 : 0,
            'resources'          => $this->resources,
            'dependencies'       => $this->dependencies
        ];
    }
}