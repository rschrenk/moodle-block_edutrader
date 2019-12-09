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

/**
 * Checks if we can launch an item.
 * If we can not launch the item we should die().
 */
require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/blocks/edutrader/locallib.php');

if (!defined('block_edutrader_item')) {
    // We die here - we are never called directly!
    redirect($CFG->wwwroot . '/my');
    die();
}
if (!isloggedin() || isguestuser($USER)) {
    // We die here - we are never called directly!
    redirect($CFG->wwwroot . '/my');
    die();
}
$item = block_edutrader_item;
$redeem = optional_param('redeem', 0, PARAM_INT);
$courseid = optional_param('courseid', 0, PARAM_INT);
if (!empty($courseid)) {
    require_login(get_course($courseid));
    $context = \context_course::instance($COURSE->id);
} else {
    require_login();
    $context = \context_user::instance($USER->id);
}

// Must pass login
$PAGE->set_url('/blocks/edutrader/items/' . $item . '/index.php', array('courseid' => $courseid, 'redeem' => $redeem));
$PAGE->set_context($context);
$PAGE->set_title(get_string('stock', 'block_edutrader'));
$PAGE->set_heading(get_string('stock', 'block_edutrader'));
$PAGE->set_pagelayout('mydashboard');
$PAGE->requires->css('/blocks/edutrader/style/main.css');

$sessions = \block_edutrader\lib::get_sessions(0, $USER->id, $item);

if (count($sessions) > 0) {
    // Ok, we can start, but set a timer!!!
    header("refresh: " . $sessions[0]->timeleft);
} else {
    // Check if we have enough credit to launch.
    require_once($CFG->dirroot . '/blocks/edutrader/locallib.php');
    if (!empty($redeem)) {
        // User said yes to launch. Check if we have enough credit.
        if (empty($courseid)) {
            // Show warning
            echo $OUTPUT->header();
            echo $OUTPUT->render_from_template('block_edutrader/alert', array(
                'type' => 'danger',
                'content' => get_string('missing_courseid', 'block_edutrader'),
                'url' => $CFG->wwwroot . '/my',
            ));
            echo $OUTPUT->footer();
            die();
        } elseif (!\block_edutrader\lib::purchase_item($item, $courseid)) {
            // Show warning
            echo $OUTPUT->header();
            echo $OUTPUT->render_from_template('block_edutrader/alert', array(
                'type' => 'danger',
                'content' => 'Not enough credit',
                'url' => $CFG->wwwroot . '/my',
            ));
            echo $OUTPUT->footer();
            die();
        } else {
            // Ok, we can start, but set a timer!
            header("refresh: " . $sessions[0]->timeleft);
        }
    } else {
        $credit = \block_edutrader\lib::get_credit($courseid);
        $itemo = \block_edutrader\lib::get_item($item, $credit);
        echo $OUTPUT->header();
        echo $OUTPUT->render_from_template('block_edutrader/launch', array(
            'courseid' => $courseid,
            'credit' => $credit,
            'itemprice' => $itemo->price,
            'itemduration_human' => $itemo->duration_readable,
            'itempicture' => $itemo->picture,
            'itemtitle' => $itemo->title,
            'wwwroot' => $CFG->wwwroot,
        ));
        echo $OUTPUT->footer();
        die();
    }
}
