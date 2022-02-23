<?php
class MoLdapPointers
{

    private $content_ldap,$ldap_anchor_id,$ldap_edge,$ldap_align,$ldap_active,$ldap_pointer_name;

    function __construct($header,$body,$ldap_anchor_id,$ldap_edge,$ldap_align,$ldap_active,$prefix){

    $this->content_ldap = '<h3>' . __( $header ) . '</h3>';
    $this->content_ldap .= '<p  id="'.$prefix.'" style="font-size: initial;">' . __( $body ) . '</p>';
    $this-> ldap_anchor_id = $ldap_anchor_id;
    $this->ldap_edge = $ldap_edge;
    $this->ldap_align = $ldap_align;
    $this->ldap_active = $ldap_active;
    $this->ldap_pointer_name = 'miniorange_admin_pointer_'.$prefix;
    }

     function return_array(){
        return array(
            'content_ldap' => $this->content_ldap,
            'ldap_anchor_id' => $this->ldap_anchor_id,
            'ldap_edge' => $this->ldap_edge,
            'ldap_align' => $this->ldap_align,
            'ldap_active' => $this->ldap_active,
        );
    }

    public function getcontent_ldap()
    {
        return $this->content_ldap;
    }

    public function setcontent_ldap($content_ldap)
    {
        $this->content_ldap = $content_ldap;
    }

    public function getAnchorId()
    {
        return $this->ldap_anchor_id;
    }

    public function get_ldap_edge()
    {
        return $this->ldap_edge;
    }

    public function get_ldap_active()
    {
        return $this->ldap_active;
    }

    public function set_ldap_active($ldap_active)
    {
        $this->ldap_active = $ldap_active;
    }

    public function getPointerName()
    {
        return $this->ldap_pointer_name;
    }

}