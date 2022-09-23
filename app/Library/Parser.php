<?php
namespace App\Library;

use Carbon\Carbon;
use DiDom\Document;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;


class Parser
{
    static $userAgent = null;
    static $userRefer = null;
    static $jar = null;

    public $link;
    public $name;
    public $categories;
    public $category;
    public $artNamber;
    public $image;
    public $more;
    public $price;
    public $description;
    public $options;
    public $documentation;
    public $video;

    public $allowed;


    public  function  __construct()
    {
        $this->link = null;
        $this->name = null;
        $this->categories = null;
        $this->category = null;
        $this->artNamber = null;
        $this->image = null;
        $this->more = [];
        $this->price = null;
        $this->description = null;
        $this->options = [];
        $this->documentation = [];
        $this->video = [];
        $this->allowed = false;
    }

    public static function agent()
    {
        if(!self::$userAgent){
            $dt = Carbon::now();
            if ($dt->isMonday()) {
                self::$userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.5112.102 Safari/537.36 OPR/90.0.4480.54';
            } elseif ($dt->isTuesday()) {
                self::$userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.5112.102 Safari/537.36 OPR/90.0.4480.84';
            } elseif ($dt->isWednesday()) {
                self::$userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36';
            } elseif ($dt->isThursday()) {
                self::$userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:104.0) Gecko/20100101 Firefox/104.0';
            } elseif ($dt->isFriday()) {
                self::$userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.167 YaBrowser/22.7.5.940 Yowser/2.5 Safari/537.36';
            } elseif ($dt->isSaturday()) {
                self::$userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.5112.115 Safari/537.36';
            } elseif ($dt->isSunday()) {
                self::$userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.148 Atom/23.0.0.36 Safari/537.36';
            } else {
                self::$userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.148 Atom/23.0.0.36 Safari/537.36';
            }
        }
        return self::$userAgent;
    }

    public static function refer()
    {
        if(!self::$userRefer) {
            $dt = Carbon::now();
            if ($dt->isMonday()) {
                self::$userRefer = 'https://www.google.ru/';
            } elseif ($dt->isTuesday()) {
                self::$userRefer = 'https://yandex.ru/';
            } elseif ($dt->isWednesday()) {
                self::$userRefer = 'https://mail.ru/';
            } elseif ($dt->isThursday()) {
                self::$userRefer = 'https://www.rambler.ru/';
            } elseif ($dt->isFriday()) {
                self::$userRefer = 'https://www.belarusinfo.by/';
            } elseif ($dt->isSaturday()) {
                self::$userRefer = 'https://vk.com/feed';
            } elseif ($dt->isSunday()) {
                self::$userRefer = 'https://www.securitylab.ru/';
            }
        }
        return self::$userRefer;
    }

    public static function getFile($src, $productNumber = null, $folder='main', $key = 0)
    {
        $client = new Client(['verify' => false]);
        $tmpfile = tempnam(sys_get_temp_dir(),'dl');
        $response = $client->request('GET', $src, [
            'headers' => [
                'User-Agent' => self::$userAgent,
                //'Referer' => self::$userRefer
            ],
            'sink' => $tmpfile
        ]);
        if (!$response->getStatusCode() == 200) return null;
        $ext = pathinfo($src, PATHINFO_EXTENSION);
        $fileName = $productNumber ? $folder.'_'.$key.'_'.$productNumber.'.'.$ext : $folder.'_'.$key.'_'.Str::lower(Str::random(9)).'.'.$ext;
        $filePath = Storage::putFileAs('upload/'.$folder, new File($tmpfile), $fileName);
        return $filePath;
    }

    public static function getContent($url)
    {
        $client = new \GuzzleHttp\Client();
        self::$jar ?  self::$jar : self::$jar = new \GuzzleHttp\Cookie\CookieJar;
        $res = $client->request('GET', $url, [
            'cookies' => self::$jar,
            'referer' => true,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer' => self::$userRefer
            ]
        ]);
        if (!$res->getStatusCode() == 200) return null;
        $body = $res->getBody();
        return $body->getContents();

    }


    public function getProduct($src)
    {
        $html = self::getContent($src);
        if(!$html) return $this;
        $this->link = $src;
        $this->allowed = true;
        $document = new Document($html);

        $this->name =  $document->first('.ty-product-block-title bdi')->text();
        $this->categories = trim($document->first('.ty-breadcrumbs')->text());
        $this->category = $document->first('.ty-breadcrumbs a:last-child')->text();
        $this->artNamber = $document->first('.ty-control-group__item')->text();
        $price =$document->first('.ty-price bdi span:first-child')->text();
        $this->price = str_replace("\xC2\xA0", "", $price);
        if($descrip = $document->first('#content_description div')){
            $this->description  = $descrip->innerHtml();
        }
        $ArrOptions = $document->find('#content_features .ty-product-feature');
        if(count($ArrOptions)>0){
            $key = 1;
            foreach ($ArrOptions as $itemOption){
                $property = $itemOption->first('.ty-product-feature__label')->text();
                $value = $itemOption->first('.ty-product-feature__value')->text();
                $this->options[$key] = ['name'=>$property, 'value'=>$value];
                $key++;
            }
        }
        $mainImgLink = $document->first('.ty-product-img a')->getAttribute('href');
        if($mainImgLink){
            $this->image = self::getFile($mainImgLink, $this->artNamber,'main', 0);
        }

        if(count($document->find('.ty-product-img a.cm-image-previewer')) > 1){
            $arrMore = $document->find('.ty-product-img a.cm-image-previewer');
            foreach($arrMore as $key=> $moreItem){
                if($key == 0) continue;
                $moreItemLink  = $moreItem->getAttribute('href');
                $itemPath = self::getFile($moreItemLink, $this->artNamber,'more', $key);
                array_push($this->more,  $itemPath);
            }
        }
        $docs = $document->find('.attachments p.attachment__item');
        if(count($docs)>0){
            foreach ($docs as $doc){
                array_push($this->documentation, [
                    'name'=>str_replace( '[Скачать]', '', trim($doc->text())),
                    'link'=>$doc->first('a.attachment__a')->getAttribute('href')
                ]);
            }
        }

        $arrVideo = $document->find('#content_videos .cp-video-grid__item-name a');
        if(count($arrVideo)>0){
            foreach ($arrVideo as $itemVideo){
                $linkToVideo = $itemVideo->getAttribute('href');
                if($linkToVideo){
                    $another = self::getContent($linkToVideo);
                    if(!$another) continue;
                    $videoContent = new Document($another);
                    if($itemURL = $videoContent->first('.cp-video-detailed__video-wrapper iframe')->getAttribute('data-yt-id')){
                        array_push($this->video, [
                            'name'=>$videoContent->first('h1.ty-mainbox-title')->text(),
                            'item'=>$itemURL
                        ]);
                    }
                }
            }
        }
        return $this;
    }

    public static function getPagination($url)
    {
        $html = self::getContent($url);
        if(!$html) return false;
        $document = new Document($html);
        $pagination = [];
        if($domPagination = $document->first('.ty-pagination__items')){
            $selected = $domPagination->first('.ty-pagination__selected')->text();
            $arrPagination = $domPagination->find('a.ty-pagination__item');

            $pagination[$selected] = $url;

            foreach ($arrPagination as $itemPagination){
                $pagination[$itemPagination->text()] = $itemPagination->getAttribute('href');
            }
        }
        return $pagination;
    }

    public static function getlinksOnePage($url)
    {
        $html = self::getContent($url);
        if(!$html) return false;
        $document = new Document($html);
        $pageListLinks = [];
        if(count($arrLinks = $document->find('a.product-title'))>0){
            foreach ($arrLinks as $itemLink){
                array_push($pageListLinks,  $itemLink->getAttribute('href'));
            }
        }
        return $pageListLinks;
    }

    public static function getCategoryLinks($url)
    {
        $arrPages = self::getPagination($url);
        $categoryLinks = [];
        if(count($arrPages)>0){
            foreach ($arrPages as $itemPage){
                $links = self::getlinksOnePage($itemPage);
                array_push($categoryLinks,  $links);
            }
            $categoryLinks = call_user_func_array('array_merge', $categoryLinks);
        } else {
            $categoryLinks = self::getlinksOnePage($url);
        }
        return $categoryLinks;
    }


}
