<?php
namespace Models;

use Core\Database;

class Users
{
    protected $db;


    public function __construct(Database $database)
    {
        $this->db = $database;
    }
    public function username($username)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->query($query, ["username" => $username]);
        return $stmt->fetch();
    }
    public function pwd($password, $pwd) {
        return $password === $pwd;
    }
    public function members()
    {
        $query = "SELECT * FROM members";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }
    public function getMember($id){
        $query = "SELECT * FROM members WHERE id=:id";
        $stmt = $this->db->query($query, ["id" => $id]);
        return $stmt->fetch();
    }
}
