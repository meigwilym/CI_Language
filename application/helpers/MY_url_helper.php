<?php

/* Override CI current_url helper (from CI 1.7.0) */
function current_url()
{
    global $URI;
    $arr = explode('/', rtrim($URI->config->site_url(), '/') );
    if ($URI->config->item('language_abbr') == array_pop($arr)){
        return implode('/',$arr).$URI->uri_string();
	}
    return $URI->config->site_url($URI->uri_string());
}

/**
 * creates a unordered list of alternate language links
 * i.e. this page in these languages
 *
 * @param string $uri
 * @return string
 */
function alt_site_url($uri = '')
{
    $CI =& get_instance();

    $actual_lang = $CI->uri->segment(1);
    $languages = $CI->config->item('lang_desc');
    $languages_useimg = $CI->config->item('lang_useimg');
    $ignore_lang = $CI->config->item('lang_ignore');

    if (empty($actual_lang))
    {
        $uri = $ignore_lang.$CI->uri->uri_string();
        $actual_lang = $ignore_lang;
    }
    else
    {
        if (!array_key_exists($actual_lang, $languages))
        {
            $uri = $ignore_lang.$CI->uri->uri_string();
            $actual_lang = $ignore_lang;
        }
        else
        {
            $uri = $CI->uri->uri_string();
            $uri = substr_replace($uri, '', 0, 1);
        }
    }

    //$alt_url='<ul>';
    $alt_url = '';

    foreach ($languages as $lang => $lang_desc)
	{
         if ($actual_lang != $lang)
         {
            //$alt_url .= '<li><a href="' . $CI->config->item('base_url');
            $alt_url .= '<a href="' . $CI->config->item('base_url');
            if ($lang == $ignore_lang)
			{
                $new_uri = preg_replace('/^/'.$actual_lang, '', $uri);
                $new_uri = substr_replace($new_uri, '', 0, 1);
            }
			else
			{
                $new_uri = preg_replace('/^'.$actual_lang.'/', $lang,$uri);
            }
            $alt_url .= $new_uri.'">';

            if ($languages_useimg){
                //change the path on your needs
                //in images u need to have for example en.gif and so on for every
                //language u use
                //the language description will be used as alternative
                //$alt_url.= '<img src="'.base_url().'img/'.$lang.'.gif" alt="'.$lang_desc.'"></a></li>';
                $alt_url.= '<img src="'.base_url().'img/'.$lang.'.gif" alt="'.$lang_desc.'"></a>';
            }else{
                //$alt_url .= $lang_desc.'</a></li>';
                $alt_url .= $lang_desc.'</a>';
            }
         }
    }
    //$alt_url .= '</ul>';

    return $alt_url;
}

/* end of file: application/helpers/MY_url_helper.php */