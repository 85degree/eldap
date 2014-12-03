<?php
/**
 * config.php
 * Created on 11/30/14 2:53 AM
 * Creator apung.dama@gmail.com
 *
 * Lisence and Term of Conditions, please read README.txt
 */
return array(
    'host' => 'ldap.host.com',
    'port' => 389,
    'base_dn'=>'dc=example,dc=com',
    'bind_rdn'=>'cn=manager,dc=example,dc=com',
    'bind_pw'=>'yourPassword',
    'people_base' => "ou=people,dc=example,dc=com",
    'group_base'=> "ou=groups,dc=example,dc=com",

    /** ObjectClasses **/
    'people_objectclasses' => array('top','inetOrgPerson','shadowAccount'),

);