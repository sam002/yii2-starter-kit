<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 28.11.16
 * Time: 15:29
 */

namespace common\assets;


class oauthHelper
{
    public static function socialIcon($provider)
    {
        $icon = '';
        switch ($provider) {
            case 'vkontakte':
                $icon = 'fa fa-2x fa-vk';
                break;
            case 'github':
                $icon = 'fa fa-2x fa-github';
                break;
            case 'google':
                $icon = 'fa fa-2x fa-google';
                break;
            case 'facebook':
                $icon = 'fa fa-2x fa-facebook';
                break;
        }
                return $icon;
    }

}
