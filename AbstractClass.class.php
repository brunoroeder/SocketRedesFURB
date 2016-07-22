<?php
class AbstractClass
{
    const SERVER = "larc.inf.furb.br";
    const PORT_TCP = 1012;
    const PORT_UDP = 1011;

    const SESSION_STARTED = true;
    const SESSION_NOT_STARTED = false;

    // The state of the session
    private $sessionState = self::SESSION_NOT_STARTED;
    
    // THE only instance of the class
    private static $instance;

    private $socket = null;
  


    public function connect()
    {
        try {
            if ($this->socket == null) {
                $timeout = array('sec'=>1,'usec'=>500000);
                $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
                socket_set_option($this->socket, SOL_SOCKET, SO_RCVTIMEO, $timeout);
                socket_connect($this->socket, self::SERVER, self::PORT_TCP);
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function run($request)
    {
        try {
            socket_send($this->socket, $request, strlen($request), 0);
            $out = socket_read($this->socket, 2048);
            return json_encode($out);
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }

    public function close()
    {
        socket_close($this->socket);
        $this->socket = null;
    }

    public function send($input)
    {
        $this->socket = socket_create(AF_INET, SOCK_DGRAM, 0);
        socket_set_option($this->socket, SOL_SOCKET, SO_BROADCAST, 1);

        socket_sendto($this->socket, $input, strlen($input), 0, self::SERVER, self::PORT_UDP);

    }

    /**
       *    Returns THE instance of 'Session'.
       *    The session is automatically initialized if it wasn't.
       *
       *    @return    object
       **/
      
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
          
        self::$instance->startSession();
          
        return self::$instance;
    }
      
      
       /**
       *    (Re)starts the session.
       *
       *    @return    bool    TRUE if the session has been initialized, else FALSE.
       **/
      
    public function startSession()
    {
        if ($this->sessionState == self::SESSION_NOT_STARTED) {
            $this->sessionState = session_start();
        }
          
        return $this->sessionState;
    }
      
      
       /**
       *    Stores datas in the session.
       *    Example: $instance->foo = 'bar';
       *
       *    @param    name    Name of the datas.
       *    @param    value    Your datas.
       *    @return    void
       **/
      
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }
      
      
       /**
       *    Gets datas from the session.
       *    Example: echo $instance->foo;
       *
       *    @param    name    Name of the datas to get.
       *    @return    mixed    Datas stored in session.
       **/
      
    public function __get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }
      
      
    public function __isset($name)
    {
        return isset($_SESSION[$name]);
    }
      
      
    public function __unset($name)
    {
        unset($_SESSION[$name]);
    }
      
      
       /**
       *    Destroys the current session.
       *
       *    @return    bool    TRUE is session has been deleted, else FALSE.
       **/
      
    public function destroy()
    {
        if ($this->sessionState == self::SESSION_STARTED) {
            $this->sessionState = !session_destroy();
            unset($_SESSION);
              
            return !$this->sessionState;
        }
          
        return false;
    }
}
