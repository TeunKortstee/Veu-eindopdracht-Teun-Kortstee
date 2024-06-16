<?php
namespace Services;

use Repositories\ChatRepository;

class ChatService
{
    private ChatRepository $chatRepository;
    public function __construct()
    {
        $this->chatRepository = new ChatRepository();
    }
    public function create($userId)
    {
        return $this->chatRepository->create($userId);
    }
    public function getAllChats($offset = null, $limit = null)
    {
        return $this->chatRepository->getAllChats($offset, $limit);
    }
    public function addUserToChat($chatId, $userId)
    {
        return $this->chatRepository->addUserToChat($chatId, $userId);
    }
}
