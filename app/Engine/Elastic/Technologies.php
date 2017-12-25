<?php
/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 09/12/2017
 * Time: 21:19
 */

namespace App\Engine\Elastic;

use App\Http\Requests\ScanTechnologiesRequest;
use Request;

class Technologies
{


    /**
     * The request
     * @var array
     */
    public $request;


    /**
     * Technologies constructor.
     *
     * @param ScanTechnologiesRequest $request
     */
    public function __construct(ScanTechnologiesRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Fetch the result from ES (including technologies, wordpress and corresponding plugins)
     * @return array
     */
    public function result()
    {
        $technologies = $this->technologies();

        $applications = [];
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
                $themes = $this->themes();

                if ( ! is_null($themes)) {
                    $appStack['theme'] = $themes;
                }

                $plugins = $this->plugins();
                if ( ! is_null($plugins)) {
                    $appStack['plugins'] = $plugins;
                }
            }

            $applications['applications'][$name] = (Object)$appStack;

        }

        $applications['stats'] = $this->stats();


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

        $result = $this->search($dsl);
        $themes = array_column($result['aggregations']['Wordpress']['name']['buckets'], 'key');

        if ( ! empty($themes)) {
            if ($themes[0] === "0" || $themes[0] === 0) {
                return null;
            }
        } else {
            return null;
        }


        return (Object)array_flip($themes);


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

        $result = $this->search($dsl);


        $plugins = [];
        foreach ($result['aggregations']['result']['name']['buckets'] as $plugin) {

            $pluginSlug  = $plugin['slug']['buckets'][0]['key'];
            $pluginMeta  = \App\Models\PluginMeta::where('slug', $pluginSlug)
                                                 ->get();
            $description = null;
            if (isset($pluginMeta[0])) {
                $description = $pluginMeta[0]->plugin->description;
            }

            $plugins[] = (Object)[
                'name'        => $plugin['key'],
                'slug'        => $pluginSlug,
                'description' => $description,
            ];

        }

        if (empty($plugins)) {
            return null;
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