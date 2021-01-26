<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $alert = [];
        $accFile = storage_path('fbsup/acc.txt');
        if (!file_exists($accFile)) {
            $alert[] = 'Chưa có file BM! hãy thêm file: ' . $accFile;
        }

        $cookie_file = storage_path('fbsup/facebook.com_cookies.txt');
        if (!file_exists($cookie_file)) {
            $alert[] = 'Chưa có file cookies! hãy thêm file: ' . $cookie_file;
        }

        $arrAcc = [];
        if (file_exists($accFile)) {
            $file = fopen($accFile, "r");
            while (!feof($file)) {
                $arrAcc[] = fgets($file);
            }
            fclose($file);
        }

        $data = [];
        if (!empty($arrAcc)) {
            $arrAccItem = explode('|', $arrAcc[0]);
            $url = "https://graph.facebook.com/v7.0/$arrAccItem[0]/client_ad_accounts?access_token=$arrAccItem[1]&limit=300&fields=%5B%22id%22%2C%22name%22%2C%22account_id%22%2C%22account_status%22%5D";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $headers = [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'Accept-Language: en-US,en;q=0.9',
                'Cache-Control: max-age=0',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36'
            ];
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);
            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file);
            $res = curl_exec($curl);
            if (!empty($res)) {
                $resData = json_decode($res, true);
                $data = $resData['data'];

                //Check card
                foreach ($data as $key => $adsTk) {
                    $url = "https://graph.facebook.com/v7.0/" . $adsTk['id'] . "?access_token=" . $arrAccItem[1] . "&fields=%5B%22can_pay_now%22%5D";
                    curl_setopt($curl, CURLOPT_URL, $url);
                    $checkRes = curl_exec($curl);
                    if (!empty($checkRes)) {
                        $resData = json_decode($checkRes, true);
                        $data[$key]['hasCard'] = $resData['can_pay_now'] ? "Đã add thẻ" : "Chưa add thẻ";
                    }
                }
            }
            curl_close($curl);
        }

        return view('addcard', ['alert' => $alert, 'data' => $data]);
    }
}
