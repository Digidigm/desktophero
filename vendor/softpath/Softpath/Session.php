<?php

namespace Softpath;

class Session extends \Slim\Middleware {


    /**
     * @var array
     */
    public $settings = array();
    public static function getInstance(\PDO $pdo, Array $settings = array()) {
        static $_instance = null;
        if ($_instance === null) {
            $_instance = new \Softpath\Session($pdo,$settings);
        }
        return $_instance;
    }

    private function __construct(\PDO $pdo, Array $settings = array()) {
        $this->pdo = $pdo;

        $defaults = array(
            'expires' => '20 minutes',
            'path' => '/',
            'domain' => null,
            'secure' => false,
            'httponly' => false,
            'name' => 'softpath_session',
        );

        $this->settings = array_merge($defaults, $settings);
        if (is_string($this->settings['expires'])) {
        $this->settings['expires'] = strtotime($this->settings['expires']);
        }

        /**
         * Session -- this comes right from the \Slim\SessionCookie class
         *
         * We must start a native PHP session to initialize the $_SESSION superglobal.
         * However, we won't be using the native session store for persistence, so we
         * disable the session cookie and cache limiter. We also set the session
         * handler to this class instance to avoid PHP's native session file locking.
         */
        ini_set('session.use_cookies', 0);
        session_cache_limiter(false);
        session_set_save_handler(
            array($this, 'open'),
            array($this, 'close'),
            array($this, 'read'),
            array($this, 'write'),
            array($this, 'destroy'),
            array($this, 'gc')
        );
    }

    /**
     * Call
     */
    public function call()
    {
        $this->loadSession($this->app->getCookie('softpath_session'));
        $this->next->call();
        $this->saveSession();
    }

    public function get($session_key) {
        return isset($_SESSION[$session_key]) ? $_SESSION[$session_key] : false;
    }

    public function loadSession($session_id = null) {

        // there is no session
        if (session_id() == '') {
            session_start();
            $session_id = $session_id ?: session_id();
        }
        // there is a sesion but no corespon g users table
        if (!is_null($session_id)) {
            $session_query = "SELECT session_data,expires FROM sessions WHERE token = ?";
            $stmt = $this->pdo->prepare($session_query);
            $stmt->execute(array($session_id));
            $session = $stmt->fetch(\PDO::FETCH_ASSOC);
            //if a session was not found create a new one.
            //check that the session hasn't expired.
            if(!$session) {
                $_SESSION = array("TOKEN"=> session_id());
            } else {
                $session_data = unserialize(base64_decode($session['session_data']));
                foreach($session_data as $k => $v) {
                    $_SESSION[$k] = $v;
                }
            }
        }

    }

    /**
     * Store the session in the database.
     */
    public function saveSession() {

        //need to generate expires value from $lifetime and current time.
        if (!isset($_SESSION['token'])) {
            return;//maybe throw an exception here
        }
        $session_id = $_SESSION['token'];
        $user_id = isset($_SESSION['user.id']) ? $_SESSION['user.id'] : 0;
        $session_data = base64_encode(serialize($_SESSION));
        $expire_timestamp = date('Y-m-d',$this->settings['expires']);

        $create_session_query = "INSERT INTO sessions (user_id,token,expires,session_data) VALUES (?,?,FROM_UNIXTIME(?),?);";
        $stmt = $this->pdo->prepare($create_session_query);
        $stmt->execute(array($user_id,$session_id,$expire_timestamp,$session_data));

        $expires = gmstrftime("%A %d-%b-%y %T %Z",$this->settings['expires']);
        $this->app->setCookie('softpath_session', $session_id, $expires);
    }

    public function set($key,$data) {
        $_SESSION[$key] = $data;
    }
  /********************************************************************************
    * Session Handler
    *******************************************************************************/
    /**
     * @codeCoverageIgnore
     */
    public function open($savePath, $sessionName)
    {
        return true;
    }

    /**
     * @codeCoverageIgnore
     */
    public function close()
    {
        return true;
    }
    /**
     * @codeCoverageIgnore
     */
    public function read($id)
    {
        return '';
    }
    /**
     * @codeCoverageIgnore
     */
    public function write($id, $data)
    {
        return true;
    }
    /**
     * @codeCoverageIgnore
     */
    public function destroy($id)
    {
        return true;
    }
    /**
     * @codeCoverageIgnore
     */
    public function gc($maxlifetime)
    {
        return true;
    }
}
