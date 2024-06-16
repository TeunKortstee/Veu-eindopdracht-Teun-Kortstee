<?php
namespace Controllers;

use Exception;
use Services\AppService;

class AppController extends Controller
{
    private AppService $service;
    public function __construct()
    {
        $this->service = new AppService();
    }
    public function GetAllApps()
    {
        $offset = NULL;
        $limit = NULL;

        if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
            $offset = $_GET["offset"];
        }
        if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
            $limit = $_GET["limit"];
        }

        $apps = $this->service->getAll($offset, $limit);

        $this->respond($apps);
    }
    public function createApp()
    {
        try {
            $app = $this->createObjectFromPostedJson("Models\\App");
            $this->service->insert($app);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($app);
    }
    public function updateApp($id)
    {
        try {
            $app = $this->createObjectFromPostedJson("Models\\App");
            $this->service->update($app, $id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($app);
    }
}
