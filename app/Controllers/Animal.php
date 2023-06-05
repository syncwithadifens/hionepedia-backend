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

        $slug = url_title($this->request->getVar('name'), '-', true);

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

        $this->animalModel->save([
            'id' => $id,
            'name' => $this->request->getVar('name'),
            'slug' => $this->request->getVar('slug'),
            'description' => $this->request->getVar('description'),
            'thumbnail' => $thumbnailName,
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

        $this->animalModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/animal');
    }
}
