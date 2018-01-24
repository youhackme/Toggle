<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 24/12/2017
 * Time: 22:44
 */

namespace App\Engine\ApplicationComponents;

/**
 * Create an individual application instance
 * Class Application
 * @package App\Engine\ApplicationComponents
 */
class Application
{

    /**
     * The name of your application
     * @var
     */
    public $name;
    /**
     * How confident are you on a scale of 1-100 that this is app is really what it is?
     * @var
     */
    public $confidence;
    /**
     * The version of the application
     * @var
     */
    public $version;
    /**
     * The icon of your application
     * @var
     */
    public $icon;
    /**The website of your application
     * @var
     */
    public $website;
    /**
     * Which categories your application belongs to?
     * @var
     */
    public $categories;
    /**
     * How much power your app has? Is it authoritative enough?
     * @var bool
     */
    public $poweredBy = false;


    /**
     * @param mixed $confidence
     *
     * @return App
     */
    public function setConfidence($confidence)
    {
        $this->confidence = $confidence;

        return $this;
    }

    /**
     * @param mixed $version
     *
     * @return App
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @param mixed $categories
     *
     * @return App
     */
    public function setCategories(Array $categories)
    {

        $primaryCategories = ['CMS', 'Blogs', 'Ecommerce', 'Message Boards', 'Web Frameworks'];
        foreach ($categories as $category) {
            if (in_array($category, $primaryCategories)) {
                $this->poweredBy = true;
            }
        }
        $this->categories = $categories;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     *
     * @return App
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     *
     * @return App
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Make sure the object is not missing any uninitialized vital attributes
     * @return $this
     */
    public function compute()
    {
        $methods = get_class_methods($this);

        $methods = collect($methods)->filter(function ($methodName) {
            if (strpos($methodName, 'get') !== false) {
                return $methodName;
            }
        });


        $json = false;
        foreach ($methods as $method) {
            if (is_null($this->$method())) {

                if ($json === false) {
                    $json = json_decode(file_get_contents(app_path() . '/../node_modules/togglyzer/apps.json'));
                }

                switch ($method) {
                    case 'getIcon':
                        if (isset($json->apps->{$this->getName()}->icon)) {
                            $this->setIcon(env('APP_URL') . '/storage/icons/' . $json->apps->{$this->getName()}->icon);
                        }

                        break;
                    case 'getWebsite':
                        if (isset($json->apps->{$this->getName()}->website)) {
                            $this->setWebsite($json->apps->{$this->getName()}->website);
                        }
                        break;

                }
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return App
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


}