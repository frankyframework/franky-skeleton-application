<?php
//URL: https://schema.org/BlogPosting

namespace Blog\schema;

class blogPostingSchema extends \Franky\Schema\schema
{  
    function __construct() {
       
        parent::__construct("BlogPosting");
    }
    
    public function setHeadline($val)
    {
        
       $this->json["headline"] = $val;   
        
    }
    
    public function setAlternativeHeadline($val)
    {
        
       $this->json["alternativeHeadline"] = $val;   
        
    }
    
    public function setDatePublished($val)
    {
        $this->json["datePublished"] = $val;   
    }
  
    public function setDateModified($val)
    {
        $this->json["dateModified"] = $val;   
    }
    public function setUrl($val)
    {
        $this->json["url"] = $val;   
    }
    
    public function setImage($val)
    {
        $this->json["image"] = $val;   
    }
    
    public function setArticleBody($val)
    {
        $this->json["articleBody"] = $val;   
    }
    
    public function setArticleSection($val)
    {
        $this->json["articleSection"] = $val;   
    }
  
    public function setKeywords($val)
    {
        $this->json["keywords"] = $val;   
    }
    
    public function setAggregateRating($val)
    {
        $this->json["aggregateRating"] = $val;   
    }
    
    public function setAuthor($val)
    {
        $this->json["author"] = $val;   
    }
    
}
?>