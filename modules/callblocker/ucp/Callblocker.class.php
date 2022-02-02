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
        //User information. Returned as an array.
        $this->user = $this->UCP->User->getUser();
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
            'rawname' => 'callblocker', //Module Rawname
            'display' => _('Call Blocker'), //The Widget Main Title
            'icon' => 'fa fa-ban', //The Widget Icon from http://fontawesome.io/icons/
            'list' => array() //List of Widgets this module provides
        );
        $widget['list']['control_panel'] = array(
            'display' => _('Control Panel'), //Widget Subtitle
            'description' => _('Call Blocker control panel'), //Widget description
            'hasSettings' => false, //Set to true if this widget has settings. This will make the cog (gear) icon display on the widget display
            'icon' => 'fa fa-cog', //If set the widget in on the side bar will use this icon instead of the category icon,
            'dynamic' => false, //If set to true then this widget can be added multiple times, if false then this widget can only be added once per dashboard!,
            'defaultsize' => array('height' => 2, 'width' => 2), //The default size of the widget when placed in the dashboard
            'minsize' => array('height' => 2, 'width' => 2), //The minimum size a widget can be when resized on the dashboard
            'noresize' => false //If set to true the widget will not be allowed to be resized
        );
        $widget['list']['call_history'] = array(
            'display' => _('Call History'), //Widget Subtitle
            'description' => _('Call history'), //Widget description
            'hasSettings' => false, //Set to true if this widget has settings. This will make the cog (gear) icon display on the widget display
            'icon' => 'fa fa-phone', //If set the widget in on the side bar will use this icon instead of the category icon,
            'dynamic' => false, //If set to true then this widget can be added multiple times, if false then this widget can only be added once per dashboard!,
            'defaultsize' => array('height' => 9, 'width' => 8), //The default size of the widget when placed in the dashboard
            'minsize' => array('height' => 2, 'width' => 2), //The minimum size a widget can be when resized on the dashboard
            'noresize' => false //If set to true the widget will not be allowed to be resized
        );
        $widget['list']['call_history_report'] = array(
            'display' => _('Call History Report'), //Widget Subtitle
            'description' => _('Call history report'), //Widget description
            'hasSettings' => false, //Set to true if this widget has settings. This will make the cog (gear) icon display on the widget display
            'icon' => 'fa fa-file-text-o', //If set the widget in on the side bar will use this icon instead of the category icon,
            'dynamic' => false, //If set to true then this widget can be added multiple times, if false then this widget can only be added once per dashboard!,
            'defaultsize' => array('height' => 9, 'width' => 8), //The default size of the widget when placed in the dashboard
            'minsize' => array('height' => 2, 'width' => 2), //The minimum size a widget can be when resized on the dashboard
            'noresize' => false //If set to true the widget will not be allowed to be resized
        );
        $widget['list']['blacklist'] = array(
            'display' => _('Blacklist'), //Widget Subtitle
            'description' => _('List of banned callers'), //Widget description
            'hasSettings' => false, //Set to true if this widget has settings. This will make the cog (gear) icon display on the widget display
            'icon' => 'fa fa-th-list', //If set the widget in on the side bar will use this icon instead of the category icon,
            'dynamic' => false, //If set to true then this widget can be added multiple times, if false then this widget can only be added once per dashboard!,
            'defaultsize' => array('height' => 9, 'width' => 8), //The default size of the widget when placed in the dashboard
            'minsize' => array('height' => 2, 'width' => 2), //The minimum size a widget can be when resized on the dashboard
            'noresize' => false //If set to true the widget will not be allowed to be resized
        );
        $widget['list']['whitelist'] = array(
            'display' => _('Whitelist'), //Widget Subtitle
            'description' => _('List of allowed callers'), //Widget description
            'hasSettings' => false, //Set to true if this widget has settings. This will make the cog (gear) icon display on the widget display
            'icon' => 'fa fa-list-ul', //If set the widget in on the side bar will use this icon instead of the category icon,
            'dynamic' => false, //If set to true then this widget can be added multiple times, if false then this widget can only be added once per dashboard!,
            'defaultsize' => array('height' => 9, 'width' => 8), //The default size of the widget when placed in the dashboard
            'minsize' => array('height' => 2, 'width' => 2), //The minimum size a widget can be when resized on the dashboard
            'noresize' => false //If set to true the widget will not be allowed to be resized
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
        return array();
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
            case 'control_panel':
                $displayvars = array(
                );
                $widget = array(
                    'title' => _('Control Panel'),
                    'html' => $this->load_view(__DIR__ . '/views/control_panel.php', $displayvars)
                );
                break;
            case 'call_history':
                $displayvars = array(
                    'ext' => $this->getExtension()
                );
                $widget = array(
                    'title' => _('Call History'),
                    'html' => $this->load_view(__DIR__ . '/views/call_history.php', $displayvars)
                );
                break;
            case 'call_history_report':
                $displayvars = array(
                    'ext' => $this->getExtension()
                );
                $widget = array(
                    'title' => _('Call History Report'),
                    'html' => $this->load_view(__DIR__ . '/views/call_history_report.php', $displayvars)
                );
                break;
            case 'blacklist':
                $displayvars = array(
                    'list' => 'blacklist'
                );
                $widget = array(
                    'title' => _('Blacklist'),
                    'html' => $this->load_view(__DIR__ . '/views/list.php', $displayvars)
                );
                break;
            case 'whitelist':
                $displayvars = array(
                    'list' => 'whitelist'
                );
                $widget = array(
                    'title' => _('Whitelist'),
                    'html' => $this->load_view(__DIR__ . '/views/list.php', $displayvars)
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
        return array();
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
        return array();
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
        return array('status' => true, 'items' => $items);
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
            case 'getList':
            case 'addListEntry':
            case 'updateListEntry':
            case 'deleteListEntry':
            case 'getCallHistory':
            case 'getCallHistoryReport':
            case 'getCallBlockerStatus':
            case 'setCallBlockerStatus':
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
            case 'getList':
                return $this->getList($_REQUEST['list']);
                break;
            case 'addListEntry':
                return $this->addListEntry($_REQUEST['list'], $_REQUEST['cid'], $_REQUEST['description']);
                break;
            case 'updateListEntry':
                return $this->updateListEntry($_REQUEST['list'], $_REQUEST['id'], $_REQUEST['cid'], $_REQUEST['description']);
                break;
            case 'deleteListEntry':
                return $this->deleteListEntry($_REQUEST['list'], $_REQUEST['id']);
                break;
            case 'getCallHistory':
                return $this->getCallHistory();
                break;
            case 'getCallHistoryReport':
                return $this->getCallHistoryReport();
                break;
            case 'getCallBlockerStatus':
                return $this->getCallBlockerStatus();
                break;
            case 'setCallBlockerStatus':
                return $this->setCallBlockerStatus($_REQUEST['value']);
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

    function getExtension() {
        $user = $this->UCP->User->getUser();
        $extensions = $this->UCP->getCombinedSettingByID($user['id'], 'Cdr', 'assigned');
        if (empty($extensions)) {
            return null;
        } else {
            return $extensions[0];
        }
    }

    function getMysqlConnection() {
        include '/etc/callblocker.conf';
        /** @noinspection PhpUndefinedVariableInspection */
        $mysqli = new \mysqli($servername, $username, $password);
        if ($mysqli->connect_error) {
            throw new \Exception('Connect failed: ' . $mysqli->connect_error);
        }
        return $mysqli;
    }

    function validateList($list) {
        if ($list == 'blacklist' or $list == 'whitelist') {
            return;
        }
        throw new \Exception('invalid list');
    }

    function getList($list) {
        $this->validateList($list);
        $mysqli = $this->getMysqlConnection();
        $entries = [];
        $query = "SELECT id, cid_number AS cid, description FROM callblocker.${list}";
        if ($result = $mysqli->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $entries[] = $row;
            }
            $result->close();
        }
        $mysqli->close();
        return $entries;
    }

    function addListEntry($list, $cid, $description) {
        $this->validateList($list);
        $mysqli = $this->getMysqlConnection();
        if ($stmt = $mysqli->prepare("INSERT INTO callblocker.${list} (cid_number, description) VALUES (?, ?)")) {
            $stmt->bind_param('ss', $cid, $description);
            $stmt->execute();
            $stmt->close();
        }
        $mysqli->close();
    }

    function updateListEntry($list, $id, $cid, $description) {
        $this->validateList($list);
        $mysqli = $this->getMysqlConnection();
        if ($stmt = $mysqli->prepare("UPDATE callblocker.${list} SET cid_number=?, description=? WHERE id=?")) {
            $stmt->bind_param('ssi', $cid, $description, $id);
            $stmt->execute();
            $stmt->close();
        }
        $mysqli->close();
    }

    function deleteListEntry($list, $id) {
        $this->validateList($list);
        $mysqli = $this->getMysqlConnection();
        if ($stmt = $mysqli->prepare("DELETE FROM callblocker.${list} WHERE id=?")) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
        }
        $mysqli->close();
    }

    function getCallHistory() {
        $limit = filter_var($_REQUEST['limit'], FILTER_SANITIZE_NUMBER_INT);
        $ext = $_REQUEST['extension'];
        $order = $_REQUEST['order'];
        $orderby = !empty($_REQUEST['sort']) ? $_REQUEST['sort'] : 'date';
        $search = !empty($_REQUEST['search']) ? $_REQUEST['search'] : '';
        $offset = filter_var($_REQUEST['offset'], FILTER_SANITIZE_NUMBER_INT);
        $page = ($offset / $limit) + 1;
        $total = $this->getTotalCalls($ext, $search);
        $data = $this->getCalls($ext, $page, $orderby, $order, $search, $limit);
        return array(
            'total' => $total,
            'rows' => $data
        );
    }

    function getTotalCalls($extension, $search = '') {
        $mysqli = $this->getMysqlConnection();
        $query = 'SELECT count(*) AS count FROM asteriskcdrdb.cdr WHERE dst=?';
        if (!empty($search)) {
            if ($stmt = $mysqli->prepare("${query} AND clid LIKE ?")) {
                $search_exp = "%${search}%";
                $stmt->bind_param('ss', $extension, $search_exp);
            }
        } else {
            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param('s', $extension);
            }
        }
        if ($stmt) {
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
        } else {
            $count = 0;
        }
        $mysqli->close();
        return $count;
    }

    function getCalls($extension, $page = 1, $orderby = 'date', $order = 'desc', $search = '', $limit = 100) {
        $mysqli = $this->getMysqlConnection();
        $start = ($limit * ($page - 1));
        $end = $limit;
        switch ($orderby) {
            case 'cid':
                $order_by = 'cid';
                break;
            case 'description':
                $order_by = 'clid';
                break;
            case 'duration':
                $order_by = 'duration';
                break;
            case 'disposition':
                $order_by = 'disposition';
                break;
            case 'date':
            default:
                $order_by = 'timestamp';
                break;
        }
        $order = ($order == 'desc') ? 'desc' : 'asc';
        $query = <<<'EOT'
SELECT 
    UNIX_TIMESTAMP(cdr.calldate) AS timestamp,
    cdr.src AS cid,
    cdr.clid AS clid,
    cdr.duration AS duration,
    cdr.userfield AS disposition,
    blacklist.cid_number IS NOT NULL AS blacklisted,
    blacklist.description AS blacklistDescription,
    whitelist.cid_number IS NOT NULL AS whitelisted,
    whitelist.description AS whitelistDescription
FROM
    asteriskcdrdb.cdr cdr
        LEFT JOIN
    callblocker.blacklist blacklist ON cdr.src = blacklist.cid_number COLLATE utf8mb4_general_ci
        LEFT JOIN
    callblocker.whitelist whitelist ON cdr.src = whitelist.cid_number COLLATE utf8mb4_general_ci
WHERE
    dst = ?
EOT;
        $query_suffix = "ORDER BY $order_by ${order} LIMIT ?,?";
        if (!empty($search)) {
            if ($stmt = $mysqli->prepare("${query} AND clid LIKE ? ${query_suffix}")) {
                $search_exp = "%${search}%";
                $stmt->bind_param('ssii', $extension, $search_exp, $start, $end);
            }
        } else {
            if ($stmt = $mysqli->prepare("${query} ${query_suffix}")) {
                $stmt->bind_param('sii', $extension, $start, $end);
            }
        }
        $calls = [];
        if ($stmt) {
            $stmt->execute();
            $stmt->bind_result(
                $timestamp, $cid, $clid, $duration, $disposition, $blacklisted, $blacklistDescription, $whitelisted,
                $whitelistDescription
            );
            while ($stmt->fetch()) {
                $calls[] = array(
                    'timestamp' => $timestamp,
                    'cid' => $cid,
                    'clid' => $clid,
                    'duration' => $duration,
                    'disposition' => $disposition,
                    'blacklisted' => $blacklisted == 1,
                    'blacklistDescription' => $blacklistDescription,
                    'whitelisted' => $whitelisted == 1,
                    'whitelistDescription' => $whitelistDescription
                );
            }
            $stmt->close();
        }
        $mysqli->close();
        foreach ($calls as &$call) {
            if ($call['duration'] > 59) {
                $min = floor($call['duration'] / 60);
                if ($min > 59) {
                    $call['niceDuration'] = sprintf(_('%s hour, %s min, %s sec'), gmdate('H', $call['duration']), gmdate('i', $call['duration']), gmdate('s', $call['duration']));
                } else {
                    $call['niceDuration'] = sprintf(_('%s min, %s sec'), gmdate('i', $call['duration']), gmdate('s', $call['duration']));
                }
            } else {
                $call['niceDuration'] = sprintf(_('%s sec'), $call['duration']);
            }
            $call['formattedTime'] = $this->UCP->View->getDateTime($call['timestamp']);
            $call['description'] = $this->getDescription($call['clid']);
            unset($call['clid']);
            if (!is_null($call['whitelistDescription'])) {
                $altDescription = $call['whitelistDescription'];
            } elseif (!is_null($call['blacklistDescription'])) {
                $altDescription = $call['blacklistDescription'];
            } else {
                $altDescription = null;
            }
            $call['altDescription'] = $altDescription;
            unset($call['whitelistDescription']);
            unset($call['blacklistDescription']);
        }
        return $calls;
    }

    function getCallHistoryReport() {
        $extension = $this->getExtension();
        $mysqli = $this->getMysqlConnection();
        $query = <<<'EOT'
SELECT 
    COUNT(*) AS count, YEAR(calldate) AS year, src AS cid, clid, userfield AS disposition
FROM
    asteriskcdrdb.cdr
WHERE
    dst = ?
GROUP BY year, src, clid, userfield
EOT;
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('s', $extension);
        }
        $calls = [];
        if ($stmt) {
            $stmt->execute();
            $stmt->bind_result($count, $year, $cid, $clid, $disposition);
            while ($stmt->fetch()) {
                $calls[] = array(
                    'count' => $count,
                    'year' => $year,
                    'cid' => $cid,
                    'clid' => $clid,
                    'disposition' => $disposition,
                );
            }
            $stmt->close();
        }
        $mysqli->close();
        $report = [];
        foreach ($calls as $call) {
            $year = $call['year'];
            $description = $this->getDescription($call['clid']);
            if (!array_key_exists($year, $report)) {
                $report[$year] = [];
            }
            $year_records = &$report[$year];
            $found_record = false;
            foreach ($year_records as &$record) {
                if ($record['cid'] == $call['cid'] and $record['disposition'] == $call['disposition']) {
                    $record['count'] += $call['count'];
                    $record['description'][] = $description;
                    $found_record = true;
                    break;
                }
            }
            if (!$found_record) {
                unset($call['year']);
                unset($call['clid']);
                $call['description'] = [$description];
                $year_records[] = $call;
            }
        }
        return $report;
    }

    function getDescription($clid) {
        return trim(preg_replace('/ <.*>$/', '', $clid), '"');
    }

    function getCallBlockerStatus() {
        $mysqli = $this->getMysqlConnection();
        $result = $mysqli->query("SELECT value FROM callblocker.settings WHERE name='enabled'");
        $row = $result->fetch_assoc();
        $enabled = $row['value'] == 'true';
        $mysqli->close();
        return array(
            'enabled' => $enabled
        );
    }

    function setCallBlockerStatus($value) {
        $mysqli = $this->getMysqlConnection();
        if ($stmt = $mysqli->prepare("UPDATE callblocker.settings SET value=? WHERE name='enabled'")) {
            $stmt->bind_param('s', $value);
            $stmt->execute();
            $stmt->close();
        }
        $mysqli->close();
    }
}
