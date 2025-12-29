<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FertilizerModel;
use CodeIgniter\API\ResponseTrait;

class FertilizerApi extends BaseController
{
    public function addfertilizer()
    {
        helper(['form']);

        $data = [];

        if ($this->request->getMethod() === 'POST') {

            $rules = [
                'name'               => 'required|min_length[3]|max_length[30]',
                'nutrients'          => 'required|min_length[3]|max_length[50]',
                'usage_details'      => 'required|min_length[3]|max_length[30]',
                'application_method' => 'required|min_length[3]|max_length[50]',
                'fertilizer_type'    => 'required|in_list[Organic,Chemical]',
                'dosage'             => 'required|min_length[1]|max_length[50]',
                'suitablecrop'       => 'required|min_length[3]|max_length[50]',
                'manufacturer'       => 'required|min_length[3]|max_length[50]',
                'price'              => 'required|numeric',
                'image'              => 'uploaded[image]|is_image[image]|max_size[image,2048]'
            ];

            if (! $this->validate($rules)) {
                $data['validation'] = $this->validator;
                return view('addData/addFertilizer', $data);
            }

            // ✅ Image upload
            $image = $this->request->getFile('image');
            $imageName = $image->getRandomName();

            $uploadPath = 'uploads/fertilizer';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $image->move($uploadPath, $imageName);

            // ✅ Save data
            $model = new FertilizerModel();

            $model->save([
                'name'               => $this->request->getPost('name'),
                'nutrients'          => $this->request->getPost('nutrients'),
                'usage_details'      => $this->request->getPost('usage_details'),
                'application_method' => $this->request->getPost('application_method'),
                'fertilizer_type'    => $this->request->getPost('fertilizer_type'),
                'dosage'             => $this->request->getPost('dosage'),
                'suitablecrop'       => $this->request->getPost('suitablecrop'),
                'manufacturer'       => $this->request->getPost('manufacturer'),
                'price'              => $this->request->getPost('price'),
                'image'              => $imageName,
            ]);

            return redirect()->back()->with('success', 'Fertilizer Added Successfully');
        }

        return view('addData/addFertilizer');
    }

    public function listFertilizer()
    {
        $model = new FertilizerModel();
        $data = $model->findAll();
    
        return $this->response->setJSON([
            'status' => true,
            'data' => $data
        ]);
    }

    public function edit($id)
    {
        $model = new FertilizerModel();
        $data = $model->find($id);

        if (!$data) {
            return $this->respond([
                'status' => false,
                'message' => 'Record not found'
            ], 404);
        }

        return $this->respond([
            'status' => true,
            'data' => $data
        ]);
    }

    // 🔹 UPDATE
     use ResponseTrait;   

    public function update($id)
    {
        $model = new FertilizerModel();
    
        // old image name
        $oldImage = $this->request->getPost('old_image');
    
        $image = $this->request->getFile('image');
    
        // default image = old image
        $imageName = $oldImage;
    
        // if new image uploaded
        if ($image && $image->isValid() && !$image->hasMoved()) {
    
            // new random name
            $imageName = $image->getRandomName();
    
            // move image
            $image->move('uploads/fertilizer', $imageName);
    
            // delete old image
            if ($oldImage && file_exists('uploads/fertilizer/' . $oldImage)) {
                unlink('uploads/fertilizer/' . $oldImage);
            }
        }
    
        // update data
        $model->update($id, [
            'name'            => $this->request->getPost('name'),
            'fertilizer_type' => $this->request->getPost('fertilizer_type'),
            'price'           => $this->request->getPost('price'),
            'image'           => $imageName
        ]);
    
        return $this->respond([
            'status'   => true,
            'message'  => 'Fertilizer updated successfully',
            'redirect' => base_url('fertilizer')
        ]);
    }

    public function delete($id)
    {
        log_message('debug', 'DELETE ID: '.$id);
    
        $model = new FertilizerModel();
    
        if (!$model->find($id)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Record not found'
            ]);
        }
    
        $model->delete($id);
    
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Deleted successfully'
        ]);
    }

}
