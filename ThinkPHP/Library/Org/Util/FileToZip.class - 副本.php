<?php
/**
 * 遍历目录，打包成zip格式
 */
class traverseDir{
    protected $file_path;
    /**
     * 构造函数
     * @param [string] $path [传入文件目录]  
     */
    public function __construct($path){
        $this->file_path=$path; //要打包的根目录
    }
    /**
     * 入口调用函数
     * @return [type] [以二进制流的形式返回给浏览器下载到本地]
     */
    public function tozip(){
        $zip=new ZipArchive();
        $end_dir=$this->file_path.date('Ymd',time()).'.zip';//定义打包后的包名
        $dir=$this->file_path;
        if(!file_exists($end_dir)){
            $fp=fopen($end_dir,"w");
            fputs($fp,$str);
            fclose($fp);
        }
 

        if($zip->open($end_dir, ZipArchive::OVERWRITE) === TRUE){ ///ZipArchive::OVERWRITE 如果文件存在则覆盖
            $this->addFileToZip($dir, $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
            $zip->close(); 
        }
        echo $end_dir;
        if(!file_exists($end_dir)){   
            exit("无法找到文件"); 
        }
        header("Cache-Control: public"); 
        header("Content-Description: File Transfer"); 
        header("Content-Type: application/zip"); //zip格式的   
        header('Content-disposition: attachment; filename='.basename($end_dir)); //文件名   
        header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件    
        header('Content-Length:'.filesize($end_dir)); //告诉浏览器，文件大小   
        @readfile($end_dir);
        // $this->delDirAndFile($dir,true);//删除目录和文件
        // unlink($end_dir);////删除压缩包
    }
    /**
     * 文件压缩函数 需要开启php zip扩展
     * @param [string] $path [路径]
     * @param [object] $zip  [扩展ZipArchive类对象]
     */
    protected function addFileToZip($path, $zip){
        $handler = opendir($path);
        while (($filename=readdir($handler)) !== false) {
            if ($filename!= "." && $filename!=".."){
               if(is_dir($path."/".$filename)){
                    $this->addFileToZip($path."/".$filename,$zip);
                } else {
                    $zip->addFile($path."/".$filename);
                } 
            }
        }
        @closedir($path);
    }
    /**
     * 删除文件函数 
     * @param  [string]  $dir    [文件目录]
     * @param  boolean $delDir [是否删除目录]
     * @return [type]          [description]
     */
    protected function delDirAndFile($path,$delDir=true){
        $handle=opendir($path);
        if($handle){
            while(false!==($item = readdir($handle))){
                if($item!="."&&$item!=".."){
                    if(is_dir($path.'/'.$item)){
                        $this->delDirAndFile($path.'/'.$item, $delDir);
                    }else{
                        unlink($path.'/'.$item);
                    }
                }
            }
            @closedir($handle);
            if($delDir){return rmdir($path);}
        }else{
            if(file_exists($path)){
                return unlink($path);
            }else{
                return FALSE;
            }
        }
    }
}

/**
 * 下载文件
 *
 */
class download{
    protected $_filename;
    protected $_filepath;
    protected $_filesize;//文件大小
    protected $savepath;//文件大小
    public function __construct($filename,$savepath){
        $this->_filename=$filename;
        $this->_filepath=$savepath.$filename;
    }
    //获取文件名
    public function getfilename(){
        return $this->_filename;
    }
    
    //获取文件路径（包含文件名）
    public function getfilepath(){
        return $this->_filepath;
    }
    
    //获取文件大小
    public function getfilesize(){
        return $this->_filesize=number_format(filesize($this->_filepath)/(1024*1024),2);//去小数点后两位
    }
    //下载文件的功能
    public function getfiles(){
        //检查文件是否存在
        if (file_exists($this->_filepath)){
            //打开文件
            $file = fopen($this->_filepath,"r");
            //返回的文件类型
            Header("Content-type: application/octet-stream");
            //按照字节大小返回
            Header("Accept-Ranges: bytes");
            //返回文件的大小
            Header("Accept-Length: ".filesize($this->_filepath));
            //这里对客户端的弹出对话框，对应的文件名
            Header("Content-Disposition: attachment; filename=".$this->_filename);
            //修改之前，一次性将数据传输给客户端
            echo fread($file, filesize($this->_filepath));
            //修改之后，一次只传输1024个字节的数据给客户端
            //向客户端回送数据
            $buffer=1024;//
            //判断文件是否读完
            while (!feof($file)) {
                //将文件读入内存
                $file_data=fread($file,$buffer);
                //每次向客户端回送1024个字节的数据
                echo $file_data;
            }
            
            fclose($file);
        }else {
            echo "<script>alert('对不起,您要下载的文件不存在');</script>";
        }
    }
}