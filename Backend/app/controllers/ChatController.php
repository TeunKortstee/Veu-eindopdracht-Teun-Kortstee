<?php
namespace Controllers;

use Services\ChatService;
use Exception;

class ChatController extends Controller
{
    private ChatService $service;
    public function __construct()
    {
        $this->service = new ChatService();
    }
    public function createChat()
    {
        try {
            $chat = $this->createObjectFromPostedJson("Models\\Chat");
            $this->service->create($chat);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($chat);
    }
    public function addUserToChat($chatId)
    {
        try {
            $user = $this->createObjectFromPostedJson("Models\\User");
            $this->service->addUserToChat($chatId, $user);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }

        $this->respond($user);
    }
    public function getChats()
    {
        $offset = NULL;
        $limit = NULL;

        if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
            $offset = $_GET["offset"];
        }
        if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
            $limit = $_GET["limit"];
        }

        $apps = $this->service->getAllChats($offset, $limit);

        $this->respond($apps);
    }
}
