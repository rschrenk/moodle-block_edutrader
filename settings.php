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
 * @copyright  2019 Zentrum für Lernmanagement (https://www.lernmanagement.at)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $items = $DB->get_records('block_edutrader_items', array(), 'title ASC', '*');
    foreach ($items as $item) {
        $settings->add(
            new admin_setting_configcheckbox(
                'local_edutrader' . $item->itemid . '/enabled',
                get_string('toggle_item_enabled', 'block_edutrader', $item),
                get_string('toggle_item_enabled:description', 'block_edutrader', $item),
                1
            )
        );
    }
}
