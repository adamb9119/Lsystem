<?php
namespace Lsystems\Src;

class SvgGraphic implements GraphicInterface
{
    protected $svgId;
    protected $width;
    protected $height;
    protected $line;
    protected $image;

    function __construct()
    {
        $this->svgId         = "svg-image";
        $this->width         = "100%";
        $this->height        = "100%";
        $this->line['color'] = 'black';
        $this->line['width'] = 1;
    }

    public function setImageId($id)
    {
        $this->svgId = $id;
    }

    public function getImageId()
    {
        return $this->svgId;
    }

    public function setLineColor($color)
    {
        $this->line['color'] = $color;
    }

    public function setLineWidth($width)
    {
        $this->line['width'] = $width;
    }

    public function getImage()
    {
        $image  = $this->svgOpenTag();
        $image .= $this->image;
        $image .= $this->svgCloseTag();

        $this->clearImage();

        return $image;
    }

    protected function svgOpenTag()
    {
        $id     = $this->svgId;
        $width  = $this->width;
        $height = $this->width;

        $svgOpenTag  = "<svg";
        $svgOpenTag .= " id='$id'";
        $svgOpenTag .= " width='$width'";
        $svgOpenTag .= " height='$height'";
        $svgOpenTag .= " version='1.1' xmlns='http://www.w3.org/2000/svg'>";

        return $svgOpenTag;
    }

    protected function svgCloseTag()
    {
        return "</svg>";
    }

    public function drawLine($x1,$y1,$x2,$y2)
    {
        $lineColor = $this->line['color'];
        $lineWidth = $this->line['width'];

        $line  = "<line ";
        $line .= " x1='$x1'";
        $line .= " y1='$y1'";
        $line .= " x2='$x2'";
        $line .= " y2='$y2'";
        $line .= " style='stroke:".$lineColor."; stroke-width:".$lineWidth."px;'";
        $line .= " />";

        $this->image .= $line;
    }

    public function clearImage()
    {
        $this->image = "";
    }
}
