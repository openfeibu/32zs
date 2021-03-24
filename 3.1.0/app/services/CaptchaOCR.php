<?php
namespace app\services;
use app\services\ImageOCR\Image;

class CaptchaOCR {
    public function __construct($image_path)
    {
        $this->image_ocr = new Image($image_path);
    }

    public function image_hash($type)
    {
        switch ($type)
        {
            case 'neea':
                for($i = 0; $i < $this->image_ocr->_image_h; $i++) {
                    for ($j = 0; $j < $this->image_ocr->_image_w; $j++) {
                        $rgb = imagecolorat($this->image_ocr->_in_img,$j,$i);
                        $rgb_array = imagecolorsforindex($this->image_ocr->_in_img, $rgb);
                        if(( $rgb_array['red'] >120 && $rgb_array['red'] < 135) && ($rgb_array['green'] >120 && $rgb_array['green'] < 135)&&($rgb_array['blue'] >120 && $rgb_array['blue'] < 135)){
                            $data[$i][$j]=1;
                        }else{
                            $data[$i][$j]=0;
                        }
                    }

                }
                break;
            case '5184':
                for($i = 0; $i < $this->image_ocr->_image_h; $i++) {
                    for ($j = 0; $j < $this->image_ocr->_image_w; $j++) {
                        $rgb = imagecolorat($this->image_ocr->_in_img,$j,$i);
                        $rgb_array = imagecolorsforindex($this->image_ocr->_in_img, $rgb);
                        if($rgb_array['red']<160&&$rgb_array['green']<160&&$rgb_array['blue']<160){
                            $data[$i][$j]=1;
                        }else{
                            $data[$i][$j]=0;
                        }
                    }

                }
                break;

        }

        $data=$this->image_ocr->removeHotSpots($data);
        $data=$this->image_ocr->removeHotSpots($data);
        $data=$this->image_ocr->removeHotSpots($data);
        $this->image_ocr->_hash_data=$this->image_ocr->removeHotSpots($data);
        $this->image_ocr->removeZero();

        $this->image_ocr->draw();
    }
    public function find($filename)
    {
        return $this->image_ocr->find($filename);
    }

}