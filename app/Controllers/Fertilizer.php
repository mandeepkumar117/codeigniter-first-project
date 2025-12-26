<?php

namespace App\Controllers;
use App\Models\FertilizerModel;

class Fertilizer extends BaseController
{
    public function index()
    {
        return view('pages/fertilizer');
    }
    public function add()
    {
        // सिर्फ form दिखाने के लिए
        return view('addData/addFertilizer');
    }
    public function edit($id)
    {
        $model = new FertilizerModel();
        return view('pages/edit_fertilizer', [
            'fertilizer' => $model->find($id)
        ]);
    }

    public function update($id)
{
    $model = new FertilizerModel();

    $imageFile = $this->request->getFile('image');
    $oldImage  = $this->request->getPost('old_image');

    // default image
    $imageName = $oldImage;

    if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
        $imageName = $imageFile->getRandomName();
        $imageFile->move('uploads/fertilizer', $imageName);

        // old image delete
        if ($oldImage && file_exists('uploads/fertilizer/'.$oldImage)) {
            unlink('uploads/fertilizer/'.$oldImage);
        }
    }

    $model->update($id, [
        'name'            => $this->request->getPost('name'),
        'fertilizer_type' => $this->request->getPost('fertilizer_type'),
        'price'           => $this->request->getPost('price'),
        'image'           => $imageName,
    ]);

    return redirect()->to(base_url('fertilizer'))
        ->with('success', 'Fertilizer Updated Successfully');
}

}
?>