<?php
/**
 * This is the User Control Panel Object.
 *
 * Copyright (C) 2016 Sangoma Communications
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package   FreePBX UCP BMO
 * @author   James Finstrom <jfinstrom@sangoma.com>
 * @license   AGPL v3
 */

namespace UCP\Modules;

use \UCP\Modules as Modules;

class Callblocker extends Modules {
    protected $module = 'Callblocker';

    public function __construct($Modules) {
        //User information. Returned as an array. See:
        $this->user = $this->UCP->User->getUser();
        //Access any FreePBX enabled module or BMO object
        $core = $this->UCP->FreePBX->Core;
        //Access any UCP Function.
        $ucp = $this->UCP;
        //Access any UCP module
        $modules = $this->Modules = $Modules;
        //Asterisk Manager. See: https://wiki.freepbx.org/display/FOP/Asterisk+Manager+Class
        $this->astman = $this->UCP->FreePBX->astman;
        //Setting retrieved from the UCP Interface in User Manager in Admin
        $this->enabled = $this->UCP->getCombinedSettingByID($this->user['id'], $this->module, 'enabled');
    }

    /**
     * Get Simple Widget List
     *
     * @method getSimpleWidgetList
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-getSimpleWidgetList
     * @return array Array of information
     */
    public function getSimpleWidgetList() {
        return array();
        //Category for the widgets
//		$widget = array(
//			"rawname" => "callblocker", //Module Rawname
//			"display" => _("UCP Module callblocker"), //The Widget Main Title
//			"icon" => "fa fa-globe", //The Widget Icon from http://fontawesome.io/icons/
//			"list" => array() //List of Widgets this module provides
//		);
//		//Individual Widgets
//		$widget['list']["willy"] = array(
//			"display" => _("Willy the Widget"), //Widget Subtitle
//			"description" => _("Willy dreamed of being a widget all of his life"), //Widget description
//			"hasSettings" => true, //Set to true if this widget has settings. This will make the cog (gear) icon display on the widget display
//			"icon" => "fa fa-male", //If set the widget in on the side bar will use this icon instead of the category icon,
//			"dynamic" => true //If set to true then this widget can be added multiple times, if false then this widget can only be added once per dashboard!
//		);
//		return $widget;
    }


    /**
     * Get Widget List
     *
     * @method getWidgetList
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-getWidgetList
     * @return array Array of information
     */
    public function getWidgetList() {
        $widget = array(
            "rawname" => "callblocker", //Module Rawname
            "display" => _("Call Blocker"), //The Widget Main Title
            "icon" => "fa fa-ban", //The Widget Icon from http://fontawesome.io/icons/
            "list" => array() //List of Widgets this module provides
        );
        //Individual Widgets
        $widget['list']["blacklist"] = array(
            "display" => _("Blacklist"), //Widget Subtitle
            "description" => _("List of banned callers"), //Widget description
            "hasSettings" => false, //Set to true if this widget has settings. This will make the cog (gear) icon display on the widget display
            "icon" => "fa fa-th-list", //If set the widget in on the side bar will use this icon instead of the category icon,
            "dynamic" => false, //If set to true then this widget can be added multiple times, if false then this widget can only be added once per dashboard!,
            "defaultsize" => array("height" => 9, "width" => 8), //The default size of the widget when placed in the dashboard
            "minsize" => array("height" => 2, "width" => 2), //The minimum size a widget can be when resized on the dashboard
            "noresize" => false //If set to true the widget will not be allowed to be resized
        );
        $widget['list']["whitelist"] = array(
            "display" => _("Whitelist"), //Widget Subtitle
            "description" => _("List of allowed callers"), //Widget description
            "hasSettings" => false, //Set to true if this widget has settings. This will make the cog (gear) icon display on the widget display
            "icon" => "fa fa-list-ul", //If set the widget in on the side bar will use this icon instead of the category icon,
            "dynamic" => false, //If set to true then this widget can be added multiple times, if false then this widget can only be added once per dashboard!,
            "defaultsize" => array("height" => 9, "width" => 8), //The default size of the widget when placed in the dashboard
            "minsize" => array("height" => 2, "width" => 2), //The minimum size a widget can be when resized on the dashboard
            "noresize" => false //If set to true the widget will not be allowed to be resized
        );
        return $widget;
    }


    /**
     * Get Simple Widget Display
     *
     * @method getWidgetDisplay
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-getSimpleWidgetDisplay
     * @param  string $id The widget id. This is the key of the 'list' array in getSimpleWidgetList
     * @param  string $uuid The generated UUID of the widget on this dashboard
     * @return array Array of information
     */
    public function getSimpleWidgetDisplay($id, $uuid) {
        $widget = array();
        switch ($id) {
            case "willy":
                $displayvars = array(
                    "name" => "Whilly", //widget name
                    "timezone" => $this->UCP->View->getTimezone(), //User's Timezone, set in User Manager
                    "locale" => $this->UCP->View->getLocale(), //User's Locale, set in User Manager
                    "date" => $this->UCP->View->getDate(time()), //User's Date, set in User Manager
                    "time" => $this->UCP->View->getTime(time()), //User's Time, set in User Manager
                    "datetime" => $this->UCP->View->getDateTime(time()) //User's Date/Time, set in User Manager
                );
                $widget = array(
                    'title' => _("Follow Me"),
                    'html' => $this->load_view(__DIR__ . '/views/willy.php', $displayvars)
                );
                break;
        }
        return $widget;
    }

    /**
     * Get Widget Display
     *
     * @method getWidgetDisplay
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-getSimpleWidgetDisplay
     * @param  string $id The widget id. This is the key of the 'list' array in getWidgetList
     * @param  string $uuid The UUID of the widget
     * @return array Array of information
     */
    public function getWidgetDisplay($id, $uuid) {
        $widget = array();
        switch ($id) {
            case "whitelist":
                $displayvars = array(
                    "name" => "Whilly", //widget name
                    "timezone" => $this->UCP->View->getTimezone(), //User's Timezone, set in User Manager
                    "locale" => $this->UCP->View->getLocale(), //User's Locale, set in User Manager
                    "date" => $this->UCP->View->getDate(time()), //User's Date, set in User Manager
                    "time" => $this->UCP->View->getTime(time()), //User's Time, set in User Manager
                    "datetime" => $this->UCP->View->getDateTime(time()) //User's Date/Time, set in User Manager
                );
                $widget = array(
                    'title' => _("Willy Module"), //widget name
                    'html' => $this->load_view(__DIR__ . '/views/whitelist.php', $displayvars)
                );
                break;
        }
        return $widget;
    }

    /**
     * Get Widget Settings Display
     *
     * @method getWidgetDisplay
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-getWidgetSettingsDisplay
     * @param  string $id The widget id. This is the key of the 'list' array in getWidgetList
     * @param  string $uuid The UUID of the widget
     * @return array Array of information
     */
    public function getWidgetSettingsDisplay($id, $uuid) {
        $displayvars = array();
        $widget = array();
        switch ($id) {
            case "willy":
                $displayvars = array(
                    "name" => "Whilly", //widget name
                    "timezone" => $this->UCP->View->getTimezone(), //User's Timezone, set in User Manager
                    "locale" => $this->UCP->View->getLocale(), //User's Locale, set in User Manager
                    "date" => $this->UCP->View->getDate(time()), //User's Date, set in User Manager
                    "time" => $this->UCP->View->getTime(time()), //User's Time, set in User Manager
                    "datetime" => $this->UCP->View->getDateTime(time()) //User's Date/Time, set in User Manager
                );
                $widget = array(
                    'title' => _("Whilly Module"), //widget name
                    'html' => $this->load_view(__DIR__ . '/views/willy.php', $displayvars)
                );
                break;
        }
        return $widget;
    }

    /**
     * Get Simple Widget Settings Display
     *
     * @method getSimpleWidgetDisplay
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-getSimpleWidgetSettingsDisplay
     * @param  string $id The widget id. This is the key of the 'list' array in getWidgetList
     * @param  string $uuid The UUID of the widget
     * @return array Array of information
     */
    public function getSimpleWidgetSettingsDisplay($id, $uuid) {
        $displayvars = array();
        $widget = array();
        switch ($id) {
            case "willy":
                $displayvars = array(
                    "name" => "Whilly", //widget name
                    "timezone" => $this->UCP->View->getTimezone(), //User's Timezone, set in User Manager
                    "locale" => $this->UCP->View->getLocale(), //User's Locale, set in User Manager
                    "date" => $this->UCP->View->getDate(time()), //User's Date, set in User Manager
                    "time" => $this->UCP->View->getTime(time()), //User's Time, set in User Manager
                    "datetime" => $this->UCP->View->getDateTime(time()) //User's Date/Time, set in User Manager
                );
                $widget = array(
                    'title' => _("Follow Me"), //widget name
                    'html' => $this->load_view(__DIR__ . '/views/willy.php', $displayvars)
                );
                break;
        }
        return $widget;
    }

    /**
     * Display a Tab in the user settings modal
     *
     * @method getUserSettingsDisplay
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-getUserSettingsDisplay
     * @return array Array of information
     */
    function getUserSettingsDisplay() {
        return array();
//        $displayvars = array(
//            "timezone" => $this->UCP->View->getTimezone(), //User's Timezone, set in User Manager
//            "locale" => $this->UCP->View->getLocale(), //User's Locale, set in User Manager
//            "date" => $this->UCP->View->getDate(time()), //User's Date, set in User Manager
//            "time" => $this->UCP->View->getTime(time()), //User's Time, set in User Manager
//            "datetime" => $this->UCP->View->getDateTime(time()) //User's Date/Time, set in User Manager
//        );
//        return array(
//            array(
//                "rawname" => "callblocker", // Module rawname
//                "name" => _("callblocker Settings"), //The Tab's Title
//                'html' => $this->load_view(__DIR__ . '/views/user_settings.php', $displayvars)
//            )
//        );
    }


    /**
     * Poll for information
     *
     * @method poll
     * @link https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-poll(PHP)
     * @param $data Data from Javascript prepoll function (if any). See: https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-prepoll
     * @return mixed Data you'd like to send back to the javascript for this module. See: https://wiki.freepbx.org/pages/viewpage.action?pageId=71271742#DevelopingforUCP14+-poll(Javascript)
     */
    public function poll($data) {
        $items = array();
        if (is_array($data)) {
            foreach ($data as $id => $value) {
                $items[$id] = $value * 2;
            }
        }
        return array("status" => true, "items" => $items);
    }


    /**
     * Ajax Request
     *
     * @method ajaxRequest
     * @link https://wiki.freepbx.org/display/FOP/BMO+Ajax+Calls#BMOAjaxCalls-ajaxRequest
     * @param  string $command The command name
     * @param  array $settings Returned array settings
     * @return boolean True if allowed or false if not allowed
     */
    public function ajaxRequest($command, $settings) {
        switch ($command) {
            case 'grid':
            case 'addWhitelistEntry':
            case 'updateWhitelistEntry':
            case 'deleteWhitelistEntry':
                return true;
            default:
                return false;
                break;
        }
    }

    /**
     * Ajax Handler
     *
     * @method ajaxHandler
     * @link https://wiki.freepbx.org/display/FOP/BMO+Ajax+Calls#BMOAjaxCalls-ajaxHandler
     * @return mixed Data to return to Javascript
     */
    public function ajaxHandler() {
        switch ($_REQUEST['command']) {
            case 'grid':
                return $this->getWhitelist();
                break;
            case 'addWhitelistEntry':
                return $this->addWhitelistEntry($_REQUEST['cid'], $_REQUEST['description']);
                break;
            case 'updateWhitelistEntry':
                return $this->updateWhitelistEntry($_REQUEST['id'], $_REQUEST['cid'], $_REQUEST['description']);
                break;
            case 'deleteWhitelistEntry':
                return $this->deleteWhitelistEntry($_REQUEST['id']);
                break;
            default:
                return false;
                break;
        }
    }


    /**
     * The Handler for unprocessed commands
     *
     * @method ajaxCustomHandler
     * @link https://wiki.freepbx.org/display/FOP/BMO+Ajax+Calls#BMOAjaxCalls-ajaxCustomHandler
     * @return mixed Output if success, otherwise false will generate a 500 error serverside
     */
    function ajaxCustomHandler() {
        return false;
    }

    function get_mysql_connection() {
        include '/etc/callblocker.conf';
        /** @noinspection PhpUndefinedVariableInspection */
        $mysqli = new \mysqli($servername, $username, $password);
        if ($mysqli->connect_error) {
            throw new \Exception("Connect failed: " . $mysqli->connect_error);
        }
        return $mysqli;
    }

    function getWhitelist() {
        $mysqli = $this->get_mysql_connection();
        $whitelist = [];
        $query = "SELECT id, cid_number AS cid, description FROM callblocker.whitelist";
        if ($result = $mysqli->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $whitelist[] = $row;
            }
            $result->close();
        }
        $mysqli->close();
        return $whitelist;
    }

    function addWhitelistEntry($cid, $description) {
        $mysqli = $this->get_mysql_connection();
        if ($stmt = $mysqli->prepare("INSERT INTO callblocker.whitelist (cid_number, description) VALUES (?, ?)")) {
            $stmt->bind_param("ss", $cid, $description);
            $stmt->execute();
            $stmt->close();
        }
        $mysqli->close();
    }

    function updateWhitelistEntry($id, $cid, $description) {
        $mysqli = $this->get_mysql_connection();
        if ($stmt = $mysqli->prepare("UPDATE callblocker.whitelist SET cid_number=?, description=? WHERE id=?")) {
            $stmt->bind_param("ssi", $cid, $description, $id);
            $stmt->execute();
            $stmt->close();
        }
        $mysqli->close();
    }

    function deleteWhitelistEntry($id) {
        $mysqli = $this->get_mysql_connection();
        if ($stmt = $mysqli->prepare("DELETE FROM callblocker.whitelist WHERE id=?")) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
        $mysqli->close();
    }
}
