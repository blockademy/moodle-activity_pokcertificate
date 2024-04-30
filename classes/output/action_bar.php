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

namespace mod_pokcertificate\output;

/**
 * Class action_bar
 *
 * @package    mod_pokcertificate
 * @copyright  2024 Moodle India Information Solutions Pvt Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class action_bar {

    /** @var int $cmid The course module id. */
    private $cmid;

    /** @var moodle_url $pageurl The URL of the current page. */
    private $pageurl;
    /**
     * The class constructor.
     *
     */
    public function __construct(int $cmid, \moodle_url $pageurl) {
        $this->cmid = $cmid;
        $this->pageurl = $pageurl;
    }

    /**
     * Export the data for the mustache template.
     *
     * @param \renderer_base $output renderer to be used to render the action bar elements.
     * @return array
     */
    public function export_for_template(\renderer_base $output): array {

        $urlselect = $this->get_action_selector();

        $data = [
            'urlselect' => $urlselect->export_for_template($output),
        ];

        return $data;
    }

    /**
     * Returns the URL selector object.
     *
     * @return \url_select The URL select object.
     */
    private function get_action_selector(): \url_select {
        global $PAGE;

        $menu = [];
        /*   if (has_capability('mod/pokcertificate:view', $PAGE->context)) {
            $previewlink = new \moodle_url('/mod/pokcertificate/preview.php', ['id' => $this->cmid]);
            $menu[$previewlink->out(false)] = get_string('previewcertificate', 'mod_pokcertificate');
        } */
        $menu[null] = get_string('select');
        if (has_capability('mod/pokcertificate:manageinstance', $PAGE->context)) {
            $certificateslink = new \moodle_url('/mod/pokcertificate/certificates.php', ['id' => $this->cmid]);
            $menu[$certificateslink->out(false)] = get_string('certificateslist', 'mod_pokcertificate');
        }

        if (has_capability('mod/pokcertificate:manageinstance', $PAGE->context)) {
            $fieldmappinglink = new \moodle_url('/mod/pokcertificate/fieldmapping.php', ['id' => $this->cmid]);
            $menu[$fieldmappinglink->out(false)] = get_string('fieldmapping', 'mod_pokcertificate');
        }
        return new \url_select($menu, $menu[null], null, 'pokactionselect');
    }
}