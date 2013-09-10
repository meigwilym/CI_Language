<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* URI Language Identifier
*
* Adds a language identifier prefix to all site_url links
*
* version 0.15 (c) Wiredesignz 2009-02-25
*/
class MY_Lang extends CI_Lang
{

    function __construct()
    {
        parent::__construct();

        global $RTR;

        $index_page    = $RTR->config->item('index_page');
        $lang_uri_abbr = $RTR->config->item('lang_uri_abbr');

        /* get the language from uri segment */
        $lang_abbr = $RTR->uri->segment(1);

        /*
		 *  check for invalid abbreviation */
        if( ! isset($lang_uri_abbr[$lang_abbr]))
        {
            $base_url  = $RTR->config->item('base_url');
            $deft_abbr = $RTR->config->item('language_abbr');

            /* check for abbreviation to be ignored */
            if ($deft_abbr != $RTR->config->item('lang_ignore'))
            {
                /* check and set the default uri identifier */
                $index_page .= ($index_page == '') ? "{$deft_abbr}" : "/{$deft_abbr}";

                $uri_string = $RTR->uri->uri_string;

                /* remove an invalid abbreviation from uri */
                if (strlen($lang_abbr) == 2)
                {
                    $uri_string = str_replace("/{$lang_abbr}", '', $uri_string);
                }

                /* redirect after inserting language id */
                header("Location:".$base_url.$index_page.$uri_string);
            }

            /* get the language name */
            $user_lang = $lang_uri_abbr[$deft_abbr];
        }
        else
        {
            /* get the language name */
            $user_lang = $lang_uri_abbr[$lang_abbr];

            /* reset config language to match the user language */
            $RTR->config->set_item('language', $user_lang);
            $RTR->config->set_item('language_abbr', $lang_abbr);

            /* check for abbreviation to be ignored */
            if ($lang_abbr != $RTR->config->item('lang_ignore'))
            {
                /* check and set the user uri identifier */
                $index_page .= ($index_page == '') ? "{$lang_abbr}" : "/{$lang_abbr}";
            }
        }

        /* reset the the config index_page value */
        $index_page .= ($index_page == '') ? '' : '/';

        $RTR->config->set_item('index_page', $index_page);
    }
} // EOC

/* ./application/libraries/MY_Language.php */