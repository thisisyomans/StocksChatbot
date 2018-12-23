<?php
namespace MyProject;

use App\Http\Controllers\BotManController;

$botman = resolve('botman');
$nameOfUser;
$myUrl;
$urlResult;
$result;
$date;
$timeSeries30 = 'Time Series (30min)';

//const INTERVAL_1 = '1min';
//const INTERVAL_5 = '5min';
//const INTERVAL_15 = '15min';
const INTERVAL_30 = '30min';
//const INTERVAL_60 = '60min';

const INTRADAY = 'TIME_SERIES_INTRADAY';
const DAILY = 'TIME_SERIES_DAILY';
const DAILY_ADJUSTED = 'TIME_SERIES_DAILY_ADJUSTED';
const WEEKLY = 'TIME_SERIES_WEEKLY';
const WEEKLY_ADJUSTED = 'TIME_SERIES_WEEKLY_ADJUSTED';
const MONTHLY = 'TIME_SERIES_MONTHLY';
const MONTHLY_ADJUSTED = 'TIME_SERIES_MONTHLY_ADJUSTED';
const QUOTE = 'GLOBAL_QUOTE';

class MyBotCommands {
    public function handleHiHello($bot) {
        $bot->reply('Hello! How are you?');
    }
    public function handleConditionReply($bot) {
        $bot->reply('I\'m good!');
    }
    public function nameFind($bot, $name) {
        $bot->reply('Nice to meet you '.$name);
        $nameOfUser = $name;
    }
    public function timeSeriesInfo($bot) {
        $bot->reply('Enter the information for the stocks you would like to see in the following format:');
        $bot->reply('\'Time Series Function\', \'Equity Symbol\'');
        $bot->reply("Your options for functions are:\nINTRADAY,\nDAILY,\nDAILY_ADJUSTED,\nWEEKLY,\nWEEKLY_ADJUSTED,\nMONTHLY,\nMONTHLY_ADJUSTED,\nQUOTE");
    }
    public function timeSeries($bot, $function, $symbol) {
        $myUrl = 'https://www.alphavantage.co/query?function='.$function.'&symbol='.$symbol.'&interval=30min&apikey='.$apikey;
        $urlResult = file_get_contents(urlencode($myUrl));
        $result = json_decode($urlResult, true);
        $date = date('Y-m-d H:30:00');
        var_dump($result);
        $bot->reply($result->$timeSeries30->$date);
        //url encoding: 'https://www.alphavantage.co/query?function='.$function.'&symbol='.$symbol.'&interval=30min&apikey='.apikey
    }
}

//TODO: add regex for easier word detection
//user's greeting
$botman->hears('Hi', 'MyProject\MyBotCommands@handleHiHello');
$botman->hears('Hello', 'MyProject\MyBotCommands@handleHiHello');
$botman->hears('Hi\!', 'MyProject\MyBotCommands@handleHiHello');
$botman->hears('Hello\!', 'MyProject\MyBotCommands@handleHiHello');
$botman->hears('Hi\.', 'MyProject\MyBotCommands@handleHiHello');
$botman->hears('Hello\.', 'MyProject\MyBotCommands@handleHiHello');
//bot response to condition question
$botman->hears('How are you', 'MyProject\MyBotCommands@handleConditionReply');
$botman->hears('How are you\?', 'MyProject\MyBotCommands@handleConditionReply');
//detect the user's name or nickname
$botman->hears('My name is {name}', 'MyProject\MyBotCommands@nameFind');
$botman->hears('My name is {name}\.', 'MyProject\MyBotCommands@nameFind');
$botman->hears('Call me {name}', 'MyProject\MyBotCommands@nameFind');
$botman->hears('Call me {name}\.', 'MyProject\MyBotCommands@nameFind');
//giving user info on how to get time series data
$botman->hears('stocks', 'MyProject\MyBotCommands@timeSeriesInfo');
$botman->hears('stocks info', 'MyProject\MyBotCommands@timeSeriesInfo');
$botman->hears('stocks\?', 'MyProject\MyBotCommands@timeSeriesInfo');
//giving time series data live
$botman->hears('{function}, {symbol}', 'MyProject\MyBotCommands@timeSeries');
//joke or fact (possible candidate for removal?)
$botman->hears('Start conversation', BotManController::class.'@startConversation');
$botman->hears('Start conversation\.', BotManController::class.'@startConversation');