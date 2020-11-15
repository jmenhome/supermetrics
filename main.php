<?php
/**
 * Main assigment file, please run it in console
 */

require (__DIR__.'/config.php');
require (__DIR__.'/components/autoloader.php');

use Supermetrics\Api;
use Supermetrics\Stat;

//create api instance
$api = new Api([
    'client_id' => TEST_CLIENT_ID,
    'email' => TEST_EMAIL,
    'name' => TEST_USER_NAME,
]);

//register token
echo 'Token:';
$api->register();
echo ' registered "'.$api->token.'"'."\n";

//load posts
$posts = [];
for ($page = 1; $page <= 10; $page++) {
    echo 'Page '.$page.':';
    $p = $api->posts($page);
    echo ' '.count($p).' loaded'."\n";

    $posts = array_merge($posts, $p);
}

echo 'Total loaded: '.count($posts)."\n";

echo 'a. - Average character length of posts per month'."\n";
$months = Stat::getAveragePostLengthPerMonth($posts);
echo json_encode($months);
echo "\n\n";

echo 'b. - Longest post by character length per month'."\n";
$months = Stat::getLongestPostPerMonth($posts);
echo json_encode($months);
echo "\n\n";

echo 'c. - Total posts split by week number'."\n";
$weeks = Stat::getPostsCountPerWeek($posts);
echo json_encode($weeks);
echo "\n\n";

echo 'd. - Average number of posts per user per month'."\n";
$months = Stat::getAveragePostsNumberPerUserPerMonth($posts);
echo json_encode($months);
echo "\n\n";