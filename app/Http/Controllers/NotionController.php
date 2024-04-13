<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Notion;
use Illuminate\Support\Str;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Redirect;

class NotionController extends Controller
{

    const PAGE_ID = 'fb6c5589970e40e59c6cca5625cacdc6';

    public function sync()
    {

        $pageCollection = Notion::database(self::PAGE_ID)->query()->asCollection();

        // use this if you want to access further than the first 100 records. Use a loop
        // $query = Notion::database(self::PAGE_ID)->query();
        // $pageCollection = Notion::database(self::PAGE_ID)->offsetByResponse($query)->query()->asCollection();

        if (count($pageCollection)) {
            foreach ($pageCollection as $page) {


                if(!Post::where('notion_id',$page->getId())->first()){

                    $data = $this->getData($page);


                    $post = 
                        Post::create([
                            'title'            => $data['title'],
                            'author'           => $data['author'],
                            'slug'             => $data['slug'],
                            'content'          => $data['content'],
                            'image'            => $data['cover'],
                            'meta_title'       => $data['title'].' - '.$data['author'],
                            'meta_description' => $data['summary'],
                            'meta_keywords'    => '',
                            'enabled'          => 1,
                            'feautured'        => 0,
                            'notion_id'        => $page->getId(),
                            'published_at'     => $data['created_time']
                        ]);

                    
                    $tags = explode(',',$data['tags']);
                    foreach($tags as $tag){
                        if($tag!=''){
                            if(!Category::where('title',$tag)->first()){
                                
                                $category = Category::create([
                                    'title'            => $tag,
                                    'slug'             => $tag,
                                    'description'      => $tag,
                                    'content'          => $tag,
                                    'meta_title'       => $tag,
                                    'meta_description' => $tag,
                                    'meta_keywords'    => $tag,
                                ]);

                                
                            }else{
                                $category = Category::where('title',$tag)->first();
                            }

                            if( $post ){

                                $post->categories()->save($category);

                            }
                        }
                    }
                }

            }
        }

        return redirect()->back()->with('message','Records synced successfully!');
    }

    public function getData($page)
    {
        $data = $this->getProperties($page, []);
        
        if($page->getCover()){
            $cover = file_get_contents($page->getCover());
            $title = Str::slug($page->getTitle()).'.png';
            $x = Storage::put('/public/posts/covers/'. $title,$cover);
            $data['cover'] = 'posts/covers/'. $title;
        }else{
            $data['cover'] = '';
        }
        
        $data['content'] = $this->getBody($page);
        
        return $data;
    }

    public function getBody($page)
    {

        $blocks = Notion::block($page->toArray()['id'])
            ->children()
            ->withUnsupported()
            ->asCollection();

        $html = '';

        foreach ($blocks as $block) {

            if ($block->getType() == 'quote') {
                $html .= $this->getQuote($block);
            } else if ($block->getType() == 'paragraph') {
                $html .= "<p>" . $block->getContent()->getPlainText() . "</p>";
            } else if ($block->getType() == 'image') {
                $html .= "<img src='" . $block->getContent() . "'>";
                $html .= "<br>";
            }

        }

        return $html;
    }

    public function getProperties($page, $data)
    {

        $properties = $page->getProperties()->toArray();
        // dd($properties);
        foreach ($properties as $property) {
            if ($property->getTitle() == 'summary') {
                $data['summary'] = $property->getContent()->getPlainText();
            } else if ($property->getTitle() == 'slug') {
                $data['slug'] = $property->getContent()->getPlainText();
            } else if ($property->getTitle() == 'date') {
                $data['created_time'] = $property->getRawContent()['start'];
            } else if ($property->getTitle() == 'Author') {
                $data['author'] = $property->getContent()->getPlainText();
            } else if ($property->getTitle() == 'title') {
                $data['title'] = $property->getContent()->getPlainText();
            } else if ($property->getTitle() == 'tags') {
                $tags = $property->getContent()->toArray();
                $data['tags'] = '';
                if (count($tags) > 0) {
                    foreach ($tags as $tag) {
                        $data['tags'] .= ',' . $tag->getName();
                    }
                    ltrim($data['tags'], ',');
                }
            }
        }
        return $data;
    }

    public function getQuote($block)
    {
        $html = '';

        $html .= "<blockquote>";
        $html .= $block->getContent()->getPlainText();

        $childs = Notion::block($block->toArray()['id'])
            ->children()
            ->withUnsupported()
            ->asTextCollection();

        if (count($childs) > 0) {
            foreach ($childs as $child) {
                $html .= "<br>" . $child;
            }
        }

        $html .= "</blockquote>";
        return $html;
    }
}
