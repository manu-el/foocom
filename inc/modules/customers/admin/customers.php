<?php

defined('admin') or die ('no direct access');

class Customers extends Controller {
    private $db;

    function Customers() {
        $this->db = new Customers_Database();
    }

    function handle(ORequest $request) {
        $template = new Template('customers', 'customers');
        $template->set_ar('customers', $this->db->all());
        $template->display();
    }
}
