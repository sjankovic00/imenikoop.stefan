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

    public function getMemberById($id) {
        $query = "SELECT * FROM members WHERE id = :id";
        $stmt = $this->db->query($query, [':id' => $id]);

        $member = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $member;
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

    public function getImageById($user_id)
    {
        $query = "SELECT images.filepath 
              FROM images 
              JOIN user_images ON images.id = user_images.image_id 
              WHERE user_images.user_id = :user_id";

        $stmt = $this->db->query($query, [':user_id' => $user_id]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

}