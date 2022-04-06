<?php

class TaskManager
{
    public static function getTasks($articles = [])
    {
        $tasks = AppConfig::getConfig('tasks');

        if (!empty($articles)) {
            foreach($tasks as $index => $task) {
                foreach($task['routes'] as $routeIndex => $route) {
                    if(isset($route['option'])) {
                        $tasks[$index]['routes'][$routeIndex]['option'] = (isset($articles[$route['option']])) 
                            ? $articles[$route['option']]
                            : [];
                    }
                }
            }
        }

        return $tasks;
    }
}
