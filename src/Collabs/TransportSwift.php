<?php

namespace Grace\Collabs;


class TransportSwift {

    protected $server;
    protected $port;
    protected $username;
    protected $password;

    protected $transport;

    public function __construct($server, $username, $password, $port=25){
        $this->server = $server;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;

        $this->transport = \Swift_SmtpTransport::newInstance($server, $port)
            ->setUsername($username)
            ->setPassword($password)
        ;
    }

    public function getTransport(){
        return $this->transport;
    }


} 