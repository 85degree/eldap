<?php
/**
 * ConnectionInterface.php
 * Creator apung apung.dama@gmail.com
 * Create on 11/30/14 1:00 AM
 *
 * Lisence and Term of Conditions, please read README.txt
 */
namespace Apung\Ldap\Connections;
interface ConnectionInterface
{
    function connect();
    //function bind($bind_rdn, $bind_pw);
    function disconnect();
}
