<?php namespace Caouecs\Gumby2;

use \HTML;

class Breadcrumb {

    /**
     * Elements of breadcrumb
     *
     * @access protected
     * @var array
     */
    protected $elements = array();
 
    /**
     * Attributes of breadcrumb
     *
     * @access protected
     * @var array
     */
    protected $attributes = array();

    /**
     * Create a new Breadcrumb
     *
     * @access public
     * @param array $attributes Attributes of breadcrumb
     * @return \Breadcrumb
     */
    public static function show($attributes = array())
    {
        $breadcrumb = new Breadcrumb;

        $breadcrumb->attributes = $attributes;

        return $breadcrumb;
    }

    /**
     * Add element
     *
     * @access public
     * @param string $title Title of element
     * @param string $link Link of element
     * @return \Breadcrumb
     */
    public function add($title, $link = null)
    {
        $this->elements[] = array("title" => e($title), "link" => (string) $link);

        return $this;
    }

    /**
     * Display breadcrumb
     *
     * @access public
     * @return string
     */
    public function __toString()
    {
        if (empty($this->elements)) {
            return null;
        }

        $attributes = Helpers::add_class($this->attributes, "breadcrumb");

        $res = '<ul'.HTML::attributes($attributes).'>';

        foreach ($this->elements as $element) {

            $res .= '<li>';

            // link
            if (isset($element['link']) && $element['link'] != null) {
                $res .= '<a href="'.$element['link'].'">'.$element['title'].'</a>';
            } else {
                $res .= $element['title'];
            }

            $res .= '</li>';

            $i++;
        }
        $res .= '</ul>';

        return $res;
    }
}