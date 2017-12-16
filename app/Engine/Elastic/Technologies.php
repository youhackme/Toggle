<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 09/12/2017
 * Time: 21:19
 */

namespace App\Engine\Elastic;

use Request;

class Technologies
{

    /**
     * The host name
     * @var array
     */
    public $host;

    /**
     * The original url
     * @var array
     */
    public $url;

    /**
     * response from togglyzer result
     * @var
     */
    public $response;


    /**
     * Instance of  Illuminate\Http\Request
     * @var
     */
    public $request;


    /**
     * Technologies constructor.
     */
    public function __construct()
    {

        $this->url = Request::input('url');

        $uri = \App::make('Uri');

        $this->host = $uri->parseUrl(
            $this->url
        )->host->host;


    }

    /**
     * Fetch the result from ES (including technologies, wordpress and corresponding plugins)
     * @return array
     */
    public function result()
    {
        $technologies = $this->technologies();

        $applications                         = [];
        $applications['technologies']['url']  = $this->url;
        $applications['technologies']['host'] = $this->host;
        foreach ($technologies['aggregations']['result']['name']['buckets'] as $technology) {

            $name = $technology['key'];

            $versionNode = $technology['poweredBy']['buckets']['0']['version']['buckets']['0'];
            $appStack    = [
                'name'       => $name,
                'version'    => $versionNode['key'],
                'icon'       => $versionNode['icon']['buckets']['0']['key'],
                'website'    => $versionNode['icon']['buckets']['0']['website']['buckets']['0']['key'],
                'poweredBy'  => filter_var($technology['poweredBy']['buckets']['0']['key'], FILTER_VALIDATE_BOOLEAN),
                'categories' => array_column(
                    $versionNode['icon']['buckets']['0']['website']['buckets']['0']['categories']['buckets'],
                    'key'
                ),
            ];

            if ($name == 'WordPress') {
                $appStack['theme']   = $this->themes();
                $appStack['plugins'] = $this->plugins();
            }

            $applications['technologies']['applications'][$name] = $appStack;

        }

        $applications['stats'] = $this->stats();


        return json_decode(json_encode($applications), false);
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
                                "host" => [$this->host],
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


        return $this->search($dsl);
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
                                "host" => [$this->host],
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

        $result = $this->search($dsl);

        return array_column($result['aggregations']['Wordpress']['name']['buckets'], 'key');

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
                                "host" => [$this->host],
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

        $result = $this->search($dsl);

        $plugins = [];
        foreach ($result['aggregations']['result']['name']['buckets'] as $plugin) {

            $plugins[] = [
                'name' => $plugin['key'],
                'slug' => $plugin['slug']['buckets'][0]['key'],
            ];

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
                                "url" => [$this->url],
                            ],
                        ],
                    ],
                ],
            ],
        ];


        $response = $this->search($dsl);


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
    public function search($dsl)
    {
        $data = [
            'body'  => $dsl,
            'index' => 'toggle',
            'type'  => 'technologies',

        ];

        $response = \Elasticsearch::search($data);
        $this->calcTimeTaken($response['took']);

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