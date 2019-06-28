<?php

namespace radzserg\BoxContent;


/**
 * Acts as a base class for the different Box View APIs.
 */
abstract class BaseEntity
{

    /**
     * The client instance to make requests from.
     * @var Client
     */
    protected $client;


    /**
     * Base path for entity
     * @var string
     */
    protected $path;

    /**
     * The document ID.
     * @var string
     */
    protected $id;

    /**
     * The document metadata.
     * @var array
     */
    private $data;



    public function __construct($client, $data = [])
    {
        $this->client = $client;

        $this->setData($data);
    }

    /**
     * Return document data
     * @param $key
     * @return mixed|null
     */
    public function getData($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /**
     * Get the document ID.
     *
     * @return string The document ID.
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Set data for current entity
     * @param $data
     */
    private function setData($data)
    {
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->data = $data;
    }

    /**
     * @param array $params
     * @return BaseEntity
     */
    public function create($params = [])
    {
        $metadata = $this->client->getRequestHandler(false)->send($this->path, null, $params);

        return new static($this->client, $metadata);
    }


    /**
     * Get entity     
     * @param $id
     * @param array $fields
     * @return BaseEntity
     */
    public function get($id, $fields = [])
    {
        $getParams = [];
        if (!empty($fields)) {
            $getParams['fields'] = implode(',', $fields);
        }
        $metadata = $this->client->getRequestHandler()->send($this->path . '/' . $id, $getParams);

        return new static($this->client, $metadata);
    }


}
