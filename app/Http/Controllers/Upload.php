<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Upload extends Controller
{
    public function uploader()
    {
        $myhomedir = $_SERVER['DOCUMENT_ROOT'];
        // @include $_SERVER['DOCUMENT_ROOT']. "/cinc/pathvar.php";
        //@include $_SERVER['DOCUMENT_ROOT']. "/cinc/fn.php";

        // Allowed origins to upload images
        // $accepted_origins = array("http://localhost", "http://107.161.82.130", "http://codexworld.com");

        // Images upload path
        $lokasi = '/upload/images/';
        $imageFolder = $myhomedir . $lokasi;

        reset($_FILES);
        $temp = current($_FILES);
        if (is_uploaded_file($temp['tmp_name'])) {

            // Sanitize input
            if (preg_match('/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/', $temp['name'])) {
                header('HTTP/1.1 400 Invalid file name.');
                return;
            }

            // Verify extension
            if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), ['gif', 'jpg', 'png', 'jpeg'])) {
                header('HTTP/1.1 400 Invalid extension.');
                return;
            }

            // Accept upload if there was no origin, or if it is an accepted origin
            $exp_n = explode('.', $temp['name']);

            $str = $exp_n[0];
            $str = trim(strtolower($str));
            $exp = explode('.', $str);
            $str = $exp[0];
            if ($str != '') {
                $str = preg_replace('/[^a-z0-9 \- s]/', '', $str);
                $str = trim($str);
                $str = str_replace(' ', '-', $str);
                $str = str_replace('---', '-', $str);
                $str = str_replace('--', '-', $str);
            }
            if (isset($exp[1])) {
                $str = $str . '.' . $exp[1];
            }

            $nama = $str . '-' . date('YmdHis') . '.' . $exp_n[1];
            //$nama = date('YmdHis')."-".filter_name($temp['name']);
            $filetowrite = $imageFolder . $nama;
            $res_lokasi = $lokasi . $nama;
            move_uploaded_file($temp['tmp_name'], $filetowrite);

            // Respond to the successful upload with JSON.
            echo json_encode(['location' => $res_lokasi]);
        } else {
            // Notify editor that the upload failed
            header('HTTP/1.1 500 Server Error');
        }
    }
}
