<?php

namespace radzserg\BoxContent;

/**
 * Provide access to the Box Content Document API. The Document API is used for
 * uploading, checking status, and deleting documents.
 *
 * @method Document get($id, $fields = [])
 */
class Document extends BaseEntity
{
    /**
     * Document error codes.
     * @const string
     */
    const INVALID_FILE_ERROR = 'invalid_file';
    const INVALID_RESPONSE_ERROR = 'invalid_response';

    /**
     * An alternate hostname that file upload requests are sent to.
     * @const string
     */
    const FILE_UPLOAD_HOST = 'upload.box.com';

    /**
     * The Document API path relative to the base API path.
     * @var string
     */
    protected $path = '/files';


    /**
     * Download a thumbnail of a specific size for a file.
     *
     * @param int $width The width of the thumbnail in pixels.
     * @param int $height The height of the thumbnail in pixels.
     *
     * @param string $ext
     * @return string The contents of the downloaded thumbnail.
     */

    /**
     * Retrieves a thumbnail, or smaller image representation, of this file. Sizes of 32x32,
     * 64x64, 128x128, and 256x256 can be returned in the .png format and sizes of 32x32, 94x94, 160x160, and 320x320
     * can be returned in the .jpg format. Thumbnails can be generated for the image and video file formats.
     * @param string $ext
     * @param $options
     *      - min_height - The minimum height of the thumbnail
     *      - min width - The minimum width of the thumbnail
     *      - max height - The maximum height of the thumbnail
     *      - max width - The maximum width of the thumbnail
     * @return mixed
     */
    public function thumbnail($ext = 'png', $options)
    {
        $path = "{$this->path}/{$this->id}/thumbnail.{$ext}" ;

        return $this->client->getRequestHandler()->send($path, $options, null, [
            'rawResponse' => true
        ]);
    }

    /**
     * Use the Uploads API to allow users to add a new file. The user can then upload a file by specifying the
     * destination folder for the file. If the user provides a file name that already exists in the destination folder,
     * the user will receive an error.
     *
     * A different Box URL, https://upload.box.com/api/2.0/files/content, handles uploads. This API uses the multipart
     * post method to complete all upload tasks. You can optionally specify a Content-MD5 header with the SHA1 hash of
     * the file to ensure that the file is not corrupted in transit.
     * @param resource $file The file resource to upload.
     * @param array $params
     *  - Content-MD5 string The SHA1 hash of the file
     *  - attributes object REQUIRED
     * File attributes:
     *  - name string REQUIRED Name of the file
     *  - parent object REQUIRED Folder object being uploaded into
     *  - id string REQUIRED Child of parent. Designates folder_id of parent object. Use 0 for the root folder.
     *  - content_created_at timestamp See content times for formatting
     *  - content_modified_at timestamp See content times for formatting
     * @return static
     */
    public function uploadFile($file, $params = [])
    {
        if (!is_resource($file)) {
            $message = '$file is not a valid file resource.';
            return static::error(static::INVALID_FILE_ERROR, $message);
        }

        $metadata = $this->client->getRequestHandler()->send('/api/2.0/files/content', null, $params, [
            'file' => $file,
            'host' => static::FILE_UPLOAD_HOST,
            'basePath' => ''
        ]);

        return new static($this->client, $metadata['entries'][0]);
    }

}
