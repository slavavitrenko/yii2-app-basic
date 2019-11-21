<?php
/**
 * Created by PhpStorm.
 * User: mxuser
 * Date: 17.05.18
 * Time: 15:48
 */

namespace app\logtargets;


use sergeymakinen\yii\logmessage\Message;
use yii\helpers\Url;
use yii\base\InvalidValueException;
use yii\di\Instance;
use yii\httpclient\Client;
use yii\log\Logger;

class Target extends \sergeymakinen\yii\telegramlog\Target
{


    public function export()
    {
        if (in_array(\Yii::$app->response->statusCode, ['404'])) {
            return;
        }

        $this->messages = [$this->messages[0]];

        foreach (array_map([$this, 'formatMessageRequest'], $this->messages) as $request) {
            $response = $this->httpClient
                ->post('https://api.telegram.org/bot' . $this->token . '/sendMessage', $request)
                ->setFormat(Client::FORMAT_JSON)
                ->send();
            if (!$response->getIsOk()) {
                if (isset($response->getData()['description'])) {
                    $description = $response->getData()['description'];
                } else {
                    $description = $response->getContent();
                }
                throw new InvalidValueException(
                    'Unable to send logs to Telegram: ' . $description, (int)$response->getStatusCode()
                );
            }
        }
    }

    /**
     * Returns an array with the default substitutions.
     * @return array default substitutions.
     */
    protected function defaultSubstitutions()
    {
        return [
            'levelAndRequest' => [
                'title' => null,
                'short' => false,
                'wrapAsCode' => false,
                'value' => function (Message $message) {
                    if (isset($this->levelEmojis[$message->message[1]])) {
                        $value = $this->levelEmojis[$message->message[1]] . ' ';
                    } else {
                        $value = '*' . ucfirst($message->getLevel()) . '* @ ';
                    }
                    if ($message->getIsConsoleRequest()) {
                        $value .= '`' . $message->getCommandLine() . '`';
                    } else {
                        $value .= '[' . $message->getUrl() . '](' . $message->getUrl() . ')';
                    }
                    return $value;
                },
            ],
            'category' => [
                'emojiTitle' => '📖',
                'short' => true,
                'wrapAsCode' => false,
                'value' => function (Message $message) {
                    return '`' . $message->getCategory() . '`';
                },
            ],
            'user' => [
                'emojiTitle' => '🙂',
                'short' => true,
                'wrapAsCode' => false,
                'value' => function (Message $message) {
                    $value = [];
                    $ip = $message->getUserIp();
                    if ((string)$ip !== '') {
                        $value[] = $ip;
                    }
                    $id = $message->getUserId();
                    if ((string)$id !== '') {
                        $value[] = "ID: `{$id}`";
                    }
                    return implode(str_repeat(' ', 4), $value);
                },
            ],
            'stackTrace' => [
                'title' => 'Stack Trace',
                'short' => false,
                'wrapAsCode' => true,
                'value' => function (Message $message) {
                    return $message->getStackTrace();
                },
            ],
            'text' => [
                'title' => null,
                'short' => false,
                'wrapAsCode' => true,
                'value' => function (Message $message) {
                    return $message->getText();
                },
            ],
        ];
    }

}