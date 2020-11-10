<?php


namespace App\Service\DataReader;


class GoogleDriveDataReader implements DataReader
{
    protected string $url = 'https://drive.google.com/file/d/1LXi1N1ixaxwCefcRTQ7QB1zQEQYlMTor/view?usp=sharing';


    /**
     * @return string
     */
    public function source(): string
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
