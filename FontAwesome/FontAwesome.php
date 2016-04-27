<?php

namespace M2Digital\Extras\FontAwesome;

use M2Digital\Extras\Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class FontAwesome
{
    /**
     * Full qualified path of Sass variable file.
     *
     * @var string
     */
    protected $file = '';

    /**
     * File content.
     *
     * @var string
     */
    protected $content;

    /**
     * Icons Collection.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $icons;

    /**
     * @param null $file
     */
    public function __construct($file = null) {
        if (!is_null($file)) {
            $this->file = $file;
            return ;
        }

        $this->file = public_path('/assets/vendor/font-awesome/scss/_variables.scss');

        $this->fileGetContent();
        $this->makeIconsCollection();

    }

    /**
     * Get file content.
     *
     * @return $this
     * @throw FileNotFoundException
     */
    protected function fileGetContent() {
        if(!file_exists($this->file)) {
            throw new FileNotFoundException('Variable Sass file can\'t be found.');
        }

        $this->content = file_get_contents($this->file);
    }

    /**
     * Make Collection of icons.
     *
     * @return $this
     */
    protected function makeIconsCollection() {

        $pos = strpos($this->content, '$fa-var');

        $font_vars = substr($this->content, $pos);

        $lines = explode("\n", $font_vars);

        $fonts_list = array();

        foreach($lines as $line) {
            if(strpos($line, ':') !== false) {
                $t = explode(":", $line);
                $fonts_list[str_replace('$fa-var', 'fa', $t[0])] = $t[1];
            }
        }

        $this->icons = new Collection($fonts_list);

    }

    /**
     * Icons Collection Instance.
     *
     * @return Collection
     */
    public function icons() {
        return $this->icons;
    }
}