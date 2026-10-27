<?php
get_template_part('dtc_david_hattframework/core/class.hatt');


class hattProject extends  hattFramework
{

    //define location of Included Theme's plugins

    function __construct()
    {
        parent::__construct();

        $file=array(
            'ht-required-plugins',
            'ht-customvc',
            'lib/bootstrap_navwalker',
            'import/importer'
        );

        parent::load_libs($file);
    }
}

function Hatt()
{
    global $hatt_global;
    if(!$hatt_global){
        $hatt_global=new hattProject();
    }
    return $hatt_global;
}
Hatt();