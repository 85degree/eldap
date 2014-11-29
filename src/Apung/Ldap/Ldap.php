<?php
/**
 * Ldap.php
 * Creator apung apung.dama@gmail.com
 * Create on 11/30/14 12:56 AM
 *
 * Lisence and Term of Conditions, please read README.txt
 */
namespace Apung\Ldap;
use Apung\Ldap\Connections\ConnectionInterface;
use Apung\Ldap\LdapAbstracts\LdapAbstract;
class Ldap
    extends LdapAbstract

    implements ConnectionInterface
{
    protected $connection;
    protected $host;
    protected $port;
    protected $bind_rdn;
    protected $bind_pw;
    protected $base_dn;
    protected $ldapversion;
    /**
     * @param array $config
     * @example
     */
    function __construct(array $config){
        $this->host = $config['host'];
        if(isset($config['port']) ? $this->port = $config['port'] : $this->port = 389 );
        $this->base_dn = $config['base_dn'];

        $this->bind_rdn = $config['bind_rdn'];
        $this->bind_pw = $config['bind_pw'];

        $this->connect();
    }

    function connect()
    {
        //if($this->connection){
        //    $this->disconnect();
       // }

        $this->connection = ldap_connect($this->host, $this->port);
        if(ldap_set_option($this->connection,LDAP_OPT_PROTOCOL_VERSION ,3)){
            $this->ldapversion = 3;
        } elseif(ldap_set_option($this->connection,LDAP_OPT_PROTOCOL_VERSION ,2)) {
            $this->ldapversion = 2;
        }
        $this->bind($this->bind_rdn, $this->bind_pw);
    }

    private function bind($bind_rdn, $bind_pw)
    {
        $this->bind_rdn = $bind_rdn;
        $this->bind_pw = $bind_pw;

        return ldap_bind($this->connection, $this->bind_rdn,$this->bind_pw);
    }


    public function disconnect()
    {
        ldap_close($this->connection);
    }


}
