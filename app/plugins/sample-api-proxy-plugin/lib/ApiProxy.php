<?php

namespace Sample;

//Load .env environment variables
require_once( __DIR__ . '/../../../../vendor/autoload.php');
$dotenv = new \Dotenv\Dotenv(__DIR__.'/../../../../');
$dotenv->load();

class ApiProxy
{
    private $apiPath;
    private $apiKey;
    private $recordsPerBatch;

    public function __construct()
    {
        $this->apiPath = getenv('SAMPLE_API_PATH');
        $this->apiKey = getenv('SAMPLE_API_KEY');
        $this->recordsPerBatch = getenv('SAMPLE_BATCH_SIZE');
    }

    public function querySample()
    {
        // Construct the web service query
        $webseviceQuery = 'posts?key='.$this->apiKey.'&size='.$this->recordsPerBatch;
        return $this->queryWebservice($webseviceQuery);
    }

    public function queryProductsNextBatch($batchNumber)
    {
        // Construct the web service query
        $webseviceQuery = 'posts?key='.$this->apiKey.'&size='.$this->recordsPerBatch;
        $webseviceQuery .= '&page='.$batchNumber;

        return $this->queryWebservice($webseviceQuery);
    }

    public function getSingle($sampleId)
    {
        $webseviceQuery = 'posts/' . $sampleId . '?key='.$this->apiKey;
        return $this->queryWebservice($webseviceQuery);
    }


    function queryWebservice($webseviceQuery)
    {
        $webserviceUrl = str_replace(' ', '%20', $this->apiPath.'/'.$webseviceQuery);
        $result = @file_get_contents($webserviceUrl);
        if ($result === false) {
            return false;
        }
        return json_decode($result, true);
    }

    public function getRecordsPerBatch()
    {
        return $this->recordsPerBatch;
    }
}
