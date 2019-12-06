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

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/blocks/edutrader/locallib.php');

class block_edutrader extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_edutrader');
    }
    public function get_content() {
        global $CFG, $COURSE, $DB, $OUTPUT, $PAGE, $USER;

        $PAGE->requires->css('/blocks/edutrader/style/main.css');

        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = (object) array('footer' => '', 'text' => '');
        if (empty($COURSE->id) || $COURSE->id == 1) {
            $this->content->text = get_string('use_in_course_only', 'block_edutrader');
            return $this->content;
        }
        $credit = \block_edutrader\lib::get_credit($COURSE->id);

        $this->content->text .= $OUTPUT->render_from_template('block_edutrader/block', array('courseid' => $COURSE->id, 'credit' => $credit));


        return $this->content;
    }
    public function hide_header() {
        return false;
    }
    public function has_config() {
        return true;
    }
    public function instance_allow_multiple() {
        return false;
    }
}
