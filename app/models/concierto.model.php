<?php

require_once './config.php';

class ConciertoModel {

    private $db;

    public function __construct() {
        $this->db = getDBConnection();
    }

    public function getAll($orderBy = 'id_concierto', $order = 'ASC') {
        $allowedColumns = [
            'id_concierto',
            'fecha',
            'lugar',
            'ciudad',
            'id_banda',
            'precio_platea',
            'precio_campo',
            'precio_popular'
        ];

        if (!in_array($orderBy, $allowedColumns)) {
            $orderBy = 'id_concierto';
        }

        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

        $query = $this->db->prepare("SELECT * FROM conciertos ORDER BY $orderBy $order");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function get($id) {
        $query = $this->db->prepare("SELECT * FROM conciertos WHERE id_concierto = ?");
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function update($id, $fecha, $lugar, $ciudad, $id_banda, $precio_platea, $precio_campo, $precio_popular) {
        $query = $this->db->prepare("UPDATE conciertos SET fecha = ?, lugar = ?, ciudad = ?, id_banda = ?, precio_platea = ?, precio_campo = ?, precio_popular = ? WHERE id_concierto = ?");
        $query->execute([$fecha, $lugar, $ciudad, $id_banda, $precio_platea, $precio_campo, $precio_popular, $id]);
    }
}
