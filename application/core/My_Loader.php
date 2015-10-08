<?php

class MY_Loader extends CI_Loader{
    /**
     * List of paths to load interfaces from
     *
     * @var array
     * @access protected
     */
    protected $_ci_interface_paths    = array();
    public function __construct()
    {
        parent::__construct();
        //we do all the standard Loader construction, then also set up the acceptable places to look for interfaces
        $this->_ci_interface_paths = array(APPPATH, BASEPATH);
    }

    public function initialize()
    {
        parent::initialize();
        // After the parent is initialized, we load the autoload config
        if (defined('ENVIRONMENT') AND file_exists(APPPATH.'config/'.ENVIRONMENT.'/autoload.php'))
        {
            include(APPPATH.'config/'.ENVIRONMENT.'/autoload.php');
        }
        else
        {
            include(APPPATH.'config/autoload.php');
        }
        // and if $autoload['interface'] is in the config, load each one
        if (isset($autoload['interface']))
        {
            foreach($autoload['interface'] as $interface)
                $this->iface($interface);
        }
    }

    /**
     * Load an interface from /application/interfaces
     *
     * @param $interface string The interface name
     * @return CI_Loader for chaining */
    public function iface($interface = '')
    {
        $class = str_replace('.php', '', trim($interface, '/'));

        // Was the path included with the interface name?
        // We look for a slash to determine this
        $subdir = '';
        if (($last_slash = strrpos($class, '/')) !== FALSE)
        {
            // Extract the path
            $subdir = substr($class, 0, $last_slash + 1);

            // Get the filename from the path
            $class = substr($class, $last_slash + 1);
        }
        // Look for the interface path and include it
        $is_duplicate = FALSE;
        foreach ($this->_ci_interface_paths as $path)
        {
            $filepath = $path.'interfaces/'.$subdir.$class.'.php';

            // Does the file exist?  No? Try the remaining paths
            if (!file_exists($filepath))
            {
                continue;
            }

            include_once($filepath);
            $this->_ci_loaded_files[] = $filepath;
            return $this;
        }
    }
}
/* End of file MY_Loader.php */
/* Location: ./application/core/MY_Loader.php */