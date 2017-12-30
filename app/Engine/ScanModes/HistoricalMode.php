<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 28/12/2017
 * Time: 08:07
 */

namespace App\Engine\ScanModes;


class HistoricalMode extends \App\Engine\ApplicationAbstract
{


    public function result()
    {
        if ($this->alreadyScanned()) {

            $applicationsFromHistoricalSearch = $this->searchForHistoricalTechnologies();

            $applications = $applicationsFromHistoricalSearch;

            $this->applications = $applications;

        }

        return $this;
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

            $versionNode = $technology['poweredBy']['buckets']['0']['version']['buckets']['0'];


            $app = (new \App\Engine\App())
                ->setName($name)
                ->setConfidence(100)
                ->setVersion($versionNode['key'])
                ->setIcon($versionNode['icon']['buckets']['0']['key'])
                ->setWebsite($versionNode['icon']['buckets']['0']['website']['buckets']['0']['key'])
                ->setCategories(array_column(
                    $versionNode['icon']['buckets']['0']['website']['buckets']['0']['categories']['buckets'],
                    'key'
                ));

            $applications[] = $app;

            if ($name == 'WordPress') {
                foreach ($this->themes() as $theme) {
                    $app->setTheme($theme);
                }

                foreach ($this->plugins() as $plugin) {
                    $app->setPlugin($plugin);
                }
            }

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
                                "poweredBy" => [
                                    "terms" => [
                                        "size"  => 1,
                                        "field" => "technologies.poweredBy",
                                    ],
                                    "aggs"  => [
                                        "version" => [
                                            "terms" => [
                                                "size"    => 2,
                                                "field"   => "technologies.version",
                                                "missing" => "NA",
                                                "order"   => [
                                                    "_key" => "desc",
                                                ],
                                            ],
                                            "aggs"  => [
                                                "icon" => [
                                                    "terms" => [
                                                        "size"  => 5,
                                                        "field" => "technologies.icon",
                                                    ],
                                                    "aggs"  => [
                                                        "website" => [
                                                            "terms" => [
                                                                "size"  => 1,
                                                                "field" => "technologies.website",
                                                            ],
                                                            "aggs"  => [
                                                                "categories" => [
                                                                    "terms" => [
                                                                        "size"  => 1,
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
                        "path" => "technologies",
                    ],
                    "aggs"   => [
                        "name" => [
                            "terms" => [
                                "field" => "technologies.theme",
                                "size"  => 200,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $result = $this->query($dsl);


        $themes = array_column($result['aggregations']['Wordpress']['name']['buckets'], 'key');

        $themeObject = new \App\Engine\Theme();
        $allThemes   = [];
        if ( ! empty($themes)) {
            foreach ($themes as $theme) {
                $themeObject->setName($theme)
                            ->setSlug($theme)
                            ->setScreenshotHash('')
                            ->setDescription('');
            }
            $allThemes[] = $themeObject;
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
            //@todo: move this to plugin class
            $pluginMeta  = \App\Models\PluginMeta::where('slug', $pluginSlug)
                                                 ->get();
            $description = null;
            if (isset($pluginMeta[0])) {
                $description = $pluginMeta[0]->plugin->description;
            }

            $pluginObject = new \App\Engine\Plugin();
            $plugins[]    = $pluginObject->setName($plugin['key'])
                                         ->setSlug($pluginSlug)
                                         ->setDescription($description);


        }

        return $plugins;
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