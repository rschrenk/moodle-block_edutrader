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

/*
 * Show a list of all items in stock and if we can purchase them.
 */
require_once('../../config.php');
require_once($CFG->libdir . '/adminlib.php');

// This triggers if we use credit from one course only.
$courseid = required_param('courseid', PARAM_INT);
require_login(get_course($courseid));

$context = \context_course::instance($courseid);
// Must pass login.
$PAGE->set_url('/blocks/edutrader/stock.php', array('courseid' => $courseid));
$PAGE->set_context($context);
$PAGE->set_title(get_string('stock', 'block_edutrader'));
$PAGE->set_heading(get_string('stock', 'block_edutrader'));
$PAGE->set_pagelayout('incourse');
$PAGE->requires->css('/blocks/edutrader/style/main.css');

echo $OUTPUT->header();

$credit = \block_edutrader\lib::get_credit();
$items = \block_edutrader\lib::get_items($credit);
$sessions = \block_edutrader\lib::get_sessions();

foreach ($items as &$item) {
    $item->is_available = \block_edutrader\lib::is_available($item->itemid, $courseid);
}

echo $OUTPUT->render_from_template(
    'block_edutrader/stock',
    array(
        'courseid' => $courseid, 'credit' => $credit,
        'hassessions' => count($sessions), 'items' => $items,
        'sessions' => $sessions
    )
);

echo $OUTPUT->footer();
