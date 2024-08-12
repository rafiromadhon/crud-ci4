<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Controller;
use App\Models\PostModel;

class Post extends BaseController
{
    public function index()
    {
        $postModel = new PostModel;

        $pager = \Config\Services::pager();

        $data = array (
            'posts' => $postModel->paginate(20, 'post'),
            'pager' => $postModel->pager
        );

        return view('post-index', $data);
    }

    public function create(){
        return view('post-create');
    }

    public function store()
    {
        //load helper form and URL
        helper(['form', 'url']);
         
        //define validation
        $validation = $this->validate([
            'title' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Masukkan Judul Post.'
                ]
            ],
            'content'    => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Masukkan konten Post.'
                ]
            ],
        ]);

        if(!$validation) {

            //render view with error validation message
            return view('post-create', [
                'validation' => $this->validator
            ]);

        } else {

             //model initialize
            $postModel = new PostModel();
            
            //insert data into database
            $postModel->insert([
                'title'   => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
            ]);

            //flash message
            session()->setFlashdata('message', 'Post Berhasil Disimpan');

            return redirect()->to(base_url('post'));
        }

    }

    public function edit($id)
    {
        //model initialize
        $postModel = new PostModel();

        $data = array(
            'post' => $postModel->find($id)
        );

        return view('post-edit', $data);
    }

    public function update($id)
    {
        //load helper form and URL
        helper(['form', 'url']);
         
        //define validation
        $validation = $this->validate([
            'title' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Masukkan Judul Post.'
                ]
            ],
            'content'    => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Masukkan konten Post.'
                ]
            ],
        ]);

        if(!$validation) {

            //model initialize
            $postModel = new PostModel();

            //render view with error validation message
            return view('post-edit', [
                'post' => $postModel->find($id),
                'validation' => $this->validator
            ]);

        } else {

            //model initialize
            $postModel = new PostModel();
            
            //insert data into database
            $postModel->update($id, [
                'title'   => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
            ]);

            //flash message
            session()->setFlashdata('message', 'Post Berhasil Diupdate');

            return redirect()->to(base_url('post'));
        }

    }

    public function delete($id)
    {
        //model initialize
        $postModel = new PostModel();

        $post = $postModel->find($id);

        if($post) {
            $postModel->delete($id);

            //flash message
            session()->setFlashdata('message', 'Post Berhasil Dihapus');

            return redirect()->to(base_url('post'));
        }
    }


}
