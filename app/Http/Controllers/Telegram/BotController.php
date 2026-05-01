<?php

namespace App\Http\Controllers\Telegram;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class BotController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $data = $request->all();

        if (isset($data['message']['text'])) {
            $text = trim($data['message']['text']);
            $chatId = $data['message']['chat']['id'];
            $username = $data['message']['from']['username'] ?? 'dvr';

            if (str_starts_with($text, '/start')) {
                $accessToken = str_replace('/start ', '', $text);
                $usercheck = User::where('chat_id', $chatId)->first();
                if ($usercheck) {
                    $this->sendMessage($chatId, "Tài khoản Telegram này đã được liên kết bot.");
                    return;
                }
                $user = User::where('access_token', $accessToken)->first();
                if (!$user) {
                    $this->sendMessage($chatId, "Access token không hợp lệ. Vui lòng thử lại.");
                    return;
                }
                if ($user->chat_id != null) {
                    $this->sendMessage($chatId, "Tài khoản của bạn đã xác thực bot rồi.");
                    return;
                }
                $user->chat_id = $chatId;
                $user->save();
                $this->Dvrtele2($chatId, "Xác thực thành công! Tài khoản của bạn đã được liên kết.");
                return;
            }

            if (str_starts_with($text, '/info')) {
                $user = User::where('chat_id', $chatId)->first();
                if ($user) {
                    $message = "Chào Bạn\n" . "<strong>$user->name</strong>\n";
                    $jsonData = [
                        "status" => "success",
                        "username" => $user->username,
                        "name" => $user->name,
                        "balance" => number_format($user->balance) . " VND",
                        "total_deposit" => number_format($user->total_deposit) . " VND",
                        "created_at" => $user->created_at,
                    ];
                    $message .= "<pre>" . json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "</pre>";
                    $this->Dvrtele1($chatId, $message);
                } else {
                    $this->sendMessage($chatId, "Vui lòng liên kết bot để lấy thông tin.");
                }
                return;
            }

            if (str_starts_with($text, '/help')) {
                $user = User::where('chat_id', $chatId)->first();
                if ($user) {
                    $message = "<pre>🔥 Có vẻ $username đang cần hỗ trợ về lệnh 🔥\n\n";
                    $message .= "📌 Danh sách các lệnh:\n";
                    $message .= "🔹 /info - Lấy thông tin user\n";
                    $message .= "🔹 /help - Xem hướng dẫn\n";
                    $message .= "🔹 /tiktok link_video - Để lấy thông tin video từ tiktok\n";
                    $message .= "</pre>";
                    $this->Dvrtele1($chatId, $message);
                } else {
                    $this->sendMessage($chatId, "Vui lòng liên kết bot để lấy thông tin.");
                }
                return;
            }

            if (str_starts_with($text, '/tiktok')) {
                $link = trim(str_replace('/tiktok ', '', $text));
                if (empty($link)) {
                    $message = "Vui lòng /tiktok link_cần_lấy để lấy thông tin video";
                    $this->Dvrtele1($chatId, $message);
                    return;
                }

                $apiUrl = env('APP_URL') . "/api/tiktok?link={$link}";
                $response = @file_get_contents($apiUrl);

                if ($response === false) {
                    $message = "Không thể lấy thông tin từ video TikTok này";
                    $this->Dvrtele1($chatId, $message);
                    return;
                }

                $tiktok = json_decode($response, true);

                if (!isset($tiktok['data']) || !is_array($tiktok['data'])) {
                    $message = "Vui lòng /tiktok link_cần_lấy để lấy thông tin video.";
                    $this->Dvrtele1($chatId, $message);
                    return;
                }

                $timestamp = $tiktok['data']['create_time'] ?? null;
                $readableTime = $timestamp ? Carbon::createFromTimestamp($timestamp)->toDateTimeString() : 'Không xác định';
                $audioUrl = $tiktok['data']['music'] ?? null;

                $user = User::where('chat_id', $chatId)->first();
                if ($user) {
                    $message = "<blockquote>🔥 " . ($tiktok['data']['title'] ?? 'Không có tiêu đề') . " 🔥\n\n";
                    $message .= "🌍 Khu vực: " . ($tiktok['data']['region'] ?? 'Không rõ') . "\n";
                    $message .= "👤 Tác giả: " . ($tiktok['data']['author']['nickname'] ?? 'Không rõ') . "\n";
                    $message .= "👁️ Lượt xem: " . number_format($tiktok['data']['play_count'] ?? 0) . "\n";
                    $message .= "❤️ Lượt thích: " . number_format($tiktok['data']['digg_count'] ?? 0) . "\n";
                    $message .= "💬 Bình luận: " . number_format($tiktok['data']['comment_count'] ?? 0) . "\n";
                    $message .= "🔄 Chia sẻ: " . number_format($tiktok['data']['share_count'] ?? 0) . "\n";
                    $message .= "📥 Tải về: " . number_format($tiktok['data']['download_count'] ?? 0) . "\n";
                    $message .= "⭐️ Yêu thích: " . number_format($tiktok['data']['collect_count'] ?? 0) . "\n";
                    $message .= "⏰ Thời gian tải lên: $readableTime\n";
                    $message .= "</blockquote>";
                    $this->Dvrtele1($chatId, $message);

                    if ($audioUrl) {
                        $this->sendAudio($chatId, $audioUrl);
                    }
                } else {
                    $this->sendMessage($chatId, "Vui lòng liên kết bot để lấy thông tin.");
                }
                return;
            }
        }
    }

    private function sendMessage($chatId, $message)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $url = "https://api.telegram.org/bot$botToken/sendMessage";
        $response = file_get_contents($url . "?chat_id=$chatId&text=" . urlencode($message));
        return json_decode($response, true);
    }

    private function Dvrtele2($tele_chatid, $message)
    {
        $tele_token = env('TELEGRAM_BOT_TOKEN');
        $facebookLink = setting('link_fb');
        $websiteLink = env('APP_URL');
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '🌐 Thăm Website', 'url' => $websiteLink],
                    ['text' => '📱Facebook Fanpage', 'url' => $facebookLink]
                ]
            ]
        ];
        $data = http_build_query([
            'chat_id' => $tele_chatid,
            'text' => $message,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode($keyboard)
        ]);
        $url = 'https://api.telegram.org/bot' . $tele_token . '/sendMessage';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private function Dvrtele1($tele_chatid, $message)
    {
        $tele_token = env('TELEGRAM_BOT_TOKEN');
        $data = http_build_query([
            'chat_id' => $tele_chatid,
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);
        $url = 'https://api.telegram.org/bot' . $tele_token . '/sendMessage';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private function sendAudio($chatId, $audioUrl)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $url = "https://api.telegram.org/bot$botToken/sendAudio";
        $ch = curl_init();
        $data = [
            'chat_id' => $chatId,
            'audio' => $audioUrl
        ];
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
    private function sendVideo($chatId, $videoUrl)
   {
    $botToken = env('TELEGRAM_BOT_TOKEN');
    $url = "https://api.telegram.org/bot$botToken/sendVideo";

    $ch = curl_init();

    $data = [
        'chat_id' => $chatId,
        'video' => $videoUrl,
    ];

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
    }

}
