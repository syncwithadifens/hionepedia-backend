<?php

namespace App\Controllers\Api;

use App\Models\AnimalModel;
use CodeIgniter\RESTful\ResourceController;

class Animal extends ResourceController
{
    protected $animalModel;

    public function __construct()
    {
        $this->animalModel = new AnimalModel();
    }

    public function index()
    {
        $data = [
            'status' => 'success',
            'animal' => $this->animalModel->findAll()
        ];
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $data = [
            'status' => 'success',
            'animal' => $this->animalModel->find($id)
        ];
        if ($data['animal'] == null) {
            return $this->failNotFound('Data not found');
        }
        return $this->respond($data, 200);
    }

    public function new()
    {
        //
    }

    public function create()
    {
        $slug = url_title($this->request->getVar('name'), '-', true);

        $rules = $this->validate([
            'name' => 'required',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];
            return $this->failValidationErrors($response);
        }

        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail->getError() == 4) {
            $thumbnailName = 'default_thumbnail.png';
        } else {
            $thumbnailName = $thumbnail->getRandomName();
            $thumbnail->move('img', $thumbnailName);
        }

        $this->animalModel->save([
            'name' => $this->request->getVar('name'),
            'slug' => $slug,
            'description' => $this->request->getVar('description'),
            'thumbnail' => $thumbnailName,
        ]);

        $response = [
            'status' => 'success',
            'message' => 'Item data success added',
            'animal' => $this->animalModel->findAll()
        ];
        return $this->respondCreated($response);
    }

    public function edit($id = null)
    {
        //
    }

    public function update($id = null)
    {
        $slug = url_title($this->request->getVar('name'), '-', true);

        $rules = $this->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];
            return $this->failValidationErrors($response);
        }

        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail->getError() == 4) {
            $thumbnailName = 'default_thumbnail.png';
        } else {
            $thumbnailName = $thumbnail->getRandomName();
            $thumbnail->move('img', $thumbnailName);
        }

        $this->animalModel->save([
            'id' => $id,
            'name' => $this->request->getVar('name'),
            'slug' => $slug,
            'description' => $this->request->getVar('description'),
            'thumbnail' => $thumbnailName,
        ]);

        $response = [
            'status' => 'success',
            'message' => 'Item data success updated',
            'animal' => $this->animalModel->find($id)
        ];
        return $this->respond($response, 200);
    }

    public function delete($id = null)
    {
        $animal = $this->animalModel->find($id);
        if ($animal['thumbnail'] != 'default_thumbnail.png') {
            unlink('img/' . $animal['thumbnail']);
        }

        $this->animalModel->delete($id);

        $response = [
            'status' => 'success',
            'message' => 'Item data success deleted',
            'animal' => $this->animalModel->findAll()
        ];
        return $this->respondDeleted($response);
    }
}
