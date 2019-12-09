<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    block_edutrader
 * @copyright  2019 Zentrum für Lernmanagement (www.lernmanagement.at)
 * @author     Robert Schrenk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_edutrader;

defined('MOODLE_INTERNAL') || die;

class lib {
    private static $items;
    /**
     * Get credit for this user.
     * @param userid, if not set use $USER->id
     */
    public static function get_credit($userid = 0) {
        global $DB, $USER;
        if (empty($userid)) $userid = $USER->id;
        $sql = "SELECT x.id,x.xp,tc.creditredeemed
                    FROM {block_xp} x
                    LEFT JOIN {block_edutrader_credit} tc ON
                        x.userid = tc.userid
                    WHERE x.userid = ".$userid;

        $rows = array_values($DB->get_records_sql($sql, array($userid)));
        $credit = 0;
        foreach($rows AS $row) {
            $credit += $row->xp - $row->creditredeemed;
        }
        return $credit;
    }
    /**
     * Return a single item
     * @param id identifier of item
     * @param credit of a user.
     */
    public static function get_item($id, $credit = 0) {
        global $CFG, $DB;
        $items = self::get_items($credit);
        foreach ($items AS $item) {
            if ($item->itemid == $id) return $item;
        }
    }
    /**
     * Return items directly from config file.
     * @param credit of a user.
     */
    public static function get_items($credit = 0) {
        global $CFG, $DB;
        $items = array_values($DB->get_records('block_edutrader_items', array()));
        foreach ($items AS &$item) {
            $item->duration_readable = self::readable_duration($item->duration);
            $item->title = get_string('itemtitle', 'local_edutrader' . $item->itemid);
            $item->picture = $CFG->wwwroot . '/local/edutrader' . $item->itemid . '/pix/cover.png';
            //$item->duration_human = self::readable_duration($item->duration);
            if (!empty($credit)) {
                $item->canpurchase = floor($credit / $item->price);
            }
        }
        return $items;
    }
    /**
     * Get sessions for a user.
     * @param userid or 0 for current user.
     * @param itemid or empty for all items.
     */
    public static function get_sessions($userid = 0, $itemid = '') {
        global $DB, $USER;
        if (empty($userid)) $userid = $USER->id;
        $sql = "SELECT *
                    FROM {block_edutrader_trades}
                    WHERE userid = ?
                        AND maturity > ?";
        $params = array($userid, time());
        if (!empty($itemid)) {
            $sql .= "AND item = ?";
            $params[] = $itemid;
        }
        $sessions = array_values($DB->get_records_sql($sql, $params));
        foreach ($sessions AS &$session) {
            $item = self::get_item($session->item);
            $session->identifier = $item->identifier;
            $session->title = $item->title;
            $session->timeleft = $session->maturity - time();
            $session->timeleft_readable = self::readable_duration($session->maturity - time());
        }
        return $sessions;
    }

    /**
     * Purchase an item.
     * @itemid id of item.
     * @userid userid to purchase for, if current user 0.
     */
    public static function purchase_item($itemid, $userid = 0) {
        if (empty($userid)) {
            global $USER;
            $userid = $USER->id;
        }
        $credit = \block_edutrader\lib::get_credit($userid);
        $itemo = \block_edutrader\lib::get_item($itemid);
        if ($credit > $itemo->price) {
            global $DB;
            $trade = (object) array(
                'userid' => $userid,
                'item' => $itemid,
                'credit' => $itemo->price,
                'maturity' => (time() + $itemo->duration),
                'created' => time()
            );
            $trade->id = $DB->insert_record('block_edutrader_trades', $trade);
            if (!empty($trade->id)) {
                $rec = $DB->get_record('block_edutrader_credit', array('userid' => $userid));
                if (empty($rec->id)) {
                    $rec = (object) array(
                        'userid' => $userid,
                        'creditredeemed' => $itemo->price
                    );
                    $DB->insert_record('block_edutrader_credit', $rec);
                } else {
                    $rec->creditredeemed += $itemo->price;
                    $DB->update_record('block_edutrader_credit', $rec);
                }
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    /**
     * Converts a duration to a human readable time range.
     * @param seconds
     */
    public static function readable_duration($seconds) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        $tx = get_strings(array('t_seconds', 't_minutes', 't_hours', 't_days'), 'block_edutrader');
        $diff = $dtF->diff($dtT);
        if ($diff->d > 0) {
            return $diff->format('%a ' . $tx->t_days . ' %h ' . $tx->t_hours . ' %i ' . $tx->t_minutes . ' %s ' . $tx->t_seconds);
        }
        if ($diff->h > 0) {
            return $diff->format('%h ' . $tx->t_hours . ' %i ' . $tx->t_minutes . ' %s ' . $tx->t_seconds);
        }
        if ($diff->i > 0) {
            return $diff->format('%i ' . $tx->t_minutes . ' %s ' . $tx->t_seconds);
        }
        return $diff->format('%s ' . $tx->t_seconds);
    }
}
