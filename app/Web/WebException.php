<?php

namespace App\Web;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ApiException
 * @package App\Api
 */
class AdminException extends HttpException
{

    /**
     * ApiException constructor.
     * @param string $message
     * @param int $code
     * @param int $statusCode
     * @param \Exception|null $previous
     * @param array $headers
     */
    public function __construct($message = "Web Exception", $code = 0, $statusCode = 500, \Exception $previous = null, array $headers = array())
    {

        $headers['Exception-Type'] = 'Web Exception';
        $headers['Generated-By'] = 'Laravel Web Handler';
        parent::__construct($statusCode, $message, $previous, $headers, $code);

    }

}
