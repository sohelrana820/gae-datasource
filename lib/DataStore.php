<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/26/16
 * Time: 3:30 PM
 */

namespace GoogleDataStore;


class DataStore
{
    public $name = 'DataStore';
    protected $apiKey;
    protected $projectID;
    protected $nameSpace;
    protected $kind;

    protected $client;
    protected $dataSource;
    protected $query;
    protected $request;

    public function __construct($apiKey, $projectID, $nameSpace = 'default')
    {
        $this->apiKey = $apiKey;
        $this->projectID = $projectID;
        $this->nameSpace = $nameSpace;

        $this->client = new \Google_Client();
        $this->client->setDeveloperKey($this->apiKey);
        $this->client->useApplicationDefaultCredentials(true);
        $this->dataSource = new \Google_Service_Datastore($this->client);
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
        $this->setQuery();
        return $this;
    }

    public function setQuery()
    {
        $this->query = new \Google_Service_Datastore_Query([
            'kind' => [
                [
                    'name' => $this->kind,
                ],
            ]
        ]);
        return $this;
    }

    public function sendRequest()
    {
        $this->request = new \Google_Service_Datastore_RunQueryRequest();
        $partitionId = new \Google_Service_Datastore_PartitionId();
        $partitionId->setNamespaceId($this->nameSpace);
        $this->request->setPartitionId($partitionId);
        $this->request->setQuery($this->query);
        return $this;
    }

    public function getResult()
    {
        $response = $this->dataSource->projects->runQuery($this->projectID, $this->request);
        $result = $response->getBatch();
        return $result;
    }
}