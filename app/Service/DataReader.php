<?php


namespace App\Service;


class DataReader
{
    protected string $url = 'https://drive.google.com/file/d/1LXi1N1ixaxwCefcRTQ7QB1zQEQYlMTor/view?usp=sharing';

    public function read()
    {

    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        $id = explode(
            '/',
            substr(
                $this->url,
                strlen('https://drive.google.com/file/d/')
            )
        )[0];

        return "https://drive.google.com/uc?export=download&id={$id}";
    }
}