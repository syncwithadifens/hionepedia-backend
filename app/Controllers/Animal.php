<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnimalModel;

class Animal extends BaseController
{
    protected $animalModel;

    public function __construct()
    {
        $this->animalModel = new AnimalModel();
    }

    public function index()
    {
        $session = session();
        if (!$session->has('role')) {
            return redirect()->to('/login');
        }

        $data = [
            'status' => 'home',
            'title' => 'Daftar Hewan Langka',
            'animal' => $this->animalModel->getAnimal()
        ];
        return view('animal/index', $data);
    }

    public function show($slug)
    {
        $session = session();
        if (!$session->has('role')) {
            return redirect()->to('/login');
        }

        $data = [
            'status' => 'detail',
            'title' => 'Detail Animal',
            'animal' => $this->animalModel->getAnimal($slug)
        ];
        return view('animal/detail', $data);
    }

    public function new()
    {
        $session = session();
        if (!$session->has('role')) {
            return redirect()->to('/login');
        }

        $data = [
            'status' => 'new',
            'title' => 'Form tambah data',
            'validation' => \Config\Services::validation()
        ];
        return view('animal/new', $data);
    }

    public function create()
    {

        if (!$this->validate([
            'name' => 'required'
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        //* Create slug
        $slug = url_title($this->request->getVar('name'), '-', true);

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

        //* Upload 3D Model
        $model = $this->request->getFile('model');
        if ($model->getError() == 4) {
            $modelName = 'default_model.glb';
            $offline = 'yes';
        } else {
            $modelName = $model->getRandomName();
            $model->move('model', $modelName);
            $offline = 'no';
        }

        $this->animalModel->save([
            'name' => $this->request->getVar('name'),
            'slug' => $slug,
            'description' => $this->request->getVar('description'),
            'thumbnail' => $thumbnailName,
            'sound' => $soundName,
            'model' => $modelName,
            'offline' => $offline
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/animal');
    }

    public function edit($slug)
    {
        $session = session();
        if (!$session->has('role')) {
            return redirect()->to('/login');
        }

        $data = [
            'status' => 'edit',
            'title' => 'Ubah data',
            'animal' => $this->animalModel->getAnimal($slug)
        ];
        return view('animal/edit', $data);
    }

    public function update($id)
    {
        //* Create slug
        $slug = url_title($this->request->getVar('name'), '-', true);

        //* Check existing thumbnail
        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail->getError() == 4) {
            $thumbnailName = $this->request->getVar('oldThumbnail');
        } else {
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
        if ($sound->getError() == 4) {
            $soundName = $this->request->getVar('oldSound');
        } else {
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
        if ($model->getError() == 4) {
            $modelName = $this->request->getVar('oldModel');
        } else {
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

        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/animal');
    }

    public function delete($id)
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
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/animal');
    }
}
