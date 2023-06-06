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
        if (!$session->has('logged_in')) {
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
        $data = [
            'status' => 'detail',
            'title' => 'Detail Animal',
            'animal' => $this->animalModel->getAnimal($slug)
        ];
        return view('animal/detail', $data);
    }

    public function new()
    {
        session();
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
            $thumbnailName = 'default_thumbnail.png';
        } else {
            $thumbnailName = $thumbnail->getRandomName();
            $thumbnail->move('img', $thumbnailName);
        }

        //* Upload Sound
        $sound = $this->request->getFile('sound');
        if ($sound->getError() == 4) {
            $soundName = 'default_thumbnail.png';
        } else {
            $soundName = $sound->getRandomName();
            $sound->move('sound', $soundName);
        }

        //* Upload 3D Model
        $model = $this->request->getFile('model');
        if ($model->getError() == 4) {
            $modelName = 'default_thumbnail.png';
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

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/animal');
    }

    public function edit($slug)
    {
        $data = [
            'status' => 'edit',
            'title' => 'Ubah data',
            'animal' => $this->animalModel->getAnimal($slug)
        ];
        return view('animal/edit', $data);
    }

    public function update($id)
    {
        //* Check existing thumbnail
        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail->getError() == 4) {
            $thumbnailName = $this->request->getVar('oldThumbnail');
        } else {
            $thumbnailName = $thumbnail->getRandomName();
            $thumbnail->move('img', $thumbnailName);
            if ($this->request->getVar('oldThumbnail') !== 'default_thumbnail.png') {
                unlink('img/' . $this->request->getVar('oldThumbnail'));
            }
        }

        //* Check existing sound
        $sound = $this->request->getFile('sound');
        if ($sound->getError() == 4) {
            $soundName = $this->request->getVar('oldSound');
        } else {
            $soundName = $sound->getRandomName();
            $sound->move('sound', $soundName);
            if ($this->request->getVar('oldSound') !== 'default_thumbnail.png') {
                unlink('sound/' . $this->request->getVar('oldSound'));
            }
        }

        //* Check existing model
        $model = $this->request->getFile('model');
        if ($model->getError() == 4) {
            $modelName = $this->request->getVar('oldModel');
        } else {
            $modelName = $model->getRandomName();
            $model->move('model', $modelName);
            if ($this->request->getVar('oldModel') !== 'default_thumbnail.png') {
                unlink('model/' . $this->request->getVar('oldModel'));
            }
        }

        $this->animalModel->save([
            'id' => $id,
            'name' => $this->request->getVar('name'),
            'slug' => $this->request->getVar('slug'),
            'description' => $this->request->getVar('description'),
            'thumbnail' => $thumbnailName,
            'sound' => $soundName,
            'model' => $modelName,
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/animal');
    }

    public function delete($id)
    {
        $animal = $this->animalModel->find($id);
        if ($animal['thumbnail'] != 'default_thumbnail.png') {
            unlink('img/' . $animal['thumbnail']);
        }
        if ($animal['sound'] != 'default_thumbnail.png') {
            unlink('sound/' . $animal['sound']);
        }
        if ($animal['model'] != 'default_thumbnail.png') {
            unlink('model/' . $animal['model']);
        }

        $this->animalModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/animal');
    }
}