<?php
/**
 * Created by PhpStorm.
 * User: pavellen
 * Date: 6/6/17
 * Time: 4:02 PM
 */

namespace Abuchyn\AlexBundle\File;


class ImageResize
{
    /** @var int  */
    private $width;

    /** @var int  */
    private $height;

    /** @var string  */
    private $image;

    /** @var string  */
    private $extansion;

    /**
     * ImageResize constructor.
     *
     * You can use a constructor with a protected method "imageResize"
     * $var = new ImageResize($height, $width, $image, $extansion);
     *
     * @param $height
     * @param $width
     * @param $image
     * @param $extension
     */
    public function __construct($image, $extension, $width = 240, $height = 320)
    {
        $this-> imageResize(
            $this->image = $image,
            $this->extansion = $extension,
            $this->width = $width,
            $this->height = $height
        );
    }

    /**
     * @param $height
     * @param $width
     * @param $image
     * @param $extension
     * @return resource
     */
    public function imageResize($image, $extension, $width, $height)
    {
        switch ($extension){ // узнаем тип картинки
            case "gif":
                $im = imagecreatefromgif($image);
                break;
            case "jpeg":
                $im = imagecreatefromjpeg($image);
                break;
            case "png":
                $im = imagecreatefrompng($image);
                break;
            case "jpg":
                $im = imagecreatefromjpeg($image);
                break;
        }

        list($inW, $inH) = getimagesize($image);
        if ($width < $inW) {
            $koeH = $inW/$width; //Calculate the coefficient for height
            $outH = ceil($inH/$koeH); //Calculate the height using the coefficient
            $newImg = imagecreatetruecolor($width, $outH);
            if ($height < $outH) {
                $koeH = $outH/$height; //Calculate the coefficient for width
                $outW = ceil($width/$koeH); //Calculate the width using the coefficient
                $newImg = imagecreatetruecolor($outW, $height); // создаем картинку
                imagecopyresampled($newImg,$im,0,0,0,0,$outW,$height,imagesx($im),imagesy($im));
            } else {
                $newImg = imagecreatetruecolor($width, $outH);
                imagecopyresampled($newImg,$im,0,0,0,0,$width,$outH,imagesx($im),imagesy($im));
            }
            imageconvolution($newImg, array( // improve clarity
                array(-1, -1, -1),
                array(-1, 16, -1),
                array(-1, -1, -1)),
                8, 0);

            imagejpeg($newImg, $image, 100); // conversion to jpg
            imagedestroy($im);
            imagedestroy($newImg);
            return $newImg;
        }
    }
}