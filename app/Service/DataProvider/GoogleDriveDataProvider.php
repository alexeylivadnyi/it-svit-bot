<?php
declare(strict_types=1);

namespace App\Service\DataProvider;


use App\Service\DataReader\DataReader;

class GoogleDriveDataProvider implements DataProvider
{
    protected DataReader $reader;

    public function __construct(DataReader $reader)
    {
        $this->reader = $reader;
    }

    public function provide(): \Generator
    {
        $handler = fopen($this->reader->source(), 'r');
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
            } while(!in_array($tmpString, ['}', '},', ']']));

            if (mb_strlen($buffer) > 1) {
                if (mb_substr($buffer, -1) === ',') {
                    $buffer = mb_substr($buffer, 0, -1);
                }

                yield json_decode($buffer, true);
            }

            if ($buffer === ']') {
                break;
            }
        }

        fclose($handler);
    }
}
