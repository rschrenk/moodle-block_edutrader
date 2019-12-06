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
    public static function get_items() {
        if (empty($items)) {
            global $CFG;
            require_once($CFG->dirroot . '/blocks/edutrader/classes/item_definition.php');
            self::$items = $items;
        }
        return self::$items;
    }
    /**
     * Get credit for this user.
     * @param courseid for a particular course only, or all courses.
     */
    public static function get_credit($courseid = 0) {
        global $DB, $USER;
        $params = array('userid' => $USER->id);
        if (!empty($courseid)) $params['courseid'] = $courseid;
        $exp = $DB->get_record('block_xp', $params);
        $redeemed = $DB->get_record('block_edutrader_credit', $params);
        $credit = 0;
        if (!empty($exp->xp) && !empty($redeemed->creditredeemed)) $credit = $exp->xp - $redeemed->creditredeemed;
        elseif (!empty($exp->xp)) $credit = $exp->xp;
        return $credit;
    }
}
