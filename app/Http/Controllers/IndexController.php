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
        // return view('addcard', ['alert' => $alert, 'data' => $data]);

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
                    if ($adsTk['account_status'] == 1) {
                        $url = "https://graph.facebook.com/v7.0/" . $adsTk['id'] . "?access_token=" . $arrAccItem[1] . "&fields=%5B%22can_pay_now%22%5D";
                        curl_setopt($curl, CURLOPT_URL, $url);
                        $checkRes = curl_exec($curl);
                        if (!empty($checkRes)) {
                            $resData = json_decode($checkRes, true);
                            $data[$key]['hasCard'] = $resData['can_pay_now'] ? "Đã add" : "Chưa add";
                            $data[$key]['canAddCard'] = !$resData['can_pay_now'];
                        } else {
                            $data[$key]['hasCard'] = '-';
                            $data[$key]['canAddCard'] = false;
                        }
                    } else {
                        $data[$key]['hasCard'] = '-';
                        $data[$key]['canAddCard'] = false;
                    }
                }
            }
            curl_close($curl);
        }
        // dd($data);
        return view('addcard', ['alert' => $alert, 'data' => $data]);
    }

    private function getCard()
    {
        $cardFile = storage_path('fbsup/cards.txt');
        $card = self::file_pop($cardFile);
        return !empty($card) ? explode('|', $card) : [];
    }

    private function file_pop($file)
    {
        if ($fp = @fopen($file, "c+")) {
            if (!flock($fp, LOCK_EX)) {
                fclose($fp);
            }
            $pos = -1;
            $found = 0;
            while ($found < 2) {
                if (fseek($fp, $pos--, SEEK_END) < 0) { // can not seek to position
                    rewind($fp); // rewind to the beginnung of the file
                    break;
                };
                if (ord(fgetc($fp)) == 10) { // newline
                    $found++;
                }
            }
            $lastpos = ftell($fp); // get current position of file
            $lastline = fgets($fp); // get current line

            ftruncate($fp, $lastpos); // truncate file to last position
            flock($fp, LOCK_UN); // unlock
            fclose($fp); // close the file

            return trim($lastline);
        }
    }

    public function addCard($id)
    {
        // card
        $arrcard = self::getCard();
        if (empty($arrcard)) {
            return response()->json([
                'status' => false,
                'data' => ['Không lấy được thẻ!']
            ]);
        }

        $cookie_file = storage_path('fbsup/facebook.com_cookies.txt');
        if (!file_exists($cookie_file)) {
            return response()->json([
                'status' => false,
                'data' => ['Không lấy được Cookie!']
            ]);
        }
        $url = "https://business.facebook.com/help/contact/649167531904667?ref=4";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $headers = [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Accept-Language: en-US,en;q=0.9',
            'Cache-Control: max-age=0',
            'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
            'Host: business.facebook.com',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36'
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_file);
        $data = curl_exec($curl);
        if (empty($data)) {
            return response()->json([
                'status' => false,
                'data' => ['Không load được contact form!']
            ]);
        }

        // Get cookie
        $c_user = '';
        $spin = '';
        $cookies = curl_getinfo($curl, CURLINFO_COOKIELIST);
        foreach ($cookies as $cookie) {
            $arrPath = explode("\t", $cookie);
            if ($arrPath[5] == 'c_user') {
                $c_user = $arrPath[6];
            }

            if ($arrPath[5] == 'spin') {
                $arrspin = !empty($arrPath[6]) ? explode('_', $arrPath[6]) : [];
                $spinR = !empty($arrspin[0]) ? explode('.', $arrspin[0]) : [];
                $spin = !empty($spinR[1]) ? $spinR[1] : '';
            }
        }

        if (empty($c_user)) {
            return response()->json([
                'status' => false,
                'data' => ['Không lấy được VIA!']
            ]);
        }

        if (empty($spin)) {
            return response()->json([
                'status' => false,
                'data' => ['Không lấy được SPIN!']
            ]);
        }

        $doc = new \DOMDocument();
        $doc->loadHTML($data);
        $fb_dtsg = '';
        $jazoest = '';
        foreach ($doc->getElementsByTagName('input') as $hideninput) {
            if ($hideninput->getAttribute('name') == 'fb_dtsg') {
                $fb_dtsg = $hideninput->getAttribute('value');
            }

            if ($hideninput->getAttribute('name') == 'jazoest') {
                $jazoest = $hideninput->getAttribute('value');
            }
        }

        if (empty($fb_dtsg)) {
            return response()->json([
                'status' => false,
                'data' => ['Không lấy được fb_dtsg!']
            ]);
        }

        if (empty($jazoest)) {
            return response()->json([
                'status' => false,
                'data' => ['Không lấy được jazoest!']
            ]);
        }

        $fields = [
            'kpts' => '',
            'account_id' => $id,
            'app_id' => '123097351040126',
            'country' => 'US',
            'context_id' => '107084634720026',
            'tracking_id' => '18C5oXv7XQsimbONs',
            'payment_item_type' => '2',
            'auth_currency' => 'EUR',
            'is_checkout_eligible' => false,
            'checkout_save_cc_with_auth' => false,
            'checkout_fund_amount' => 0,
            'is_stored_balance' => true,
            'flow_placement' => 'ads_support_add_payment_method',
            'flow_type' => '',
            'checks[csc]' => true,
            'cc_save' => true,
            'creditCardNumber' => $arrcard[0],
            'csc' => $arrcard[3],
            'zip' => '',
            'is_from_support' => true,
            'source_support_form_id' => '649167531904667',
            'geo_country' => 'US',
            'exp[month]' => $arrcard[1],
            'exp[year]' => substr($arrcard[2], -2),
            '__user' => $c_user,
            '__a' => '1',
            '__dyn' => '',
            '__csr' => '',
            '__req' => 'o',
            '__beoa' => '0',
            '__pc' => 'PHASED:DEFAULT',
            'dpr' => '1',
            '__ccg' => 'EXCELLENT',
            '__rev' => '1003215054',
            '__s' => '0wl8pd:crnaz0:vf1xfc',
            '__hsi' => '6921694125378614995-0',
            'fb_dtsg' => $fb_dtsg,
            'jazoest' => $jazoest,
            '__spin_r' => $spin,
            '__spin_b' => "trunk",
            '__spin_t' => time() . '',
            '__jssesw' => "1",
        ];

        $fields_string = http_build_query($fields);

        curl_setopt($curl, CURLOPT_URL, 'https://business.secure.facebook.com/ajax/payment/token_proxy.php?tpe=%2Fpayments%2Fcredit_card%2Fmutator%2Fcreate%2F&__a=1');
        $headers = [
            'accept: */*',
            'accept-language: en-US,en;q=0.9',
            'Cache-Control: max-age=0',
            'origin: https://business.facebook.com',
            'referer: https://business.facebook.com/',
            'content-type: application/x-www-form-urlencoded',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36'
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        // curl_setopt($curl, CURLOPT_HEADER, 1);
        // curl_setopt($curl, CURLINFO_HEADER_OUT, true);

        $result = curl_exec($curl);
        // $info = curl_getinfo($curl);
        // $response = json_decode($result, true);
        curl_close($curl);
        // dd([$result]);
        if (empty($result)) {
            return response()->json([
                'status' => false,
                'data' => ['Lỗi khi post dữ liệu!']
            ]);
        } else {
            $result = str_replace("for (;;);", '', $result);
            $response = json_decode($result, true);
            return response()->json([
                'status' => true,
                'data' => $response
            ]);
        }
    }
}
