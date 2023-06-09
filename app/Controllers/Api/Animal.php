<?php

namespace App\Controllers\Api;

use App\Models\AnimalModel;
use App\Models\FavoriteModel;
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

        //* Upload Thumbnail
        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail->getError() == 4) {
            $thumbnailName = 'default_thumbnail.jpg';
        } else {
            $thumbnailName = $thumbnail->getRandomName();
            $thumbnail->move('img', $thumbnailName);
        }

        //* Upload Sound
        $sound = $this->request->getFile('sound');
        if ($sound->getError() == 4) {
            $soundName = 'default_sound.mp3';
        } else {
            $soundName = $sound->getRandomName();
            $sound->move('sound', $soundName);
        }

        //* Upload Model
        $model = $this->request->getFile('model');
        if ($model->getError() == 4) {
            $modelName = 'default_model.glb';
        } else {
            $modelName = $model->getRandomName();
            $model->move('model', $modelName);
        }

        $this->animalModel->save([
            'name' => $this->request->getVar('name'),
            'slug' => $slug,
            'description' => $this->request->getVar('description'),
            'thumbnail' => $thumbnailName,
            'sound' => $soundName,
            'model' => $modelName,
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

        //* Check existing thumbnail
        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail != null) {
            $thumbnailName = $thumbnail->getRandomName();
            $thumbnail->move('img', $thumbnailName);
            if ($this->request->getVar('oldThumbnail') !== 'default_thumbnail.jpg') {
                unlink('img/' . $this->request->getVar('oldThumbnail'));
            }
            $this->animalModel->update($id, [
                'thumbnail' => $thumbnailName,
            ]);
        }

        //* Check existing sound
        $sound = $this->request->getFile('sound');
        if ($sound != null) {
            $soundName = $sound->getRandomName();
            $sound->move('sound', $soundName);
            if ($this->request->getVar('oldSound') !== 'default_sound.mp3') {
                unlink('sound/' . $this->request->getVar('oldSound'));
            }
            $this->animalModel->update($id, [
                'sound' => $soundName,
            ]);
        }

        //* Check existing model
        $model = $this->request->getFile('model');
        if ($model != null) {
            $modelName = $model->getRandomName();
            $model->move('model', $modelName);
            if ($this->request->getVar('oldModel') !== 'default_model.glb') {
                unlink('model/' . $this->request->getVar('oldModel'));
            }
            $this->animalModel->update($id, [
                'model' => $modelName,
            ]);
        }

        $this->animalModel->update($id, [
            'slug' => $slug,
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
        ]);

        $response = [
            'status' => 'success',
            'message' => 'Item data success updated',
            'animal' => $this->animalModel->find($id)
        ];
        return $this->respond($response, 200);
    }

    public function addToFavorite($animalId)
    {
        // Get user ID from authentication or session
        $userId = $this->request->getVar('user_id'); // Replace with your own logic

        $favoriteModel = new FavoriteModel();

        // Check if the animal is already in the user's favorite
        $existingWishlist = $favoriteModel
            ->where('user_id', $userId)
            ->where('animal_id', $animalId)
            ->first();

        if ($existingWishlist) {
            return $this->fail('Animal already in the favorite.');
        }

        // Create a new favorite entry
        $data = [
            'user_id' => $userId,
            'animal_id' => $animalId,
        ];

        $favoriteId = $favoriteModel->insert($data);

        if (!$favoriteId) {
            return $this->failServerError('Failed to add animal to favorite.');
        }

        return $this->respondCreated([
            'message' => 'Added to favorite',
            'favorite_id' => $favoriteId,
            'data' => $data
        ]);
    }

    public function removeFromFavorite($favoriteId)
    {
        $favoriteModel = new FavoriteModel();
        $favorite = $favoriteModel->find($favoriteId);

        if (!$favorite) {
            return $this->failNotFound('Favorite item not found.');
        }

        $favoriteModel->delete($favoriteId);

        return $this->respondDeleted(['favorite_id' => $favoriteId]);
    }

    public function getUserFavorite()
    {
        $userId = $this->request->getVar('user_id');
        if ($userId) {
            $favorites = $this->animalModel->join('favorites', 'animals.animal_id = favorites.animal_id')->where('favorites.user_id', $userId)->get()->getResult();
        } else {
            $favorites = 'No user id found';
        }

        $result = [
            'status' => 'success',
            'favorited' => $favorites
        ];

        return $this->respondCreated($result);
    }

    public function delete($id = null)
    {
        $animal = $this->animalModel->find($id);

        if ($animal['thumbnail'] != 'default_thumbnail.jpg') {
            unlink('img/' . $animal['thumbnail']);
        }

        if ($animal['sound'] != 'default_sound.mp3') {
            unlink('sound/' . $animal['sound']);
        }

        if ($animal['model'] != 'default_model.glb') {
            unlink('model/' . $animal['model']);
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
