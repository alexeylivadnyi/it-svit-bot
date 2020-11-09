<?php
declare(strict_types=1);

namespace App\Service;


class GoogleDriveDataProvider implements DataProvider
{
    protected DataReader $reader;

    public function __construct(DataReader $reader)
    {
        $this->reader = $reader;
    }

    public function provide(): \Generator
    {
        $handler = fopen($this->reader->getLink(), 'r');
        fgets($handler);

        while(!feof($handler)) {
            $buffer = "";

            do {
                $tmpString = fgets($handler);
                if (!$tmpString) {
                    continue;
                }
                $tmpString = trim($tmpString);
                $buffer .= $tmpString;

            } while(!in_array($tmpString, ['}', '},']));

            if (strlen($buffer) > 1) {
                $buffer = substr($buffer, 0, -1);
                yield json_decode($buffer, true);
            }
        }

        fclose($handler);
    }
}