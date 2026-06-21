<?php

require_once './app/models/concierto.model.php';

class ConciertoApiController {

    private $model;

    public function __construct() {
        $this->model = new ConciertoModel();
    }

    public function getConciertos($request, $response) {
        $orderBy = isset($request->query->orderBy) ? $request->query->orderBy : 'id_concierto';
        $order = isset($request->query->order) ? $request->query->order : 'ASC';

        $conciertos = $this->model->getAll($orderBy, $order);

        return $response->json($conciertos);
    }

    public function update($request, $response) {
        $id = $request->params->id;

        $concierto = $this->model->get($id);

        if (!$concierto) {
            return $response->json(
                "No existe el concierto",
                404
            );
        }

        $body = $request->body;

        if (
            empty($body->fecha) ||
            empty($body->lugar) ||
            empty($body->ciudad) ||
            empty($body->id_banda) ||
            isset($body->precio_platea) === false ||
            isset($body->precio_campo) === false ||
            isset($body->precio_popular) === false
        ) {
            return $response->json(
                'Faltan completar datos',
                400
            );
        }

        $this->model->update(
            $id,
            $body->fecha,
            $body->lugar,
            $body->ciudad,
            $body->id_banda,
            $body->precio_platea,
            $body->precio_campo,
            $body->precio_popular
        );

        $conciertoActualizado = $this->model->get($id);

        return $response->json($conciertoActualizado);
    }
}
