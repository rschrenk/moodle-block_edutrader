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
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_edutrader;

/**
 * Configure course specific settings.
 */
require_once('../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/blocks/edutrader/locallib.php');

// This triggers if we use credit from one course only.
$courseid = required_param('courseid', PARAM_INT);
require_login(get_course($courseid));

$context = \context_course::instance($courseid);
// Must pass login
$PAGE->set_url('/blocks/edutrader/coursesettings.php', array('courseid' => $courseid));
$PAGE->set_context($context);
$PAGE->set_title(get_string('stock', 'block_edutrader'));
$PAGE->set_heading(get_string('stock', 'block_edutrader'));
$PAGE->set_pagelayout('incourse');
$PAGE->requires->css('/blocks/edutrader/style/main.css');

echo $OUTPUT->header();

if (!lib::is_trainer($courseid)) {
    $OUTPUT->render_from_template('block_edutrader/alert', array(
        'content' => get_string('missing_capability', 'block_edutrader'),
        'type' => 'danger',
        'url' => $CFG->wwwroot . '/course/view.php?id=' . $courseid,
    ));
} else {
    // Show form.
    require_once($CFG->dirroot . '/blocks/edutrader/classes/coursesettings_form.php');
    $form = new coursesettings_form();
    if ($form->is_cancelled()) {
        redirect(new \moodle_url('/course/view.php', array('id' => $courseid)));
    } elseif ($data = $form->get_data()) {
        $config = array();
        $items = lib::get_items();
        foreach ($items AS $item) {
            $config[$item->itemid] = $data->{'allow_' . $item->itemid};
        }
        lib::set_coursesettings($courseid, $config);
        $form = new coursesettings_form();
    }
    $form->display();
}

echo $OUTPUT->footer();
