<?php

require_once './app/models/banda.model.php';

class BandaApiController {

    private $model;

    public function __construct() {
        $this->model = new BandaModel();
    }

    public function getBanda($request, $response) {

        $id = $request->params->id;

        $banda = $this->model->get($id);

        if (!$banda) {
            return $response->json(
                "No existe la banda",
                404
            );
        }

        return $response->json($banda);
    }

    public function insert($request, $response) {

        $body = $request->body;

        if (
            empty($body->nombre) ||
            empty($body->genero) ||
            empty($body->pais_de_origen) ||
            empty($body->descripcion)
        ) {

            return $response->json(
                'Faltan completar datos',
                400
            );
        }

        $img = '';

        if (isset($body->img)) {
            $img = $body->img;
        }

        $id = $this->model->insert(
            $body->nombre,
            $body->genero,
            $body->pais_de_origen,
            $img,
            $body->descripcion
        );

        return $response->json(
            [
                'mensaje' => 'Banda creada',
                'id_banda' => $id
            ],
            201
        );
    }

    public function notFound($request, $response) {

        $response->json(
            "Ruta no encontrada",
            404
        );
    }

    public function getBandas($request, $response)
    {
        if (
            isset($request->query->page) &&
            isset($request->query->limit)
        ) {

            $page = (int) $request->query->page;
            $limit = (int) $request->query->limit;

            $offset = ($page - 1) * $limit;

            $bandas = $this->model->getPaginated(
                $limit,
                $offset
            );
        }
        else if (isset($request->query->genero)) {

            $bandas = $this->model->getByGenero(
                $request->query->genero
            );
        }
        else {

            $bandas = $this->model->getAll();
        }

        return $response->json($bandas);
    }
}