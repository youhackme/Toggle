<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 28/12/2017
 * Time: 08:07
 */

namespace App\Engine\ScanModes;


class HistoricalMode extends \App\Engine\ApplicationScanAbstract
{


    public function result()
    {

        $applicationsFromHistoricalSearch = $this->searchForHistoricalTechnologies();

        $applications = $applicationsFromHistoricalSearch;

        $this->applications = $applications;

        return $this;
    }

    /**
     * Find out if a url has have already been scanned
     * @return bool
     */
    public function alreadyScanned()
    {

        $dsl = [
            "size"  => 0,
            "query" => [
                "bool" => [
                    "filter" => [
                        [
                            "terms" => [
                                "url" => [$this->request->getUrl()],
                            ],
                        ],
                    ],
                ],
            ],
        ];


        $response = $this->query($dsl);


        if ($response['hits']['total'] !== 0) {
            return true;
        }

        return false;

    }

    /**
     * Execute an ES query
     *
     * @param $dsl
     *
     * @return mixed
     */
    public function query($dsl)
    {
        $data = [
            'body'  => $dsl,
            'index' => 'toggle',
            'type'  => 'technologies',

        ];

        $response = \Elasticsearch::search($data);

        // $this->calcTimeTaken($response['took']);

        return $response;
    }

    /**
     * Fetch the result from ES (including technologies, wordpress and corresponding plugins)
     * @return array
     */
    public function searchForHistoricalTechnologies()
    {
        $technologies = $this->technologies();

        $applications = [];

        foreach ($technologies['aggregations']['result']['name']['buckets'] as $technology) {

            $name = $technology['key'];

            $versionNode = $technology['version']['buckets']['0'];
            $app         = (new \App\Engine\ApplicationComponents\Application());

            if ($name == 'WordPress') {

                $app = (new \App\Engine\ApplicationComponents\WordPress());

                foreach ($this->themes() as $theme) {
                    $app->setTheme($theme);
                }

                foreach ($this->plugins() as $plugin) {
                    $app->setPlugin($plugin);
                }

            }

            $app->setName($name)
                ->setConfidence(100)
                ->setVersion($versionNode['key'])
                ->setCategories(array_column(
                    $versionNode['categories']['buckets'],
                    'key'
                ))->compute();


            $applications[] = $app;

        }


        return $applications;
    }

    /**
     * Fetch the technologies being used from ES
     * @return mixed
     */
    public function technologies()
    {

        $dsl = [
            "size"  => 0,
            "query" => [
                "bool" => [
                    "filter" => [
                        [
                            "terms" => [
                                "host" => [$this->request->getHost()],
                            ],
                        ],
                    ],
                ],
            ],
            "aggs"  => [
                "result" => [
                    "nested" => [
                        "path" => "technologies",
                    ],
                    "aggs"   => [
                        "name" => [
                            "terms" => [
                                "size"  => 100,
                                "field" => "technologies.name",
                            ],
                            "aggs"  => [

                                "version" => [
                                    "terms" => [
                                        "size"    => 5,
                                        "field"   => "technologies.version",
                                        "missing" => "NA",
                                        "order"   => [
                                            "_key" => "desc",
                                        ],
                                    ],
                                    "aggs"  => [
                                        "categories" => [
                                            "terms" => [
                                                "size"  => 5,
                                                "field" => "technologies.categories",
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];


        return $this->query($dsl);
    }

    /**
     * Fetch the theme being used
     * @return array
     */
    public function themes()
    {
        $dsl = [
            "size"  => 0,
            "query" => [
                "bool" => [
                    "filter" => [
                        [
                            "terms" => [
                                "host" => [$this->request->getHost()],
                            ],
                        ],
                        [
                            "range" => [
                                "createdOn" => [
                                    "gte" => "now-1d",
                                    "lt"  => "now",
                                ],
                            ],
                        ],
                        [
                            "nested" => [
                                "path"  => "technologies",
                                "query" => [
                                    "bool" => [
                                        "filter" => [
                                            [
                                                "term" => [
                                                    "technologies.name" => "WordPress",
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            "aggs"  => [
                "Wordpress" => [
                    "nested" => [
                        "path" => "technologies.themes",
                    ],
                    "aggs"   => [
                        "name" => [
                            "terms" => [
                                "size"  => "100",
                                "field" => "technologies.themes.name",
                            ],
                            "aggs"  => [
                                "slug" => [
                                    "terms" => [
                                        "field" => "technologies.themes.slug",
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];


        $result = $this->query($dsl);

        $allThemes = [];
        if ( ! empty($result['aggregations']['Wordpress']['name']['buckets'])) {


            foreach ($result['aggregations']['Wordpress']['name']['buckets'] as $theme) {
                $themeName = $theme['key'];
                $themeSlug = $theme['slug']['buckets'][0]['key'];

                $themeObject = (new \App\Engine\ApplicationComponents\Theme())
                    ->setName($themeName)
                    ->setSlug($themeSlug)
                    ->compute();


                $allThemes[] = $themeObject;
            }

        }

        return $allThemes;


    }

    /**
     * Fetch the plugin being used
     * @return array
     */
    public function plugins()
    {
        $dsl = [
            "size"  => 0,
            "query" => [
                "bool" => [
                    "must" => [
                        [
                            "terms" => [
                                "host" => [$this->request->getHost()],
                            ],
                        ],
                        [
                            "range" => [
                                "createdOn" => [
                                    "gte" => "now-1d",
                                    "lt"  => "now",
                                ],
                            ],
                        ],
                        [
                            "nested" => [
                                "path"  => "technologies",
                                "query" => [
                                    "bool" => [
                                        "filter" => [
                                            [
                                                "term" => [
                                                    "technologies.name" => "WordPress",
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            "aggs"  => [
                "result" => [
                    "nested" => [
                        "path" => "technologies.plugins",
                    ],
                    "aggs"   => [
                        "name" => [
                            "terms" => [
                                "size"  => "100",
                                "field" => "technologies.plugins.name",
                            ],
                            "aggs"  => [
                                "slug" => [
                                    "terms" => [
                                        "field" => "technologies.plugins.slug",
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $result = $this->query($dsl);


        $plugins = [];

        foreach ($result['aggregations']['result']['name']['buckets'] as $plugin) {

            $pluginSlug = $plugin['slug']['buckets'][0]['key'];


            $pluginObject = new \App\Engine\ApplicationComponents\Plugin();
            $plugins[]    = $pluginObject->setName($plugin['key'])
                                         ->setSlug($pluginSlug)
                                         ->compute();


        }

        return $plugins;
    }

    /**
     * Calculate the time taken to query a DSL
     *
     * @param $timeTook
     */
    public function calcTimeTaken($timeTook)
    {
        $this->timeTook[] = $timeTook;
    }

    /**
     * Fetch stats related to a query
     * @return array
     */
    private function stats()
    {
        return [
            'took'    => array_sum($this->timeTook),
            'queries' => count($this->timeTook),
        ];
    }


}