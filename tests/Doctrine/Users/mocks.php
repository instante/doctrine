<?php
namespace Instante\Tests\Doctrine\Users;

use Doctrine\Common\Persistence\ObjectRepository;
use Instante\Doctrine\Users\User;
use Nette\Http\FileUpload;
use Nette\Http\IRequest;
use Nette\Http\IResponse;
use Nette\Http\Session;
use Nette\Http\Url;
use Nette\Http\UrlScript;
use Nette\NotImplementedException;
use Nette\UnexpectedValueException;
use SessionHandlerInterface;

class MockSessionRequest implements IRequest
{

    /**
     * Returns URL object.
     * @return UrlScript
     */
    function getUrl()
    {
        // TODO: Implement getUrl() method.
    }

    /**
     * Returns variable provided to the script via URL query ($_GET).
     * If no key is passed, returns the entire array.
     * @param  string key
     * @param  mixed  default value
     * @return mixed
     */
    function getQuery($key = NULL, $default = NULL)
    {
        // TODO: Implement getQuery() method.
    }

    /**
     * Returns variable provided to the script via POST method ($_POST).
     * If no key is passed, returns the entire array.
     * @param  string key
     * @param  mixed  default value
     * @return mixed
     */
    function getPost($key = NULL, $default = NULL)
    {
        // TODO: Implement getPost() method.
    }

    /**
     * Returns uploaded file.
     * @param  string key
     * @return FileUpload|NULL
     */
    function getFile($key)
    {
        // TODO: Implement getFile() method.
    }

    /**
     * Returns uploaded files.
     * @return array
     */
    function getFiles()
    {
        // TODO: Implement getFiles() method.
    }

    /**
     * Returns variable provided to the script via HTTP cookies.
     * @param  string key
     * @param  mixed  default value
     * @return mixed
     */
    function getCookie($key, $default = NULL)
    {
        if ($key === 'nette-browser') return '1234567890';
        if ($key === 'test-session-id') return 'ABCDEFGH';
        throw new UnexpectedValueException("Unexpected cookie key $key needed for session");
    }

    /**
     * Returns variables provided to the script via HTTP cookies.
     * @return array
     */
    function getCookies()
    {
        // TODO: Implement getCookies() method.
    }

    /**
     * Returns HTTP request method (GET, POST, HEAD, PUT, ...). The method is case-sensitive.
     * @return string
     */
    function getMethod()
    {
        // TODO: Implement getMethod() method.
    }

    /**
     * Checks HTTP request method.
     * @param  string
     * @return bool
     */
    function isMethod($method)
    {
        // TODO: Implement isMethod() method.
    }

    /**
     * Return the value of the HTTP header. Pass the header name as the
     * plain, HTTP-specified header name (e.g. 'Accept-Encoding').
     * @param  string
     * @param  mixed
     * @return mixed
     */
    function getHeader($header, $default = NULL)
    {
        // TODO: Implement getHeader() method.
    }

    /**
     * Returns all HTTP headers.
     * @return array
     */
    function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }

    /**
     * Is the request is sent via secure channel (https).
     * @return bool
     */
    function isSecured()
    {
        // TODO: Implement isSecured() method.
    }

    /**
     * Is AJAX request?
     * @return bool
     */
    function isAjax()
    {
        // TODO: Implement isAjax() method.
    }

    /**
     * Returns the IP address of the remote client.
     * @return string|NULL
     */
    function getRemoteAddress()
    {
        // TODO: Implement getRemoteAddress() method.
    }

    /**
     * Returns the host of the remote client.
     * @return string|NULL
     */
    function getRemoteHost()
    {
        // TODO: Implement getRemoteHost() method.
    }

    /**
     * Returns raw content of HTTP request body.
     * @return string|NULL
     */
    function getRawBody()
    {
        // TODO: Implement getRawBody() method.
    }
}

class MockSessionResponse implements IResponse
{

    /**
     * Sets HTTP response code.
     * @param  int
     * @return void
     */
    function setCode($code)
    {
        // TODO: Implement setCode() method.
    }

    /**
     * Returns HTTP response code.
     * @return int
     */
    function getCode()
    {
        // TODO: Implement getCode() method.
    }

    /**
     * Sends a HTTP header and replaces a previous one.
     * @param  string  header name
     * @param  string  header value
     * @return void
     */
    function setHeader($name, $value)
    {
        // TODO: Implement setHeader() method.
    }

    /**
     * Adds HTTP header.
     * @param  string  header name
     * @param  string  header value
     * @return void
     */
    function addHeader($name, $value)
    {
        // TODO: Implement addHeader() method.
    }

    /**
     * Sends a Content-type HTTP header.
     * @param  string  mime-type
     * @param  string  charset
     * @return void
     */
    function setContentType($type, $charset = NULL)
    {
        // TODO: Implement setContentType() method.
    }

    /**
     * Redirects to a new URL.
     * @param  string  URL
     * @param  int     HTTP code
     * @return void
     */
    function redirect($url, $code = self::S302_FOUND)
    {
        // TODO: Implement redirect() method.
    }

    /**
     * Sets the number of seconds before a page cached on a browser expires.
     * @param  string|int|\DateTime time , value 0 means "until the browser is closed"
     * @return void
     */
    function setExpiration($seconds)
    {
        // TODO: Implement setExpiration() method.
    }

    /**
     * Checks if headers have been sent.
     * @return bool
     */
    function isSent()
    {
        // TODO: Implement isSent() method.
    }

    /**
     * Returns value of an HTTP header.
     * @param  string
     * @param  mixed
     * @return mixed
     */
    function getHeader($header, $default = NULL)
    {
        // TODO: Implement getHeader() method.
    }

    /**
     * Returns a list of headers to sent.
     * @return array (name => value)
     */
    function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }

    /**
     * Sends a cookie.
     * @param  string name of the cookie
     * @param  string value
     * @param  mixed expiration as unix timestamp or number of seconds; Value 0 means "until the browser is closed"
     * @param  string
     * @param  string
     * @param  bool
     * @param  bool
     * @return void
     */
    function setCookie($name, $value, $expire, $path = NULL, $domain = NULL, $secure = NULL, $httpOnly = NULL)
    {
        // TODO: Implement setCookie() method.
    }

    /**
     * Deletes a cookie.
     * @param  string name of the cookie.
     * @param  string
     * @param  string
     * @param  bool
     * @return void
     */
    function deleteCookie($name, $path = NULL, $domain = NULL, $secure = NULL)
    {
        // TODO: Implement deleteCookie() method.
    }
}

class MockSessionHandler implements SessionHandlerInterface
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function close()
    {
        return TRUE;
    }

    public function destroy($session_id)
    {
        $this->data = NULL;
        return TRUE;
    }

    public function gc($maxlifetime)
    {
        return TRUE;
    }

    public function open($save_path, $session_id)
    {
        return TRUE;
    }

    public function read($session_id)
    {
        return $this->data;
    }

    public function write($session_id, $session_data)
    {
        $this->data = $session_data;
        return TRUE;
    }
}

class MockSession extends Session
{
    public function regenerateId()
    {
        //suppress call to avoid PHP7 error
    }

}

class MockSessionFactory
{
    static function create($data = NULL)
    {
        session_save_path('.');
        $session = new MockSession(new MockSessionRequest, new MockSessionResponse);
        $session->setHandler(new MockSessionHandler($data));
        $session->setName('test-session-id');
        $session->start();
        return $session;
    }
}

class MockUser extends User
{
}

class FakeUserRepository implements ObjectRepository
{
    public $users = [];

    public function find($id)
    {
        return isset($this->users[$id]) ? $this->users[$id] : NULL;
    }

    public function findAll()
    {
        return $this->users;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        throw new NotImplementedException;
    }

    public function findOneBy(array $criteria)
    {
        $mu = new MockUser('user', 'pwd');
        if (isset($criteria['email']) && $criteria['email'] === 'john.doe@example.com') {
            return $mu;
        }
        if (isset($criteria['name'])) {
            switch ($criteria['name']) {
                case 'inact':
                    $mu->setActive(FALSE);
                case 'user': //intentional fallthru
                    return $mu;
                default:
                    return NULL;
            }
        }
    }

    public function getClassName()
    {
        return User::class;
    }
}
