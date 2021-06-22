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
 * @package   tool_excimer
 * @author    Nigel Chapman <nigelchapman@catalyst-au.net>
 * @copyright 2021, Catalyst IT
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
defined('MOODLE_INTERNAL') || die();
 
$plugin->version = 2021061600;  // <-- Plugin released 8th June 2021
$plugin->requires = 2019052006;  // <-- Our lowest supported Moodle (3.7.6)
//  $plugin->supported = TODO;   // Available as of Moodle 3.9.0 or later.
//  $plugin->incompatible = ;   // Available as of Moodle 3.9.0 or later.
$plugin->component = 'tool_excimer';
$plugin->maturity = MATURITY_ALPHA;
$plugin->release = 'v3.7-r1';
 
$plugin->dependencies = [];