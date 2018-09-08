<?php

class Allocator
{
    public static function allocate_model($_model)
    {
        if ($_model !== '' && $_model !== null){
            allocate(MODEL, $_model);
            if (class_exists($_model))
                return new $_model();
        }
        return null;
    }
    public static function allocate_behavior($_behavior)
    {
        if ($_behavior !== '' && $_behavior !== null){
            allocate(BEHAVIOR, $_behavior);
            if (class_exists($_behavior))
                return new $_behavior();
        }
        return null;
    }
	public static function allocate_ormclasses($_class)
	{
        if ($_class !== '' && $_class !== null){
            allocate(ORMCLASSES, $_class);
            if (class_exists($_class))
                return new $_class();
        }
        return null;
	}

    public static function allocate_controller($_controller)
    {
        if ($_controller !== '' && $_controller !== null){
            allocate(CONTROLLER, $_controller);
            if (class_exists($_controller))
            {
                Event::trigger('OnControllerLoaded');
                return new $_controller();
            }
        }
        return null;
    }
    public static function allocate_jsbehind($jsbehind)
    {
        allocate(JSBEHIND, $jsbehind);
    }
    public static function allocate_layout($_layout, $viewbag, $classic_layout = true)
    {
        Event::trigger('OnPreRender');
        if ($classic_layout)
        {
            $input = file_get_contents(string_for_allocate_file(LAYOUT, $_layout));
            $input = trim(str_replace("\r\n", "", $input));
            if (!empty($input)){
                self::allocate_helper('HtmlParser');
                HtmlParserHelper::LoadHtmlFromString($input);
                HtmlParserHelper::Binding($viewbag);
                HtmlParserHelper::RunHtml();
            }
        }
        else
            allocate(LAYOUT, $_layout, $viewbag::getBag());
    }
    public static function allocate_helper($helper)
    {
        $helper = $helper.'Helper';
        if ($helper !== '' && $helper !== null){
            allocate(HELPERS, $helper);
            if (class_exists($helper))
                return new $helper();
        }
        return null;
    }
    public static function allocate_api($api)
    {
        if ($api !== '' && $api !== null){
            allocate(API, $api);
            if (class_exists($api))
                return true;
        }
        return null;
    }
    public static function allocate_library($library)
    {
        if ($library !== '' && $library !== null){
            allocate(LIBRARIES, $library);
            if (class_exists($library))
                return new $library();
        }
        return null;
    }
    public static function allocate_css($css)
    {
        if ($css !== '' && $css !== null)
            if (filter_var($css, FILTER_VALIDATE_URL))
                return '<link rel="stylesheet" type="text/css" href="'.$css.'" >';
            else
                if (can_allocate(CSS, $css))
                    return '<link rel="stylesheet" type="text/css" href="'.string_for_allocate_file(CSS, $css).'" />';
        return '';
    }
    public static function allocate_js($js)
    {
        if ($js !== '' && $js !== null)
            if (filter_var($js, FILTER_VALIDATE_URL))
                return '<script src="'.$js.'" ></script>';
            else
                if (can_allocate(JS, $js))
                    return '<script src="'.string_for_allocate_file(JS, $js).'" ></script>';

        return '';
    }
    public static function allocate_jquery()
    {
        global $jquery_url;
        return Allocator::allocate_js($jquery_url);
    }
}