<?php

namespace radzserg\BoxContent;

use Exception;

/**
 * Provides access to the Box Content API.
 * @see - https://docs.box.com/reference#file-object
 *
 *
 * @property User $user
 * @property Document $document
 * @property Token $token
 */
class Client
{

    const OBTAIN_TOKEN_URL = 'https://api.box.com/oauth2/token';


    /**
     * Keep authorize token config
     * @var array
     */
    private $tokenConfig = [];

    /**
     * The request handler.
     * @var Request
     */
    private $requestHandler;



    public function __construct($config)
    {
        $requiredFields = ['clientId', 'secretId', 'publicKeyId', 'privateCertPath', 'certPassword'];
        foreach ($requiredFields as $field) {
            if (empty($config[$field])) {
                throw  new BoxContentException("Required field {$field} is not set");
            } else {
                $this->tokenConfig[$field] = $config[$field];
            }
        }
        $optionalFields = ['enterpriseId', 'boxUserId', 'appTokenCachePath', 'userTokenCachePath'];
        foreach ($optionalFields as $field) {
            if (!empty($config[$field])) {
                $this->tokenConfig[$field] = $config[$field];
            }
        }
    }

    public function __get($name)
    {
        if ($name == 'user') {
            return new User($this);
        } elseif ($name == 'document') {
            return new Document($this);
        } elseif ($name == 'token') {
            return new Token($this->tokenConfig);
        }
    }

    /**
     * @param bool $userUserToken
     * @return Request
     * @throws BoxContentException
     */
    public function getRequestHandler($userUserToken = true)
    {
        $type = $userUserToken ? Token::SUBTYPE_USER : Token::SUBTYPE_ENTERPRISE;
        $accessToken = $this->token->getAccessToken($type);
        if (!isset($this->requestHandler)) {
            $this->setRequestHandler(new Request($accessToken));
        } else {
            $this->requestHandler->setAccessToken($accessToken);
        }
        
        return $this->requestHandler;
    }


    /**
     * Set the request handler.
     *
     * @param Request $requestHandler The request handler.
     *
     * @return void
     */
    public function setRequestHandler($requestHandler)
    {
        $this->requestHandler = $requestHandler;
    }

    // DOCUMENTS

    /**
     * Get a list of all documents that meet the provided criteria.
     *
     * @param array|null $params Optional. An associative array to filter the
     *                           list of all documents uploaded. None are
     *                           necessary; all are optional. Use the following
     *                           options:
     *                             - int|null 'limit' The number of documents to
     *                               return.
     *                             - string|DateTime|null 'createdBefore' Upper
     *                               date limit to filter by.
     *                             - string|DateTime|null 'createdAfter' Lower
     *                               date limit to filter by.
     *
     * @return array An array containing document instances matching the
     *               request.
     * @throws BoxContentException
     */
    public function findDocuments($params = [])
    {
        return Document::find($this, $params);
    }

    /**
     * Create a new document instance by ID, and load it with values requested
     * from the API.
     *
     * @param string $id The document ID.
     *
     * @param array $fields - array of field to return
     * @return Document A document instance using data from the API.
     */
    public function getDocument($id, $fields = [])
    {
        return Document::get($this, $id, $fields);
    }

    /**
     * Upload a local file and return a new document instance.
     *
     * @param resource $file The file resource to upload.
     * @param array|null $params Optional. An associative array of options
     *                           relating to the file upload. None are
     *                           necessary; all are optional. Use the following
     *                           options:
     *                             - string|null 'name' Override the filename of
     *                               the file being uploaded.
     *                             - string[]|string|null 'thumbnails' An array
     *                               of dimensions in pixels, with each
     *                               dimension formatted as [width]x[height],
     *                               this can also be a comma-separated string.
     *                             - bool|null 'nonSvg' Create a second version
     *                               of the file that doesn't use SVG, for users
     *                               with browsers that don't support SVG?
     *
     * @return Document A new document instance.
     * @throws BoxContentException
     */
    public function uploadFile($file, $params = [])
    {
        return Document::uploadFile($this, $file, $params);
    }


}
