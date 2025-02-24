<?php
namespace Models;

use Core\Database;

class Users
{
    private $db;


    public function __construct(Database $database)
    {
        $this->db = $database;
    }

    public function getUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->query($query, ["username" => $username]);
        return $stmt->fetch();
    }

    public function getPwd($password, $pwd)
    {
        return $password === $pwd;
    }

    public function getAllMembers()
    {
        $query = "SELECT * FROM members";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }

    public function getMemberById($id)
    {
        $query = "SELECT * FROM members WHERE id=:id";
        $stmt = $this->db->query($query, ["id" => $id]);
        return $stmt->fetch();
    }

    public function addMember($data)
    {
        $query = "INSERT INTO members (ime, prezime, br_telefona, adresa, email, opis, website)
              VALUES (:ime, :prezime, :br_telefona, :adresa, :email, :opis, :website)";
        return $this->db->query($query, $data);
    }

    public function updateMember($data)
    {
        $query = "UPDATE members SET  ime = :ime, prezime = :prezime, br_telefona = :br_telefona, adresa = :adresa, email = :email,opis = :opis, website = :website WHERE id = :id";
        return $this->db->query($query, $data);
    }

    public function deleteMemberById($id)
    {
        $query = "DELETE FROM members WHERE id = :id";
        return $this->db->query($query, ["id" => $id]);
    }
}