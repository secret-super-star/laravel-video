<?php

namespace radzserg\BoxContent;

use Exception;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Builder;
use GuzzleHttp\Client as GuzzleClient;

/**
 * Provides access to the Box Content API.
 * @see - https://docs.box.com/reference#file-object
 */
class Token
{

    const OBTAIN_TOKEN_URL = 'https://api.box.com/oauth2/token';

    const SUBTYPE_ENTERPRISE = 'enterprise';
    const SUBTYPE_USER = 'user';

    /**
     * Box application client ID
     * @var string
     */
    private $clientId;

    /**
     * Box application secret ID
     * @var string
     */
    private $secretId;

    /**
     * Box application public key ID
     * @var string
     */
    private $publicKeyId;

    /**
     * Box enterprise ID
     * @var - string
     */
    private $enterpriseId;

    /**
     * Box user ID
     * @var - string
     */
    private $boxUserId;

    /**
     * A path to private certificate generated for JWT
     * @var string
     */
    private $privateCertPath;

    /**
     * Cache file path to store app access token
     * @var null
     */
    private $appTokenCachePath = null;

    /**
     * Cache file path to store user access token
     * @var null
     */
    private $userTokenCachePath = null;

    /**
     * Password for certificate
     * @var - string
     */
    private $certPassword = null;


    /**
     * Token constructor.
     * @param $config
     */
    public function __construct($config)
    {
        foreach ($config as $field => $value) {
            if (property_exists($this, $field)) {
                $this->$field = $value;
            }
        }
    }


    /**
     * Return access token
     * @return null
     * @throws BoxContentException
     */
    public function getAccessToken($type)
    {
        if ($type == static::SUBTYPE_ENTERPRISE) {
            $cachePath = $this->appTokenCachePath;
            $subject = $this->enterpriseId;
        } else {
            $cachePath = $this->userTokenCachePath;
            $subject = $this->boxUserId;
        }
        //$publicKeyId, $clientId, $secretId, $subject, $boxSubType, $privateCertPath, $certPassword, $accessTokenCachePath = null
        if ($cachePath && file_exists($cachePath)) {
            $token = @file_get_contents($cachePath);
            if ($token) {
                $token = json_decode($token, true);
                if ($token['expires_at'] > time()) {
                    return $token['access_token'];
                }
            }
        }

        $signer = new Sha256();
        $jwt = (new Builder())
            ->setHeader('alg', 'RS256')
            ->setHeader('typ', 'JWT')
            ->setHeader('kid', $this->publicKeyId)
            ->setIssuer($this->clientId)
            ->setAudience(static::OBTAIN_TOKEN_URL)
            ->setSubject($subject)
            ->set('box_sub_type', $type)
            ->setId(uniqid() . uniqid())
            ->setExpiration(time() + 30)
            ->sign($signer, new Key("file://{$this->privateCertPath}", $this->certPassword)) // creates a signature using your private key
            ->getToken();

        $assertion = (string)$jwt;

        $token = null;
        try {
            $guzzle = new GuzzleClient();
            $response = $guzzle->post(static::OBTAIN_TOKEN_URL, [
                'form_params' => [
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                    'assertion' => $assertion,
                    'client_id' => $this->clientId,
                    'client_secret' => $this->secretId
                ]
            ]);

            $token = json_decode($response->getBody(), true);
        } catch (Exception $e) {
            throw new BoxContentException("Cannot obtain access token. Details: " . $e->getMessage());
        }

        if (!$token) {
            return null;
        }

        $accessToken = $token['access_token'];
        $expiresAt = time() + $token['expires_in'] - 5;

        if ($cachePath) {
            $dirPath = dirname($cachePath);
            if (!is_dir($dirPath)) {
                mkdir($dirPath, 0777, true);
            }
            if (!@file_put_contents($cachePath, json_encode([
                'access_token' => $accessToken,
                'expires_at' => $expiresAt
            ]))) {
                throw new BoxContentException("Cannot save access token to cache file.");
            }
            @chmod($cachePath, 0666);
        }

        return $accessToken;
    }
}
