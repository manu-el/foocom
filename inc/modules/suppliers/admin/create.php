<?php

defined('admin') or die ('no direct access');

include 'db.php';

class Suppliers_Create extends Controller {
    private $db;

    function Suppliers_Create() {
        $this->db = new Suppliers_Database();
    }

    function handle(Request $request) {
        if ($request->is_post('suppliers-create')) {
            $id = $this->db->insert($request->populate(array('name' => '')));
            $request->forward('suppliers-change-' . $id);
        }
    }
}