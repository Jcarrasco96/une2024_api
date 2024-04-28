<?php

namespace app\models;

use app\core\Model;

class Registry extends Model
{

    public function create(int $read, int $last_read, string $date, bool $official, string $uuid): int|string
    {
        $read = $this->db->sqlEscape($read);
        $last_read = $this->db->sqlEscape($last_read);
        $date = $this->db->sqlEscape($date);
        $official = $this->db->sqlEscape($official);
        $uuid = $this->db->sqlEscape($uuid);

        $sql = sprintf("INSERT INTO registry (uuid, current_read, last_read, date, official) VALUES ('%s', %u, %u, '%s', %b)", $uuid, $last_read, $read, $date, $official);
        $this->db->query($sql);

        return $this->db->affectedRows();
    }

    public function all(string $uuid): false|array
    {
        $uuid = $this->db->sqlEscape($uuid);

        $sql = sprintf("SELECT current_read as 'read', last_read as 'lastRead', date, official FROM registry WHERE uuid = '%s'", $uuid);

        return $this->db->fetch($sql);
    }

    public function deleteAll(string $uuid) {
        $uuid = $this->db->sqlEscape($uuid);

        $sql = sprintf("DELETE FROM registry WHERE uuid = '%s'", $uuid);
        $this->db->query($sql);

        return $this->db->affectedRows();
    }

}