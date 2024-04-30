<?php

namespace app\models;

use app\core\Model;

class Meter extends Model
{

    public function create(string $id, string $name, string $uuid): int|string
    {
        $id = $this->db->sqlEscape($id);
        $name = $this->db->sqlEscape($name);
        $uuid = $this->db->sqlEscape($uuid);

        $sql = sprintf("INSERT INTO meter (uuid, id_meter, name) VALUES ('%s', '%s', '%s')", $uuid, $id, $name);
        $this->db->query($sql);

        return $this->db->affectedRows();
    }

    public function all(string $uuid): false|array
    {
        $uuid = $this->db->sqlEscape($uuid);

        $sql = sprintf("SELECT id_meter as idMeter, name FROM meter WHERE uuid = '%s'", $uuid);

        return $this->db->fetch($sql);
    }

    public function deleteAll(string $uuid): int|string
    {
        $uuid = $this->db->sqlEscape($uuid);

        $sql = sprintf("DELETE FROM meter WHERE uuid = '%s'", $uuid);
        $this->db->query($sql);

        return $this->db->affectedRows();
    }

}