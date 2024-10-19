<?php

namespace App\Repositories;

use App\Models\Amenity;
use App\Models\Room;
use App\Repositories\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    //model muốn tương tác
    protected $model;

   //khởi tạo
    public function __construct()
    {
        $this->setModel();
    }

    //lấy model tương ứng
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }
    public function getAll($limit = 0, $latest = false, $q = [])
    {
        $query = $this->model;

        if ($latest) {
            $query = $query->latest();
        }

        if ($limit > 0) {
            $query = $query->limit($limit);
        }

        $data = $query->get();

        return $data;
    }
    public function find($id)
    {
        $result = $this->model->find($id);

        return $result;
    }

    public function create($attributes = [])
    {
        try{
            $result =  $this->model->create($attributes);
            if($result){
                return $result;
            }
        }
        catch (\Exception $e){
            return false;
        }

    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();
            return true;
        }
        return false;
    }

    public function softDelete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->deleted_at = now();
            $result->save();
            return true;
        }
        return false;
    }


}
