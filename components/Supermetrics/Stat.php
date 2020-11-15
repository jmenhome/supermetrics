<?php

namespace Supermetrics;

use Base\Component;

/**
 * Class Stat
 *
 * Provides statistic methods for post array
 */
class Stat extends Component
{
    /**
     * @param Post[] $posts
     * @return array
     */
    public static function getAveragePostLengthPerMonth($posts) {

        $months = [];
        foreach ($posts as $post) {

            //get year & month
            $month = date('Y-m', strtotime($post->created_time));

            if (!isset($months[$month])) {
                $months[$month] = [
                    'count' => 0,
                    'length' => 0,
                    'avg' => 0,
                ];
            }

            $length = mb_strlen($post->message, 'utf-8');;

            $months[$month]['count']++;
            $months[$month]['length'] += $length;
        }

        $average = [];
        foreach ($months as $k=>$stats) {
            $average[$k] = $stats['length'] / $stats['count'];
        }

        return $average;
    }

    /**
     * @param Post[] $posts
     * @return array
     */
    public static function getLongestPostPerMonth($posts)
    {
        $months = [];
        foreach ($posts as $post) {

            //get year & month
            $month = date('Y-m', strtotime($post->created_time));

            $length = mb_strlen($post->message, 'utf-8');;

            if (!isset($months[$month]) || $months[$month]['length']<$length) {
                $months[$month] = [
                    'message' => $post->message,
                    'length' => $length,
                ];
            }
        }

        return $months;
    }

    /**
     * @param Post[] $posts
     * @return array
     */
    public static function getPostsCountPerWeek($posts)
    {
        $weeks = [];
        foreach ($posts as $post) {

            //get week number
            $number = date('W', strtotime($post->created_time));

            if (!isset($weeks[$number])) {
                $weeks[$number] = 0;
            }

            $weeks[$number]++;
        }

        return $weeks;
    }

    /**
     * @param Post[] $posts
     * @return array
     */
    public static function getAveragePostsNumberPerUserPerMonth($posts)
    {
        $months = [];

        foreach ($posts as $post) {

            //get year & month
            $month = date('Y-m', strtotime($post->created_time));

            if (!isset($months[$month])) {
                $months[$month] = [];
            }

            if (!isset($months[$month][$post->from_id])) {
                $months[$month][$post->from_id] = 0;
            }

            $months[$month][$post->from_id]++;
        }

        $average = [];
        foreach ($months as $k=>$month) {
            $average[$k] = array_sum($month) / count($month);
        }

        return $average;
    }
}