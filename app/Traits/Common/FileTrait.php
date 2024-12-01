<?php

namespace App\Traits\Common;

use App\Models\Core\File;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

trait FileTrait{
    /**
     * @param Request $request
     * @param $key
     * @param string $type
     * @return void|null
     *
     * Save file to storage
     */
    public function saveFile(Request $request, $key, string $type = 'img'){
        if($request->has($key)){
            try{
                $file = $request->file($key);
                $ext = pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION);
                $name = md5($file->getClientOriginalName().time()).'.'.$ext;

                $file->move($request->path, $name);

                return File::create([
                    'file' => $file->getClientOriginalName(),
                    'name' => $name,
                    'ext' => $ext,
                    'type' => $type,
                    'path' => $request->path
                ]);
            }catch (\Exception $e){ return null; }
        }else return null;
    }

    /**
     * Remove File from database (ToDo - Unlink file from server)
     * @param $id
     * @return void
     */
    public function remove($id): void {
        try{
            $file = File::where('id', '=', $id)->first();
            // unlink(public_path($file->getFile()));
            $file->delete();
        }catch (\Exception $e){}
    }

    /**
     *  Save image to public path (Only works with jpg, jpeg, png ...); Arguments:
     *
     *      - uri (uri to image on web)
     *      - path (path to public or storage path in app)
     *      - name of file
     */

    protected function curl_get_file_contents($URL){
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
        else return FALSE;
    }

    protected function fetchAndSave($uri, $path, $name): bool{
        try{
            // $fileContent = file_get_contents($uri);
            $fileContent = $this->curl_get_file_contents($uri);

            file_put_contents($path . $name, $fileContent);
        }catch (\Exception $e){
            return false;
        }

        return true;
    }
}
