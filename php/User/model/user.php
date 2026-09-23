<?php

class User{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login(array $data)
    {
        $email = $data["user"];
        $password = $data["password"];

        $stmt = $this->conn->prepare(
            'SELECT id, name, email, password FROM user WHERE email = ?'
        );
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();

        if(!$user || !password_verify($password, $user['password'])){
            return array(
                "statusCode" => 400,
                "message" => "La contraseña y/o usuario es incorrecto"
            );
        }

        return array(
            "statusCode" => 200,
            "message" => "Login con exito"
        );
    }

    public function register(array $data)
    {
        $stmt = $this->conn->prepare('SELECT id FROM user WHERE email = ?');
        $stmt->bind_param('s', $data['email']);
        $stmt->execute();

        $existe = $stmt->get_result()->num_rows > 0;
        $stmt->close();

        if($existe){
            return array(
                "message" => "Email ya registrado",
                "statusCode" => 400
            );
        }

        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare(
            'INSERT INTO user (name, email, password) VALUES (?,?,?)'
        );
        $stmt->bind_param('sss', $data['name'], $data['email'], $password_hash);

        if($stmt->execute()){
            $stmt->close();
            return array("message" => "Usuario registrado", "statusCode" => 201);
        }else{
            $stmt->close();
            return array("message" => "Problema al crear el usuario", "statusCode" => 400);
        }
    }
}
