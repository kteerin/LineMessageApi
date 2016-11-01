<?php
/*
Author: Takayuki Miyauchi
URL: http://firegoby.theta.ne.jp/archives/2246
*/

class instagram {

private $json = "http://instagram.heroku.com/users/%s.json";
private $atom = "http://instagram.heroku.com/users/%s.atom";

function __construct()
{
    // nothing to do
}

public function getAtomURI($uid)
{
    $url = sprintf($this->atom, $uid);
    return $url;
}

public function getJsonURI($uid)
{
    $url = sprintf($this->json, $uid);
    return $url;
}

public function getUID($url)
{
    $dom = new DOMDocument();
    $dom->loadHTMLFile($url);
    if (!$dom) {
        return false;
    }

    $pimg = false;
    foreach ($dom->getElementsByTagName('img') as $img) {
        $class = $img->getAttribute('class');
        if (preg_match("/profile\-picture/", $class)) {
            $pimg = basename($img->getAttribute('src'));
            break;
        }
    }

    if (preg_match("/^profile_([0-9]+)_.*$/", $pimg, $m)) {
        return $m[1];
    } else {
        return false;
    }
}

}
