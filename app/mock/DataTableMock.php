<?php

/**
 * Class DataTableMock
 */
class DataTableMock
{
    /**
     * @param $config
     * @param $maxCol
     * @param $setHeader
     * @return array|array[]
     */
    public static function getData ($config, $maxCol, $setHeader)
    {
        $result = ["content" => []];
        $dateCount = 1;

        for ($n = $config->start; $n <= $config->end; $n++) {
            $row = [];
            $setCol = false;

            if ($n === $config->start && $setHeader) {
                $result["header"] = [];
                $setCol = true;
            }

            for ($i = 1 ; $i <= $maxCol; $i++) {
                if ($setCol) {
                    $result["header"][] = ($i > 1) ? "Column $i" : "Date";
                }
                if ($i > 1) {
                    $row[] = "row $n / val $i";
                } else {
                    $dateStr = strtotime(date("d.m.Y")) - ((60*60) * (3600 * $dateCount));
                    if ($dateCount < 10) {
                        $dateCount++;
                    } else {
                        $dateCount = 1;
                    }
                    $row[] = date("d.m.Y",$dateStr);
                }
            }
            $result["content"][] = $row;
        }

        return $result;
    }
}
