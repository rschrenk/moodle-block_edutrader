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
 * @copyright  2019 Zentrum für Lermanagement (https://www.lernmanagement.at)
 * @author     Robert Schrenk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_edutrader;
defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . "/formslib.php");

class coursesettings_form extends \moodleform {
    public function definition() {
        global $courseid;
        $mform = $this->_form;
        $mform->addElement('hidden', 'courseid', 0);
        $mform->setType('courseid', PARAM_INT);
        $mform->setDefault('courseid', $courseid);
        $mform->addElement('html', '<h3>' . get_string('coursesettings', 'block_edutrader') . '</h3>');
        $mform->addElement('html', '<p>' . get_string('coursesettings:description', 'block_edutrader') . '</p>');
        $items = \block_edutrader\lib::get_items();
        $coursesettings = \block_edutrader\lib::get_coursesettings($courseid);

        foreach ($items as $item) {
            $id = 'allow_' . $item->itemid;
            $mform->addElement('advcheckbox', $id, $item->title);
            $mform->setDefault($id, !empty($coursesettings->config[$item->itemid]));
        }
        $this->add_action_buttons();
    }
}
