<?php

use Supermetrics\Post;
use Supermetrics\Stat;

class StatTest
{
    public function testGetAveragePostLengthPerMonth()
    {
        $i = 0;

        $posts = [
            new Post([
                'id' => 'post'.($i++),
                'from_name' => 'Test test',
                'from_id' => 'user_12',
                'message' => 'a',
                'type' => 'status',
                'created_time' => '2020-05-13T14:41:42+00:00',
            ]),
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_12',
                         'message' => 'ab',
                         'type' => 'status',
                         'created_time' => '2020-06-05T14:41:42+00:00',
                     ]),
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_12',
                         'message' => 'ab',
                         'type' => 'status',
                         'created_time' => '2020-06-10T14:41:42+00:00',
                     ]),
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_12',
                         'message' => 'aaaa',
                         'type' => 'status',
                         'created_time' => '2020-07-13T14:41:42+00:00',
                     ]),
        ];

        $result = Stat::getAveragePostLengthPerMonth($posts);

        return (3==count($result))
            && (isset($result['2020-05']) && 1 == $result['2020-05'])
            && (isset($result['2020-06']) && 2 == $result['2020-06'])
            && (isset($result['2020-07']) && 4 == $result['2020-07']);
    }

    public function testGetLongestPostPerMonthA()
    {
        $i = 0;

        $posts = [
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_12',
                         'message' => 'a',
                         'type' => 'status',
                         'created_time' => '2020-05-13T14:41:42+00:00',
                     ]),
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_12',
                         'message' => 'ab',
                         'type' => 'status',
                         'created_time' => '2020-06-05T14:41:42+00:00',
                     ]),
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_12',
                         'message' => 'ab',
                         'type' => 'status',
                         'created_time' => '2020-06-10T14:41:42+00:00',
                     ]),
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_12',
                         'message' => 'aaaa',
                         'type' => 'status',
                         'created_time' => '2020-07-13T14:41:42+00:00',
                     ]),
        ];

        $result = Stat::getLongestPostPerMonth($posts);

        return (3==count($result))
            && (isset($result['2020-05']['length']) && 1 == $result['2020-05']['length'])
            && (isset($result['2020-06']['length']) && 2 == $result['2020-06']['length'])
            && (isset($result['2020-07']['length']) && 4 == $result['2020-07']['length']);
    }

    public function testGetPostsCountPerWeekA()
    {
        $i = 0;

        $posts = [
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_12',
                         'message' => 'a',
                         'type' => 'status',
                         'created_time' => '2020-05-13T14:41:42+00:00',
                     ]),
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_12',
                         'message' => 'ab',
                         'type' => 'status',
                         'created_time' => '2020-06-05T14:41:42+00:00',
                     ]),
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_12',
                         'message' => 'ab',
                         'type' => 'status',
                         'created_time' => '2020-06-06T14:41:42+00:00',
                     ]),
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_12',
                         'message' => 'aaaa',
                         'type' => 'status',
                         'created_time' => '2020-07-13T14:41:42+00:00',
                     ]),
        ];

        $result = Stat::getPostsCountPerWeek($posts);

        return (3==count($result))
            && (isset($result[20]) && 1 == $result[20])
            && (isset($result[23]) && 2 == $result[23])
            && (isset($result[29]) && 1 == $result[29]);
    }

    public function testGetAveragePostsNumberPerUserPerMonthA()
    {
        $i = 0;

        $posts = [
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_12',
                         'message' => 'a',
                         'type' => 'status',
                         'created_time' => '2020-05-13T14:41:42+00:00',
                     ]),
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_12',
                         'message' => 'ab',
                         'type' => 'status',
                         'created_time' => '2020-06-05T14:41:42+00:00',
                     ]),
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_12',
                         'message' => 'ab',
                         'type' => 'status',
                         'created_time' => '2020-06-06T14:41:42+00:00',
                     ]),
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_13',
                         'message' => 'aaaa',
                         'type' => 'status',
                         'created_time' => '2020-07-13T14:41:42+00:00',
                     ]),
            new Post([
                         'id' => 'post'.($i++),
                         'from_name' => 'Test test',
                         'from_id' => 'user_13',
                         'message' => 'aaaa',
                         'type' => 'status',
                         'created_time' => '2020-07-13T14:41:42+00:00',
                     ]),
        ];

        $result = Stat::getAveragePostsNumberPerUserPerMonth($posts);

        return (3==count($result))
            && (isset($result['2020-05']) && 1 == $result['2020-05'])
            && (isset($result['2020-06']) && 2 == $result['2020-06'])
            && (isset($result['2020-07']) && 2 == $result['2020-07']);
    }
}