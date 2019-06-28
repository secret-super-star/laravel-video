<?php

namespace radzserg\BoxContent;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Psr\Http\Message\ResponseInterface;

/**
 * Makes a request to the Box View API.
 */
class Request
{
    /**
     * Request error codes.
     * @const string
     */
    const BAD_REQUEST_ERROR = 'bad_request';
    const GUZZLE_ERROR = 'guzzle_error';
    const JSON_RESPONSE_ERROR = 'server_response_not_valid_json';
    const METHOD_NOT_ALLOWED_ERROR = 'method_not_allowed';
    const NOT_FOUND_ERROR = 'not_found';
    const REQUEST_TIMEOUT_ERROR = 'request_timeout';
    const SERVER_ERROR = 'server_error';
    const TOO_MANY_REQUESTS_ERROR = 'too_many_requests';
    const UNAUTHORIZED_ERROR = 'unauthorized';
    const UNSUPPORTED_MEDIA_TYPE_ERROR = 'unsupported_media_type';

    /**
     * The default protocol (Box View uses HTTPS).
     * @const string
     */
    const PROTOCOL = 'https';

    /**
     * The default host.
     * @const string
     */
    const HOST = 'api.box.com';

    /**
     * The default base path on the server where the API lives.
     * @const string
     */
    const BASE_PATH = '/2.0';


    public static $defaultOptions = [
        'absolute_timeout' => 62    // The number of seconds before timing out when in a retry loop.
    ];


    /**
     * A good set of default Guzzle options.
     * @var array
     */
    public static $guzzleDefaultOptions = [
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => null,
            'User-Agent' => 'box-content-php',
        ],
        'connect_timeout' => 10,
        'timeout' => 60,
    ];

    /**
     * The access token.
     * @var string
     */
    private $accessToken = null;

    /**
     * The timestamp of the last request.
     * @var string
     */
    private $timestampRequested;

    /**
     * Set the API key.
     *
     * @param string $accessToken The API key.
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Set access token
     * @param $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Send an HTTP request.
     *
     * @param string $path The path to add after the base path.
     * @param array|null $getParams Optional. An associative array of GET params
     *                              to be added to the URL.
     * @param array|null $postParams Optional. An associative array of POST
     *                               params to be sent in the body.
     * @param array|null $requestOptions Optional. An associative array of
     *                                   request options that may modify the way
     *                                   the request is made.
     *
     * @return array|string The response array is usually converted from JSON,
     *                      but sometimes we just return the raw response from
     *                      the server.
     * @throws BoxContentException
     */
    public function send(
        $path,
        $getParams = [],
        $postParams = [],
        $requestOptions = []
    )
    {
        $host = null;
        if (isset($requestOptions['host'])) {
            $host = $requestOptions['host'];
        }
        if (isset($requestOptions['basePath'])) {
            $basePath = $requestOptions['basePath'];
        } else {
            $basePath = static::BASE_PATH;
        }

        $url = $basePath . $path;

        $guzzle = $this->getGuzzleInstance($host);

        $options = ['headers' => []];
        $method = 'GET';

        if (!empty($requestOptions['file'])) {
            $method = 'POST';
            $options['multipart'] = [
                ['name' => 'file', 'contents' =>  $requestOptions['file']]
            ];
            if ($postParams) {
                foreach ($postParams as $k => $v) {
                    $options['multipart'][] = ['name' => $k, 'contents' => $v];
                }
            }
        } elseif (!empty($postParams)) {
            $method = 'POST';
            $options['json'] = $postParams;
        }

        if (!empty($requestOptions['httpMethod'])) {
            $method = $requestOptions['httpMethod'];
        }

        if (!empty($requestOptions['rawResponse'])) {
            $options['headers']['Accept'] = '*/*';
        }


        if (!empty($getParams)) {
            $options['query'] = $getParams;
        }

        $absoluteTimeout = !empty($requestOptions['timeout'])
            ? $requestOptions['timeout']
            : static::$defaultOptions['absolute_timeout'];
        $this->timestampRequested = time();

        try {
            $request = new GuzzleRequest($method, $url);
            $response = $this->execute($guzzle, $request, $options, $absoluteTimeout);
        } catch (RequestException $e) {
            static::handleRequestError($e);
        }

        $isRawResponse = !empty($requestOptions['rawResponse']);
        return static::handleResponse($response, $isRawResponse, $request);
    }

    /**
     * Handle an error. We handle errors by throwing an exception.
     *
     * @param string $error An error code representing the error
     *                      (use_underscore_separators).
     * @param string|null $message The error message.
     * @param GuzzleRequest|null $request Optional. The Guzzle request object.
     * @param ResponseInterface|null $response Optional. The Guzzle response object.
     *
     * @return void
     * @throws BoxContentException
     */
    protected static function error(
        $error,
        $message = null,
        $request = null,
        $response = null
    )
    {
        if (!empty($request)) {
            $message .= "\n";
            $message .= 'Method: ' . $request->getMethod() . "\n";
            $message .= 'URL: ' . $request->getUri() . "\n";
            $message .= 'Headers: ' . json_encode($request->getHeaders()) . "\n";
            $message .= 'Request Body: ' . $request->getBody() . "\n";
        }

        if (!empty($response)) {
            $message .= "\n";
            $message .= 'Response Body: ' . $response->getBody() . "\n";
        }

        $exception = new BoxContentException($message);
        $exception->errorCode = $error;
        throw $exception;
    }


    /**
     * Execute a request to the server and return the response, while retrying
     * based on any Retry-After headers that are sent back.
     * @param GuzzleClient $guzzle
     * @param GuzzleRequest $request
     * @param array $options
     * @param int $absoluteTimeout
     * @return ResponseInterface
     * @throws BoxContentException
     */
    private function execute($guzzle, $request, $options, $absoluteTimeout)
    {
        /** @var \Psr\Http\Message\ResponseInterface $response */
        $response = $guzzle->send($request, $options);

        $headers = $response->getHeaders();

        if (!empty($headers['Retry-After'])) {
            $seconds = round(time() - $this->timestampRequested);

            if ($absoluteTimeout > 0 && $seconds >= $absoluteTimeout) {
                $message = 'The request timed out after retrying for '
                    . $seconds . ' seconds.';
                static::error(
                    static::REQUEST_TIMEOUT_ERROR,
                    $message,
                    $request,
                    $response
                );
            }

            sleep($headers['Retry-After'][0]);
            return $this->execute($guzzle, $request, $options, $absoluteTimeout);
        }

        return $response;
    }

    /**
     * Get a new Guzzle instance using sensible defaults.
     *
     * @param string|null $host Optional. The host to use in the base URL.
     *
     * @return GuzzleClient A new Guzzle instance.
     */
    private function getGuzzleInstance($host = null)
    {
        if (!$host) {
            $host = static::HOST;
        }

        $defaults = static::$guzzleDefaultOptions;
        $defaults['headers']['Authorization'] = 'Bearer ' . $this->accessToken;
        $defaults['base_uri'] = static::PROTOCOL . '://' . $host;

        return new GuzzleClient($defaults);
    }

    /**
     * Check if there is an HTTP error, and returns a brief error description if
     * there is.
     *
     * @param string $httpCode The HTTP code returned by the API server.
     *
     * @return string|null Brief error description.
     */
    private static function handleHttpError($httpCode)
    {
        $http4xxErrorCodes = [
            400 => static::BAD_REQUEST_ERROR,
            401 => static::UNAUTHORIZED_ERROR,
            404 => static::NOT_FOUND_ERROR,
            405 => static::METHOD_NOT_ALLOWED_ERROR,
            415 => static::UNSUPPORTED_MEDIA_TYPE_ERROR,
            429 => static::TOO_MANY_REQUESTS_ERROR,
        ];

        if (isset($http4xxErrorCodes[$httpCode])) {
            return $http4xxErrorCodes[$httpCode];
        }

        if ($httpCode >= 500 && $httpCode < 600) {
            return static::SERVER_ERROR;
        }

        return null;
    }

    /**
     * Handle a request error from Guzzle.
     *
     * @param \GuzzleHttp\Exception\RequestException e The Guzzle request error.
     *
     * @return void
     * @throws BoxContentException
     */
    private static function handleRequestError($e)
    {
        $request = $e->getRequest();
        $response = $e->getResponse();

        // check for error embedded in json
        // check for error embedded in json
        if ($response) {
            static::handleResponse($response, true, $request);
        }

        // no error embedded in json, so proceed

        $error = null;
        $message = 'Server error';

        if ($response !== null) {
            $error = static::handleHttpError($response->getStatusCode());
        }

        if (!$error) {
            $error = static::GUZZLE_ERROR;
            $message = 'Guzzle error: ' . $e->getMessage();
        }

        static::error($error, $message, $request, $response);
    }

    /**
     * Handle the response from the server. Raw responses are returned without
     * checking anything. JSON responses are decoded and then checked for
     * any errors.
     *
     * @param ResponseInterface $response The Guzzle
     *                                              response object.
     * @param bool $isRawResponse Do we want to return the raw response, or
     *                            process as JSON?
     * @param RequestInterface The Guzzle request object.
     *
     * @return array|string An array decoded from JSON, or the raw response from
     *                      the server.
     * @throws BoxContentException
     */
    private static function handleResponse($response, $isRawResponse, $request)
    {
        $responseBody = (string)$response->getBody();

        // decode json and handle any potential errors
        $jsonDecoded = json_decode($responseBody, true);

        if (
            !$isRawResponse
            && ($jsonDecoded === false || $jsonDecoded === null)
        ) {
            return static::error(
                static::JSON_RESPONSE_ERROR,
                null,
                $request,
                $response
            );
        }

        if (
            // if we have an array
            is_array($jsonDecoded)
            // with status=error or type=error
            && (
                (isset($jsonDecoded['status'])
                    && $jsonDecoded['status'] == 'error')
                || (isset($jsonDecoded['type'])
                    && $jsonDecoded['type'] == 'error')
            )
            // and an error_message or message
            && (isset($jsonDecoded['error_message'])
                || isset($jsonDecoded['message']))
        ) {
            $message = isset($jsonDecoded['error_message'])
                ? $jsonDecoded['error_message']
                : $jsonDecoded['message'];
            return static::error(
                static::SERVER_ERROR,
                $message,
                $request,
                $response
            );
        }

        if ($isRawResponse) {
            return $responseBody;
        } else {
            return $jsonDecoded;
        }
    }
}
