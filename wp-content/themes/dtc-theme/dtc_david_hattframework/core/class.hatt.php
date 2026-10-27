<?php

if(class_exists('hattFramework')) return;
class hattFramework{

    protected $root_dir_name="dtc_david_hattframework";

	protected $plugin_dir;

	function __construct()
	{
		$libs=array(
            'plugins/BFI_Thumb',
            'plugins/Tax-meta-class/Tax-meta-class',
            'helpers/hatt-helper',
            'lib/ot-google-fonts/functions'   ,
            'core/class.assets',
            'core/class.posttype',
            'core/class.taxonomy',
            'core/class.shortcode',
            'core/class.optiontree',
			'ht-hook-functions',
			'ht-hook-register',
            'core/class.post',

		);

		$this->load_libs($libs);

        $this->load_class();
        $this->load_shortcodes();
        if(class_exists('Vc_Manager'))
        {
            add_action('init',array($this,'loadVcElements'));
        }
	}

    function load_class()
    {
        //Post type and taxonomies
        if(class_exists('hattPosttype') and class_exists('hattTaxonomy'))
        {
            $dirs = array_filter(glob($this->dir('class/*')), 'is_file');

            $dirs=apply_filters('ht_load_class_files',$dirs);

            if(!empty($dirs))
            {
                foreach($dirs as $key=>$value)
                {
                    require_once $value;

                }
            }
        }
    }
    function load_shortcodes()
    {
        //Post type and taxonomies
        if(class_exists('HTBaseShortcode'))
        {
            $dirs = array_filter(glob($this->dir('shortcodes/*')), 'is_file');

            $dirs=apply_filters('ht_load_class_files',$dirs);

            if(!empty($dirs))
            {
                foreach($dirs as $key=>$value)
                {
                    require_once $value;

                }
            }
        }
    }

    function loadVcElements()
    {
        if (class_exists('HTBaseShortcode') and function_exists('vc_map')){
            $dirs = array_filter(glob($this->dir('vc-elements/*')), 'is_file');
            $exclude = apply_filters('ht_exclude_vcelements', array());
            $hasExclude = false;
            if (is_array($exclude) and !empty($exclude)) {
                $hasExclude = true;
            }


            if (!empty($dirs)) {
                foreach ($dirs as $key => $value) {
                    $dirname = basename($value);
                    if (!$hasExclude or !in_array($dirname, $exclude)) {
                        $file = $value;
                        if (is_file($file)) {
                            require_once $file;
                        }
                    }
                }
            }
        }
    }

    function dir($url=false)
    {
        return get_template_directory().'/'.$this->root_dir_name.'/'.$url;
    }

    function url($url=false)
    {
        return get_template_directory_uri().'/'.$this->root_dir_name.'/'.$url;
    }

	function load_libs($libs=array())
	{
		if(!empty($libs)){
			foreach($libs as $value){


				$file=$this->dir($value.'.php');


				if(file_exists($file)){

					require_once($file);


				}

			}
		}
	}




    /*---------Begin Helper Functions----------------*/

    function get_option($option_name,$default=false){
        if(class_exists('ACF') and function_exists('get_field')){
			
			if(get_field($option_name,'option') == NULL) {
				return $default;
			}
			
            $dataType = get_field_object($option_name,'option');
            if( isset($dataType["type"]) && $dataType["type"] === 'true_false'){
                return get_field($option_name,'option') == 1 ? "on": "off";
            }
			
            return get_field($option_name,'option');
        }
        return $default;
    }

	function set_plugin_dir($dir)
	{
		$this->plugin_dir=$dir;
	}

    function plugin_dir($url=false){
        if($url) $url='/'.$url;

        return $this->plugin_dir.$url;
    }

    function load_template($slug,$name=false,$data=array())
    {
        extract($data);
        $new_slug='';
        if($name){
            $new_slug=$slug.'-'.$name;
        }

        //Find template in folder dtc_david_templates/
        $template=locate_template('dtc_david_templates/'.$new_slug.'.php');

        if(!$template){
            $template=locate_template('dtc_david_templates/'.$slug.'.php');
        }

        //If file not found
        if(is_file($template))
        {
            ob_start();

            include $template;

            $data=@ob_get_clean();

            return $data;
        }
    }
}