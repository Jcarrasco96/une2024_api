<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Meter;
use app\models\Registry;
use Exception;

class BackupController extends Controller
{

    public function save(): array
    {
        $data = $this->dataJson;

        $uuid = $data['id'];
        $registries = $data['registry'];
        $meters = $data['meter'];

        $modelRegistry = new Registry();
        $modelMeter = new Meter();

        $modelRegistry->deleteAll($uuid);
        $modelMeter->deleteAll($uuid);

        foreach ($registries as $registry) {
            $modelRegistry->create($registry['read'], $registry['lastRead'], $registry['date'], $registry['official'], $uuid);
        }

        foreach ($meters as $meter) {
            $modelMeter->create($meter['idMeter'], $meter['name'], $uuid);
        }

        return ['status' => 200, 'message' => 'Datos guardados correctamente'];
    }

    /**
     * @throws Exception
     */
    public function view($uuid): false|array
    {
        $registry = new Registry();
        $registries = $registry->all($uuid);

        $meter = new Meter();
        $meters = $meter->all($uuid);

        return [
            'id' => $uuid,
            'registry' => $registries,
            'meter' => $meters
        ];
    }

}