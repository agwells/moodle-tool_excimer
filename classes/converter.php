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

namespace tool_excimer;

defined('MOODLE_INTERNAL') || die();

/**
 * Converts flamegraph data from the format given by ExcimerLog to the format required by D3.
 *
 * @package   tool_excimer
 * @author    Jason den Dulk <jasondendulk@catalyst-au.net>
 * @copyright 2021, Catalyst IT
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class converter {

    /**
     * Processes flamegraph data from the format given by ExcimerLog to the format required by D3.
     *
     * @param string $data Input data in the format typically y the command line flamegraph
     * @param string $rootname Name for the root node. Defaults o 'root'.
     * @return array The data in an array compatible with d3-flame-graph.
     */
    static function process(string $data, string $rootname = 'root'): array {
        $table = [];
        $lines = explode("\n", $data);
        $total = 0;
        foreach ($lines as $line) {
            list($trace, $num) = explode(" ", $line);
            $num = (int)$num;
            $trace = explode(';', $trace);
            $total += $num;
            self::processtail($table, $trace, $num);
        }
        return [
            'name' => $rootname,
            'value' => $total,
            'children' => self::reprocess($table)
        ];
    }

    /**
     * Processes the 'tail' of a stack trace, adding the first element to the table, and recursively calling itself with the rest.
     *
     * @param array $table
     * @param array $trace
     * @param int $num
     */
    private static function processtail(array &$table, array $trace, int $num): void {
        assert(count($trace) > 0);
        $idx = array_shift($trace);
        if (isset($table[$idx])) {
            $table[$idx]['value'] += $num;
            if (count($trace)) {
                self::processtail($table[$idx]['children'], $trace, $num);
            }
        }
        else {
            $table[$idx] = [ "value" => $num, "children" => [] ];
            if (count($trace)) {
                self::processtail($table[$idx]['children'], $trace, $num);
            }
        }
    }

    /**
     * Reprocesses the result of process() to strip away string indexes and put them inside the elements.
     *
     * @param array $table
     * @return array
     */
    private static function reprocess(array $table): array {
        $nodes = [];
        foreach ($table as $key => $val) {
            $node = [
                'name' => $key,
                'value' => $val['value'],
            ];
            if (isset($val['children'])) {
                $node['children'] = self::reprocess($val['children']);
            }
            $nodes[] = $node;
        }
        return $nodes;
    }
}
