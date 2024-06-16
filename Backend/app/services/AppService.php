<?php

namespace Services;

use Repositories\AppRepository;

class AppService
{
    private AppRepository $appRepository;
    public function __construct()
    {
        $this->appRepository = new AppRepository();
    }
    public function getAll($offset = null, $limit = null)
    {
        return $this->appRepository->getAll($offset, $limit);
    }

    public function insert($app)
    {
        return $this->appRepository->create($app);
    }
    public function update($app, $id)
    {
        return $this->appRepository->update($app, $id);
    }
}
