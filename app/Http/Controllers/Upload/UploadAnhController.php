<?php
 namespace App\Http\Controllers\Upload;

 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Http;
 use App\Http\Controllers\Controller;
 
 class UploadAnhController extends Controller
 {
     public function showUpAnh()
     {
         return view('upanh.index', [
            'pageTitle' => 'Lấy link ảnh cực nhanh chóng',
        ]);

     }
     public function upload(Request $request)
    {
        if ($request->isMethod('post')) {

            if (!$request->hasFile('file')) {
                return response()->json(['status' => 'error', 'message' => 'Hành động của bạn không hợp lệ !!!']);
            }
            $photo = $request->file('file');
            if ($photo->getClientOriginalName() === '') {
                return response()->json(['status' => 'error', 'message' => 'Bạn hãy chọn ảnh để upload nhé!!!']);
            }
            if ($photo->getSize() > 20000000) {
                return response()->json(['status' => 'error', 'message' => 'Ảnh Quá Lớn, vui lòng chọn file < 20MB']);
            }
            if (!getimagesize($photo->getRealPath())) {
                return response()->json(['status' => 'error', 'message' => 'Có Vẻ Ảnh Bạn Chọn Không Phải Là Ảnh']);
            }

            [$width, $height] = getimagesize($photo->getRealPath());
            if ($width > 30000 || $height > 30000) {
                return response()->json(['status' => 'error', 'message' => 'Chiều dài và rộng của ảnh quá lớn. Hãy upload ảnh nhỏ hơn 20000x20000 px']);
            }
            $allowedExtensions = [".gif", ".png", ".jpg", ".jpeg"];
            $extension = "." . $photo->getClientOriginalExtension();
            if (!in_array(strtolower($extension), $allowedExtensions)) {
                return response()->json(['status' => 'error', 'message' => 'Định Dạng Ảnh Không Được Phép Upload']);
            }
            $client_id = "4ec3406826c04ac";
            $response = Http::withHeaders([
                'Authorization' => 'Client-ID ' . $client_id
            ])->post('https://api.imgur.com/3/image.json', [
                'image' => base64_encode(file_get_contents($photo->getRealPath()))
            ]);

            $reply = $response->json();

            if ($reply['success'] ?? false) {
                return response()->json(['status' => 'success', 'message' => 'Uploads Thành Công', 'link' => $reply['data']['link']]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Không thể upload ảnh của bạn, hãy thử lại!']);
            }
        }

        return response()->json(['status' => 'error', 'message' => 'The Request Not Found'], 404);
    }
 }
 