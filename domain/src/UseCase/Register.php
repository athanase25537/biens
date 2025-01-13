<?php

class Register
{
    private int $id;
    private int $parrain_id;
    private string $username;
    private string $photo;
    private string $email;
    private string $phone;
    private string $password;
    private string $rules;
    private string $name;
    private string $firstname;
    private bool $is_active;
    private DateTime $last_login;
    private DateTime $created_at;
    private DateTime $updated_at;

    public function __construct(
        int $id, 
        int $parrain_id, 
        string $username, 
        string $photo, 
        string $email, 
        string $phone,
        string $password, 
        string $rules,
        string $name,
        string $firstname,
        bool $is_active,
        DateTime $created_at,
        DateTime $updated_at,
        DateTime $last_login,
        ) 
    {
        $this->id = $id;
        $this->parrain_id = $parrain_id;
        $this->username = $username;
        $this->photo = $photo;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->rules = $rules;
        $this->name = $name;
        $this->firstname = $firstname;
        $this->is_active = $is_active;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->last_login = $last_login;
    }
}