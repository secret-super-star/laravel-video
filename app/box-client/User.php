<?php

namespace radzserg\BoxContent;

/**
 * Provide access to the Box View Document API. The Document API is used for
 * uploading, checking status, and deleting documents.
 */
class User extends BaseEntity
{

    protected $path = '/users';


    /**
     * Used to provision a new user in an enterprise. This method only works for enterprise admins.
     *
     * @param array $params
     *  login string REQUIRED The email address this user uses to login
     *  name string REQUIRED The name of this user
     *  role string This user’s enterprise role. Can be coadmin or user
     *  language string The language of this user
     *  is_sync_enabled boolean Whether or not this user can use Box Sync
     *  job_title string The user’s job title
     *  phone string The user’s phone number
     *  address string The user’s address
     *  space_amount integer The user’s total available space amount in bytes
     *  tracking_codes array of mixed An array of key/value pairs set by the user’s admin
     *  can_see_managed_users string Can be active, inactive, cannot_delete_edit, or cannot_delete_edit_upload.
     *  timezone string The timezone of this user
     *  is_exempt_from_device_limits boolean Whether to exempt this user from Enterprise device limits
     *  is_exempt_from_login_verification boolean Whether or not this user must use two-factor authentication
     * @return BaseEntity
     */
    public function create($params = [])
    {
        $metadata = $this->client->getRequestHandler(false)->send($this->path, null, $params);

        return new static($this->client, $metadata);
    }

    /**
     * Creates platform user
     * @param $userParams
     * @return static
     */
    public function createPlatformUser($userParams)
    {
        $userParams['is_platform_access_only'] = true;
        $metadata = $this->client->getRequestHandler(false)->send($this->path, null, $userParams);

        return new static($this->client, $metadata);
    }

    /**
     * Return enterprise users
     * @param null $filterTerm - A string used to filter the results to only users starting with the filter_term
     *  in either the name or the login.
     * @param null $limit - The number of records to return. The default is 100 and the max is 1000.
     * @param null $offset - The record at which to start. The default is 0.
     * @param null $userType - The type of user to search for. Valid values are all, external or managed. If nothing
     *  is provided, the default behavior will be managed only
     * @return array
     */
    public function enterpriseUsers($filterTerm = null, $limit = null, $offset = null, $userType = null)
    {
        $usersMetadata = $this->client->getRequestHandler(false)->send($this->path, [
            'filter_tern' => $filterTerm,
            'limit' => $limit,
            'offset' => $offset,
            'user_type' => $userType
        ]);

        $users = [];
        if (!empty($usersMetadata['entries'])) {
            foreach ($usersMetadata['entries'] as $metadata) {
                $users[] = new static($this->client, $metadata);
            }
        }

        return $users;
    }


    /**
     * Retrieves information about the user who is currently logged in i.e.
     * the user for whom this auth token was generated.
     * @return static
     */
    public function me()
    {
        $metadata = $this->client->getRequestHandler(false)->send($this->path . '/me');

        return new static($this->client, $metadata);
    }

}
