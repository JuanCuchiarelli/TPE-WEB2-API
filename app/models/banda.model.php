<?php

require_once './config.php';

class BandaModel {

    private $db;

    public function __construct() {
        $this->db = getDBConnection();
    }

    public function get($id) {

        $query = $this->db->prepare(
            'SELECT * FROM bandas WHERE id_banda = ?'
        );

        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insert(
        $nombre,
        $genero,
        $pais_de_origen,
        $img,
        $descripcion
    ) {

        $query = $this->db->prepare(
            'INSERT INTO bandas
            (nombre, genero, pais_de_origen, img, descripcion)
            VALUES (?, ?, ?, ?, ?)'
        );

        $query->execute([
            $nombre,
            $genero,
            $pais_de_origen,
            $img,
            $descripcion
        ]);

        return $this->db->lastInsertId();
    }

    public function getAll()
    {
        $query = $this->db->prepare(
            'SELECT * FROM bandas'
        );

        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getByGenero($genero)
    {
        $query = $this->db->prepare(
            'SELECT * FROM bandas WHERE genero = ?'
        );

        $query->execute([$genero]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPaginated($limit, $offset)
    {
        $query = $this->db->prepare(
            'SELECT * FROM bandas LIMIT ? OFFSET ?'
        );

        $query->bindValue(1, $limit, PDO::PARAM_INT);
        $query->bindValue(2, $offset, PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}