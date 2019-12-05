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
 * Lists all available items.
 * item
 * -> pix: a screenshot
 * -> title: the title to show
 * -> type: gametype for filters
 * -> price: how much funnies are required
 * -> duration: how many seconds can we use the item for the price paid?
 */

$items = array(
    'super_chrono_portal_maker' = array(
        'pix' => 'an_image_here',
        'title' => 'Super Chrono Portal Maker',
        'type' => 'Jump & Run',
        'price' => 100,
        'duration' => 600,
    ),
);
