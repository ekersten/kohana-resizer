<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Resizer extends Controller {

    public $use_cache;
    public $cache_folder;
    public $ttl;

	public function before(){
        $this->use_cache = Kohana::$config->load('resizer.use_cache');
        $this->cache_folder = Kohana::$config->load('resizer.cache_folder');
        $this->ttl = Kohana::$config->load('resizer.ttl');        
    }

    public function action_index(){
		/*echo "soy resizer<br/>";
		echo "type: {$this->request->param('type')}<br/>";
		echo "width: {$this->request->param('width')}<br/>";
		echo "height: {$this->request->param('height')}<br/>";
		echo "file: {$this->request->param('file')}<br/>";*/

		

		$w = $this->request->param('width');
		$h = $this->request->param('height');
		$t = $this->request->param('type');
		$f = $this->request->param('file');

		
        if(!file_exists($f) || trim($f) == ''){
            $this->response->status(404);
            echo 'Image not found at ' . $f;
            return;
        }


		//echo "$cache_folder<br/>";
		
		$ext = strtolower(substr(basename($f), strrpos(basename($f), '.')));

        $new_filename = md5($f) . '_' . $w . 'x' . $h . '_' . $t . $ext;
        $cached_file = $this->cache_folder. $new_filename;


        if (file_exists($cached_file) && time() - filemtime($cached_file) < $this->ttl && $this->use_cache == TRUE) {
            //echo 'existe<br>';
        } else {
            //$temp_file = str_replace(basename($f), 'resizer_' . $new_filename . '_' . basename($f), $f);

            $img = Image::factory($f);
            
            $resize_type = NULL;
            if($t == 'c'){
            	$resize_type = Image::INVERSE;
            }
        	$img->resize($w, $h, $resize_type);

        	if($t == 'c'){
        		$img->crop($w, $h);
        	}

            if (file_exists($cached_file)) unlink($cached_file);
            $img->save($cached_file, 100);

            //rename($temp_file, $cached_file);

        }
        $data = getimagesize($cached_file);
        
        $this->response->headers('content-type',File::mime($cached_file))->body(file_get_contents($cached_file));
	}

    public function action_flush_cache(){
        $dir = $this->cache_folder;
        $count = 0;
        foreach(glob($dir.'*.*') as $v){
            echo 'deleted ' . $v . '<br/>';
            unlink($v);
            $count++;
        }

        echo 'deleted ' . $count . ' files';
    }

}