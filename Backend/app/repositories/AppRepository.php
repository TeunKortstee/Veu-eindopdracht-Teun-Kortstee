<?php

namespace Repositories;

use PDO;
use PDOException;

class AppRepository extends Repository
{
    public function getAll($offset = null, $limit = null)
    {
        try {
            $query = "SELECT * FROM apps";
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
    public function create($app)
    {
        $stmt = $this->connection->prepare("INSERT INTO apps (name) VALUES (?)");
        $stmt->bindParam("s", $app);
        return $stmt->execute();
    }
    public function update($app, $id)
    {
        $stmt = $this->connection->prepare("UPDATE apps SET name=@app WHERE id=@id");
        $stmt->bindParam("@id", $id);
        $stmt->bindParam("@app", $app);
        return $stmt->execute();
    }
}
