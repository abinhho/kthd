<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lib_assets{
	var $active_mods = array(); 
	var $CI;
	public function __construct(){
        //echo "TB_asset_a";
        $this->CI = &get_instance();
  	}
    public function index(){
    	//echo "Index TB_media";
    }
    public function combind_css(){
   		
    	$css_content = "";
    	$mainfile_css = 'assets/optimize/mods.css';
    	if(file_exists($mainfile_css)) return;
		foreach ($this->active_mods as $mod){
			$fol = APPPATH. 'modules/'. $mod['alias'] . '/assets/css/'.$mod['alias'].'.css';
			
			if (file_exists($fol)) { 
				$fh = fopen($fol, "rb");
				$css_content .= fread($fh, filesize($fol)+1);
			}
		}
		$temp = fopen($mainfile_css, 'w'); 
		fwrite($temp, $css_content); 
		fclose($temp); 
    }
    
    public function module_js(){
        
        $mainfile_ = 'assets/optimize/modsjs.js';
        if(file_exists($mainfile_)) return;
        $js_content = "";
                
        foreach ($this->active_mods as $mod){
            $fol = APPPATH. 'modules/'. $mod['alias'] . '/assets/js/'.$mod['alias'].'.js';
            
            if (file_exists($fol)) {
                $fh = fopen($fol, "rb");
                $js_content .= fread($fh, filesize($fol)+1);
                $this->CI->template->add_js($fol);
            }
            $temp = fopen($mainfile_, 'w'); 
    		fwrite($temp, $js_content); 
    		fclose($temp); 
        }
       
    }
}