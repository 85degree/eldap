<?php
/**
 * PeopleAbstract.php
 * Creator apung apung.dama@gmail.com
 * Create on 12/1/14 9:30 AM
 *
 * Lisence and Term of Conditions, please read README.txt
 */
namespace Apung\Ldap\Abstracts;
use Illuminate\Support\Facades\Config;
abstract class PeopleAbstract
{
    protected $base_dn;
    protected $connection;
    protected $bind;
    protected $objectClasses = array();
    protected $object;

    function people(){
        $this->objectClasses = Config::get('ldap::people_objectclasses');
        return $this;
    }

    /**
     * @param array $param
     * @param $dn
     * @return bool
     * @throws \Exception
     */
    function addUser(array $param, $dn){

        if(!isset($param['cn']) || trim($param['cn']) == '') throw new \Exception('There is no cn parameter');
        if(!isset($param['sn']) || trim($param['sn']) == '') throw new \Exception('There is no sn parameter');
        if(!isset($param['uid']) || trim($param['uid']) == '') throw new \Exception('There is no uid parameter');

        if(isset($param['objectclasses'])) {
            $this->objectClasses = array_merge($this->getDefaultObjectClasses(), $param['objectclasses']);
        } else {
            $this->objectClasses = $this->getDefaultObjectClasses();
        }
        $this->object = $param;
        $this->object = array_add($this->object, "objectclass",$this->objectClasses);
        //ldap_add($this->connection,$dn,$this->object);
        return ldap_add($this->connection,$dn,$this->object);


    }


    function getDefaultObjectClasses(){
        return $this->objectClasses;
    }


    function changePassword($dn, $newPassword){
        return ldap_mod_replace($this->connection, $dn, array('userPassword'=>$this->___formatPassword($newPassword)));
    }

    protected function ___formatPassword($password){
        $userpassword = "{SHA}" . base64_encode( pack( "H*", sha1( $password ) ) );

        return $userpassword;
    }
}
