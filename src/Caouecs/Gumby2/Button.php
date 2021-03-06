<?php namespace Caouecs\Gumby2;

use \HTML;

class Button {

    /**
     * Tag of button
     *
     * @access protected
     * @var string
     */
    protected $tag = 'div';

    /**
     * Class of button
     *
     * @access protected
     * @var string
     */
    protected $class = 'default';

    /**
     * Message in button
     *
     * @access protected
     * @var string
     */
    protected $message = null;

    /**
     * Attributes of button
     *
     * @access protected
     * @var array
     */
    protected $attributes = array();

    /**
     * Icon of button
     *
     * @access protected
     * @var string
     */
    protected $icon = null;

    /**
     * Call an button
     *
     * @access public
     * @param string $method Method called
     * @param array $params Params of method
     * @return \Button
     */
    public static function __callStatic($method, $params = '')
    {
        $class = null;

        $array_methods = explode("_", $method);

        $array_sizes  = array("xlarge", "large", "medium", "small");
        $array_colors = array("primary", "secondary", "normal", "info", "danger", "warning", "success", "light");
        $array_themes = array("metro", "pretty");
        $array_styles = array("oval", "rounded", "squared", "pillleft", "pillright");

        foreach ($array_methods as $method) {

            // size
            if (in_array($method, $array_sizes)) {
                $class['size'] = $method;

            // color
            } elseif (in_array($method, $array_colors)) {
                if ($method == "normal")
                    $method = "default";

                $class['color'] = $method;

            // theme
            } elseif (in_array($method, $array_themes)) {
                $class['theme'] = $method;


            // style
            } elseif (in_array($method, $array_styles)) {
                if ($method == "pillleft")
                    $method = "pill-left";
                elseif ($method == "pillright")
                    $method = "pill-right";

                $class['style'] = $method;
            }
        }

        if (!isset($class['color'])) {
            $class['color'] = "default";
        }

        array_unshift($params, implode(" ", $class));

        return call_user_func_array('static::show', $params);
    }

    /**
     * Create a custom button
     *
     * @access public
     * @param string $class Class custom of button
     * @param string $message Message in button
     * @param array $attributes Attributes of button
     * @return \Button
     */
    public static function custom($class, $message, $attributes = array())
    {
        return static::show($class, $message, $attributes);
    }


    /**
     * Create a new Button
     *
     * @access protected
     * @param string $class Class of button
     * @param string $message Message in button
     * @param array $attributes Attributes of button
     * @return \Button
     */
    protected static function show($class, $message = '', $attributes = array())
    {
        $button = new Button;

        $button->class      = (string) $class;
        $button->message    = $message;
        $button->attributes = $attributes;

        return $button;
    }

    /**
     * Add icon at left
     *
     * @access public
     * @param string $icon Name of icon
     * @param boolean $append Situation of icon (true = before, false = after)
     * @return \Button
     */
    public function append($icon, $append = true)
    {
        $icon = " entypo icon-".e($icon);

        if ($append == true) {
            $icon .= " icon-left ";
        } else {
            $icon .= " icon-right ";
        }

        $this->icon = $icon;

        return $this;
    }

    /**
     * Add icon at right
     *
     * @access public
     * @param string $icon Name of icon
     * @return \Button
     */
    public function prepend($icon)
    {
        return $this->append($icon, false);
    }

    /**
     * Update tag
     *
     * @access public
     * @param string $tag Tag
     * @return \Button
     */
    public function setTag($tag)
    {
        $this->tag = e($tag);

        return $this;
    }

    /**
     * Display button
     *
     * @access public
     * @return strung
     */
    public function __toString()
    {
        $class = $this->class;

        if ($this->icon != null) {
            $class .= $this->icon;
        }

        $attributes = Helpers::add_class($this->attributes, $class.' btn');

        return '<'.$this->tag.HTML::attributes($attributes).'>'.$this->message.'</'.$this->tag.'>';
    }
}