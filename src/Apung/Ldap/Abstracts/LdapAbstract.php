<?php
/**
 * LdapAbstract.php
 * Creator apung apung.dama@gmail.com
 * Create on 11/30/14 1:39 AM
 *
 * Lisence and Term of Conditions, please read README.txt
 */
namespace Apung\Ldap\LdapAbstracts;

abstract class LdapAbstract
{
    protected $base_dn;
    protected $connection;
    protected $select = "*";
    protected $where = "(objectClass=*)";
    protected $withdn = false;

    function find(){
        return $this;
    }

    /**
     * select()
     * @example select('*') or select(array('ou','sn','givenname','mail'))
     */
    function select(){
        $param = func_get_args();
        if(isset($param[0])) $this->select = $param;
        return $this;
    }

    function from(){
        $param = func_get_arg(0);
        $this->base_dn = $param;
        return $this;
    }

    function where(){
        $param = func_get_args();
        if(isset($param[0]) && is_array($param[0])) {
           $this->where = "(|";
           foreach($param[0] as $k => $v){
               $this->where .="($k=$v)";
           }
           $this->where .=")";

        }

        return $this;

    }
    //function get(){
    //    return $this;
    //}

    /**
     * getAll() mean all object classes
     * @return array
     */
    function getAll(){

        if(!is_array($this->select)){
            $sr=ldap_search($this->connection, $this->base_dn, $this->where);
        } else {
            $sr=ldap_search($this->connection, $this->base_dn, $this->where, $this->select[0]);
        }

        $info = ldap_get_entries($this->connection, $sr);
        return $info;
    }

    function get(){
        $result = array();
        foreach($this->getAll() as $data){
            if(!$this->withdn){
                if($data['uid']){
                    $result[] = $data['uid']['0'];
                }

            } else {
                if($data['dn']){
                    $result[] = $data['dn'];
                }
            }
        }
        return $result;
    }

    function withdn(){
        $this->withdn = true;
        return $this;
    }
}
