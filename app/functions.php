<?php
/**
 * Created by PhpStorm.
 * User: mxuser
 * Date: 05.03.19
 * Time: 10:05
 */

function DMF($data = '')
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die();
}

function icon($name)
{
    return \yii\bootstrap\Html::tag('i', '', ['class' => 'glyphicon glyphicon-' . $name]);
}

function t($category = 'app', $message = null, $params = [])
{
    if (($message !== null) && !is_array($message)) {
        return Yii::t($category, $message, $params);
    } elseif (($message !== null) && is_array($message) && is_string($params)) {
        return Yii::t($params, $category, $message);
    } else {
        $params = $message ?: [];
        $message = $category;
        return Yii::t('app', $message, $params);
    }
}

function app()
{
    return Yii::$app;
}

function logger($action, $details = '')
{
    if (user()->isGuest) {
        return;
    }
    return \app\models\Logs::log($action, $details);
}


/* @return \app\components\User */
function user()
{
    return app()->user;
}

function can($permissionName, $params = [], $allowCaching = true)
{
    return user()->can($permissionName, $params, $allowCaching);
}

/* @return \app\models\user\User|\yii\web\IdentityInterface */
function identity($autorenew = true)
{
    return user()->getIdentity($autorenew);
}

function admins()
{
    return \app\models\user\User::find()->where(['is_admin' => true])->all();
}

function orgs()
{
    return \app\models\user\User::find()->joinWith(['company'])->andWhere(['companies.can_org' => true])->all();
}

function clients()
{
    return \app\models\user\User::find()->joinWith(['company'])->andWhere(['companies.can_client' => true])->all();
}

function map($array, $from, $to, $group = null)
{
    return \yii\helpers\ArrayHelper::map($array, $from, $to, $group);
}

function url($url = '', $scheme = true)
{
    return yii\helpers\Url::to($url, $scheme);
}

function cache()
{
    return app()->cache;
}

/* @return \app\components\Templater */
function templater()
{
    return Yii::$app->templater;
}

function response()
{
    return app()->response;
}

/* @return \app\components\Request */
function request()
{
    return app()->request;
}

function cookies()
{
    return request()->cookies;
}

function is_sidebar_collapsed()
{
    return cookies()->get('sidebar-collapsed');
}

/* @return \app\components\Requester */
function requester()
{
    return app()->requester;
}

function security()
{
    return app()->security;
}

function post($name = null, $defaultValue = null)
{
    return request()->post($name, $defaultValue);
}

function session()
{
    return app()->session;
}

function setFlash($message, $type = 'success')
{
    return session()->addFlash($type, $message);
}

function db()
{
    return app()->db;
}

function controller()
{
    return app()->controller;
}

function action()
{
    return controller()->action;
}

function warning($message, $category = 'application')
{
    Yii::warning($message, $category);
}

function createObject($type, array $params = [])
{
    return Yii::createObject($type, $params);
}

/* @return \app\components\Formatter */
function formatter()
{
    return app()->formatter;
}

function encode($content, $doubleEncode = true)
{
    return \yii\helpers\Html::encode($content, $doubleEncode);
}

function isWeb()
{
    return app() instanceof \yii\web\Application;
}

function isConsole()
{
    return app() instanceof \yii\console\Application;
}

function sendMessage($user_id, $text, $email = true)
{
    return \app\models\system\Notifications::send($user_id, $text, $email);
}

function sendBatchMessage($userIds, $text, $email = true, $refresh = false)
{
    return \app\models\system\Notifications::sendBatch($userIds, $text, $email, $refresh);
}

function getValue($array, $key, $default = null)
{
    return \yii\helpers\ArrayHelper::getValue($array, $key, $default);
}

function toArray($data)
{
    return \yii\helpers\Json::decode(\yii\helpers\Json::encode($data));
}

function merge($a, $b)
{
    $args = func_get_args();
    $res = array_shift($args);
    while (!empty($args)) {
        $next = array_shift($args);
        foreach ($next as $k => $v) {
            if ($v instanceof yii\helpers\UnsetArrayValue) {
                unset($res[$k]);
            } elseif ($v instanceof yii\helpers\ReplaceArrayValue) {
                $res[$k] = $v->value;
            } elseif (is_int($k)) {
                if (isset($res[$k])) {
                    $res[] = $v;
                } else {
                    $res[$k] = $v;
                }
            } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                $res[$k] = merge($res[$k], $v);
            } else {
                $res[$k] = $v;
            }
        }
    }

    return $res;
}

function short($str, $length = 70)
{
    $placeholder = '...';
    if (mb_strlen($str) <= $length) {
        return $str;
    } else {
        return mb_substr($str, 0, $length - mb_strlen($placeholder)) . $placeholder;
    }
}

function shortTag($text, $length = 255, $encode = true)
{
    if ($encode) {
        $text = encode($text);
    }
    $divider = '...';
    if ((mb_strlen($text) - mb_strlen($divider)) >= $length) {
        $shorten = mb_substr($text, 0, $length - mb_strlen($divider)) . yii\helpers\Html::tag('span', $divider, ['class' => 'placeholder']) . icon('chevron-right show-more')
            .
            yii\helpers\Html::tag('span', mb_substr($text, $length - mb_strlen($divider)), ['class' => 'hidden']);
        return yii\helpers\Html::tag('span', $shorten, ['class' => 'shorted']);
    }
    return $text;
}

function dots2minus($value)
{
    return str_replace('.', '-', $value);
}

function dateDbToHuman($value)
{
    if (!$value) return;
    return Datetime::createFromFormat('Y-m-d', $value)->format(formatter()->dateFormatClear);
}

function dateHumanToDb($value)
{
    if (!$value) return;
    return Datetime::createFromFormat(formatter()->dateFormatClear, $value)->format('Y-m-d');
}

function datetimeDbToHuman($value)
{
    if (!$value) return;
    return Datetime::createFromFormat('Y-m-d H:i:s', $value)->format(formatter()->datetimeFormatClear);
}

function datetimeHumanToDb($value)
{
    if (!$value) return;
    return Datetime::createFromFormat(formatter()->datetimeFormatClear, $value)->format('Y-m-d H:i:s');
}

function typecastDate($value, $reverse = false)
{
    if ($reverse) {
        return dateDbToHuman($value);
    }
    return dateHumanToDb($value);
}

function typecastDatetime($value, $reverse = false)
{
    if (!$value) {
        return;
    }
    if ($reverse) {
        return datetimeDbToHuman($value);
    }
    return datetimeHumanToDb($value);
}

function money($money)
{
    return formatter()->asMoney($money);
}

function volume($volume)
{
    return formatter()->asVolume($volume);
}

function number($number, $decimals = 0, $dec_point = '.', $thousands_sep = ' ')
{
    return formatter()->asNumber($number, $decimals, $dec_point, $thousands_sep);
}

function get_timezone_offset($remote_tz, $origin_tz = null)
{
    if ($origin_tz === null) {
        if (!is_string($origin_tz = date_default_timezone_get())) {
            return false; // A UTC timestamp was returned -- bail out!
        }
    }
    $origin_dtz = new DateTimeZone($origin_tz);
    $remote_dtz = new DateTimeZone($remote_tz);
    $origin_dt = new DateTime("now", $origin_dtz);
    $remote_dt = new DateTime("now", $remote_dtz);
    $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
    return $offset;
}

function num2str($num, $type = 'грн')
{
    if ($type == 'грн') {
        $nul = 'нуль';
        $ten = array(
            array('', 'один', 'два', 'три', 'чотири', 'п`ять', 'шість', 'сім', 'вісім', 'дев`ять'),
            array('', 'одна', 'дві', 'три', 'чотири', 'п`ять', 'шість', 'сім', 'вісім', 'дев`ять'),
        );
        $a20 = array('десять', 'одинадцять', 'дванадцять', 'тринадцять', 'чотирнадцять', 'п`ятнадцять', 'шістнадцять', 'сімнадцять', 'вісімнадцять', 'дев`ятнадцять');
        $tens = array(2 => 'двадцять', 'тридцять', 'сорок', 'п`ятдесят', 'шістдесят', 'сімдесят', 'вісімдесят', 'дев`яносто');
        $hundred = array('', 'сто', 'двісті', 'триста', 'чотириста', 'п`ятьсот', 'шістьсот', 'сімсот', 'вісімсот', 'дев`ятьсот');
        $unit = array( // Units
            array('копійка', 'копійки', 'копійок', 1),
            array('гривня', 'гривні', 'гривень', 0),
            array('тисяча', 'тисячі', 'тисяч', 1),
            array('мільйон', 'мільйони', 'мільйонів', 0),
            array('мільярд', 'мільярди', 'мільярдів', 0),
        );
    } else {
        $nul = 'нуль';
        $ten = array(
            array('', 'один', 'дві', 'три', 'чотири', 'п`ять', 'шість', 'сім', 'вісім', 'дев`ять'),
            array('', 'одна', 'дві', 'три', 'чотири', 'п`ять', 'шість', 'сім', 'вісім', 'дев`ять'),
        );
        $a20 = array('десять', 'одинадцять', 'дванадцять', 'тринадцять', 'чотирнадцять', 'п`ятнадцять', 'шістнадцять', 'сімнадцять', 'вісімнадцять', 'дев`ятнадцять');
        $tens = array(2 => 'двадцять', 'тридцять', 'сорок', 'п`ятдесят', 'шістдесят', 'сімдесят', 'вісімдесят', 'дев`яносто');
        $hundred = array('', 'сто', 'двісті', 'триста', 'чотириста', 'п`ятьсот', 'шістьсот', 'сімсот', 'вісімсот', 'дев`ятьсот');
        $unit = array( // Units
            array('цент', 'центи', 'центів', 1),
            array('долар', 'долари', 'доларів', 0),
            array('тисяча', 'тисячі', 'тисяч', 1),
            array('мільйон', 'мільйони', 'мільйонів', 0),
            array('мільярд', 'мільярди', 'мільярдів', 0),
        );
    }

    list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
    $out = array();
    if (intval($rub) > 0) {
        foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
            if (!intval($v)) continue;
            $uk = sizeof($unit) - $uk - 1; // unit key
            $gender = $unit[$uk][3];
            list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
            // mega-logic
            $out[] = $hundred[$i1]; # 1xx-9xx
            if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; # 20-99
            else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
            // units without rub & kop
            if ($uk > 1) $out[] = morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
        } //foreach
    } else $out[] = $nul;
    $out[] = morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
    $out[] = $kop . ' ' . morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
    return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
}

/**
 * Склоняем словоформу
 */
function morph($n, $f1, $f2, $f5)
{
    $n = abs(intval($n)) % 100;
    if ($n > 10 && $n < 20) return $f5;
    $n = $n % 10;
    if ($n > 1 && $n < 5) return $f2;
    if ($n == 1) return $f1;
    return $f5;
}