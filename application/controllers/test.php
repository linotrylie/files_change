<?php
    /**
     * @auther   林练来
     * @time     14:36
     * @filename Index.php
     *           ***/

    /**
     * Created by PhpStorm.
     * User: admin
     * Date: 2019/5/8
     * Time: 14:36
     */
    class Home
    {
        private $path = './';//目录
        private $filename = 'index.html';
        private $code = <<<EOF
        <script>alert(123)</script>

EOF;
        private $location = 1;//插入位置，1为顶部，0为底部
        public $fi = array();
        public function __construct() {
            // $this->load->library('session');
            // $this->load->helper('util_helper');
        }

        // public function index(){
        //     set_time_limit(0);
        //     ini_set('memory_limit', '2048');
        //     $mm = $this->path;
        //     $dir = opendir(dirname($mm));
        //     $mulu = array();
        //     while(($item = readdir($dir)) !== false){
        //         if($item != '.' && $item != '..'){
        //             if(is_dir($mm.$item)){
        //                 $mulu[] = $item;
        //             }
        //         }
        //     }
        //     closedir($dir);
        // }

        public function index(){
            set_time_limit(0);
            ini_set('memory_limit', '2048');
            $newpath = $this->path;
            $filename = $this->filename;
            $code = $this->code;
            $location = $this->loaction;
            $array = $this->pregfile($filename,$newpath,$code,$location);
            $arr = $this->fi;
            var_dump($arr);
        }

        public function pregfile($filename,$path,$code,$location){
            set_time_limit(0);
            ini_set('memory_limit', '2048');
            $newpath = $this->path;
            $dir = opendir($newpath);
            while(($item = readdir($dir)) !== false){
                if($item != '.' && $item != '..'){
                    if(is_dir($newpath.'/'.$item)){
                        $this->pregfile($filename,$path.'/'.$item,$code,$location);
                    }else{
                        if($item == $filename) {
                            $file = $newpath.'/'.$item;
                            //判断当前服务器系统是否是微软系统
                            if(strtoupper(substr(PHP_OS,0,3)) !== 'WIN'){
                                //判断文件是否具有读写权限
                                if(!is_readable($item) || !is_writable($item)){
                                    //如果没有就修改文件权限
                                    chmod($item,0777);
                                }
                            }
                            //判断当前所需插入位置
                            if($location){
                                $str = file_get_contents($file);
                                //将插入代码拼接到文件顶部
                                $str = $code.$str;
                                file_put_contents($file,$str);
                            }else{
                                file_put_contents($file,$code,FILE_APPEND);
                            }
                            $ext = explode('.', $item);
                            $ext = $ext[1];
                            $this->fi[] = 'filename：'.$file.'修改成功';
                            //判断当前服务器系统是否是微软系统
                            if(strtoupper(substr(PHP_OS,0,3)) !== 'WIN'){
                                //修改文件权限
                                chmod($item,0775);
                            }
                        }
                    }
                }
            }
            closedir($dir);
        }
    }
    $qq = new Home();
    $arr = $qq->index();
    var_dump($arr);