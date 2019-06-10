<?php
namespace app\services\ImageOCR;

class StorageFile{
    /**
     * 储存文件目录
     */
    const FILE_DIR=__DIR__."/db/";

    public $file_name;
    public $file_path;
    /**
     * @var
     */
    protected $_db;

    public function __construct($filename)
    {
        $this->file_path = self::FILE_DIR.$filename.'.json';
        $this->connect();
    }

    /**
     * 初始化连接
     * @author mohuishou<1@lailin.xyz>
     * @throws \Exception
     */
    public function connect(){

        //检查是否拥有存在文件，不存在则新建
        if (!file_exists($this->file_path)) {
            if(!@file_put_contents($this->file_path,json_encode([]))){
                throw new \Exception("初始化错误，无法写入文件".$this->file_path);
            }
        }
        $this->_db=json_decode(file_get_contents($this->file_path),true);
    }

    /**
     * 添加数据
     * @author mohuishou<1@lailin.xyz>
     * @param $code
     * @param $hash_data
     */
    public function add($code,$hash_data){
        $this->_db[$code][]=$hash_data;
        $this->save();
    }

    /**
     * 保存数据
     * @author mohuishou<1@lailin.xyz>
     * @throws \Exception
     */
    public function save(){
        if(!@file_put_contents($this->file_path,json_encode($this->_db))){
            throw new \Exception("初始化错误，无法写入文件".$this->file_path);
        }
    }

    /**
     * 获取所有数据
     * @author mohuishou<1@lailin.xyz>
     * @return mixed
     */
    public function get(){
        return $this->_db;
    }


}