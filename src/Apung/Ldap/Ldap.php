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
use Apung\Ldap\Abstracts\LdapAbstract;
use Illuminate\Support\Facades\Config;
class Ldap
    extends LdapAbstract

    implements ConnectionInterface
{
    protected $connection;
    protected $host;
    protected $port = 389;
    protected $bind_rdn;
    protected $bind_pw;
    protected $base_dn;
    protected $ldapversion;
    /**
     * @param array $config
     * @example
     */
    function __construct(){
        $this->host = Config::get('ldap::host');
        $this->port = Config::get('ldap::port');
        $this->base_dn = Config::get('ldap::base_dn');
        $this->bind_rdn = Config::get('ldap::bind_rdn');
        $this->bind_pw = Config::get('ldap::bind_pw');

    }

    function setOption(array $config){
        if(isset($config['host']))  $this->host = $config['host'];
        if(isset($config['port']))  $this->port = $config['port'];
        if(isset($config['base_dn']))  $this->base_dn = $config['base_dn'];

        if(isset($config['bind_rdn']))  $this->bind_rdn = $config['bind_rdn'];
        if(isset($config['bind_pw']))  $this->bind_pw = $config['bind_pw'];
    }

    /**
     * getOptions
     * @return mixed
     */
    function getOption(){
        $options['host'] = $this->host;
        $options['base_dn'] = $this->base_dn;
        $options['port'] = $this->port;
        $options['bind_rdn'] = $this->bind_rdn;
        return $options;
    }
    function connect()
    {
        $this->connection = ldap_connect($this->host, $this->port);
        if(ldap_set_option($this->connection,LDAP_OPT_PROTOCOL_VERSION ,3)){
            $this->ldapversion = 3;
        } elseif(ldap_set_option($this->connection,LDAP_OPT_PROTOCOL_VERSION ,2)) {
            $this->ldapversion = 2;
        }
        //$this->bind($this->bind_rdn, $this->bind_pw);
    }

    public function auth($bind_rdn, $bind_pw)
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
