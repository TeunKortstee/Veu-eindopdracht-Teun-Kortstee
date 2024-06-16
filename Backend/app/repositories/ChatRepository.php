<?php
namespace Repositories;

use PDOException;
use PDO;

class ChatRepository extends Repository
{
    public function create($userId)
    {
        $stmt = $this->connection->prepare("INSERT INTO chats () VALUES ()");
        return $stmt->execute();
    }
    public function addUserToChat($chatId, $userId)
    {
        $stmt = $this->connection->prepare("INSERT INTO chat_users (chat_id, user_id) VALUES (?, ?)");
        $stmt->bindParam("ii", $chatId, $userId);
        return $stmt->execute();
    }
    public function getAllChats($offset = null, $limit = null)
    {
        try {
            $query = "SELECT * FROM projects";
            if (isset($limit) && isset($offset)) {
                $query .= " LIMIT :limit OFFSET :offset";
            }
            $stmt = $this->connection->prepare($query);
            if (isset($limit) && isset($offset)) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            $stmt->execute();

            $projects = array();
            while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
                //$projects[] = $this->rowToProject($row);
            }

            return $projects;
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
