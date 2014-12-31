<?php
/**
 * StatusNet - the distributed open-source microblogging tool
 * Copyright (C) 2009, StatusNet, Inc.
 *
 * A module which converts emoji characters to emoticon images.
 *
 * PHP version 5
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category  Contents
 * @package   StatusNet
 * @author    Dean <dean@matuera.net>
 * @copyright 2014
 * @license   http://www.fsf.org/licensing/licenses/agpl-3.0.html AGPL 3.0
 * @link      http://status.net/
 */

if (!defined('STATUSNET')) {
    // This check helps protect against security problems;
    // your code file can't be executed directly from the web.
    exit(1);
}

/**
 * Plugin main class
 *
 * @category  Contents
 * @package   StatusNet
 * @author    Dean <dean@matuera.net>
 * @copyright 2014
 * @license   http://www.fsf.org/licensing/licenses/agpl-3.0.html AGPL 3.0
 * @link      http://status.net/
 */
class EmoticonPlugin extends Plugin
{
    public function initialize()
    {
        parent::initialize();
        require_once(dirname(__FILE__) . '/extlib/php-emoji/emoji.php');
    }

    public function onEndShowStyles($action)
    {
        $action->cssLink($this->path('extlib/php-emoji/emoji.css'));
        return true;
    }

    public function onStartShowNoticeContent(Notice $stored, HTMLOutputter $out, Profile $scoped = null)
    {
        $stored->rendered = $this->emojify($stored->rendered);
        return true;
    }
    
    function onPluginVersion(&$versions)
    {
        $versions[] = array('name' => 'Emoticon',
                            'version' => GNUSOCIAL_VERSION,
                            'author' => 'Dean',
                            'homepage' => 'http://status.net/wiki/Plugin:Sample',
                            'rawdescription' =>
                          // TRANS: Plugin description.
                            _m('A plugin which modifies emoticon characters into images.'));
        return true;
    }

    private function emojify($data)
    {
        //first do all UTF-8 characters
        $data = emoji_unified_to_html($data);

        //do some manual changes to recognize emoticons
        $search = array(
            ':-)',
            ':)',
            ':-(',
            ':(',
            ':-|',
            ':|',
            ':\'-(',
            ':\'(',
            ':-$',
            ':$',
        );
        $replace = array(
            '<span class="emoji emoji1f603"></span>',
            '<span class="emoji emoji1f603"></span>',
            '<span class="emoji emoji1f629"></span>',
            '<span class="emoji emoji1f629"></span>',
            '<span class="emoji emoji1f612"></span>',
            '<span class="emoji emoji1f612"></span>',
            '<span class="emoji emoji1f622"></span>',
            '<span class="emoji emoji1f622"></span>',
            '<span class="emoji emoji1f633"></span>',
            '<span class="emoji emoji1f633"></span>'
        );

        return str_replace($search, $replace, $data);
    }
}
