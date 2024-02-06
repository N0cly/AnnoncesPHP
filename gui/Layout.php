<?php

namespace gui;
class Layout
{
    protected $templateFile;

    public function __construct( $templateFile )
    {
        $this->templateFile = $templateFile;
    }

    public function display( $title, $content , $nav)
    {
        $page = file_get_contents( $this->templateFile );
        $page = str_replace( ['%title%','%content%','%nav%'], [$title,$content,$nav], $page);
        echo $page;
    }

}
?>
