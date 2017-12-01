<?php

namespace App\Modules\Sync\Transport\Raspvariant;

use App\Models\Sync\Raspvariant;
use App\Models\Transport\Event;
use App\Models\Transport\Graph;
use App\Models\Transport\Smena;
use App\Models\Transport\Stop;
use App\Modules\Sync\Exceptions\SyncLogicException;
use App\Modules\Sync\Interfaces\ConvertRulesInterface;
use App\Modules\Sync\Interfaces\SyncSourceInterface;
use App\Modules\Sync\Transport\Raspvariant\Object\EventConvertObject;
use App\Modules\Sync\Transport\Raspvariant\Object\GraphConvertObject;
use App\Modules\Sync\Transport\Raspvariant\Object\RaspvariantConvertObject;
use App\Modules\Sync\Transport\Raspvariant\Object\SmenaConvertObject;
use App\Modules\Sync\Transport\Raspvariant\Object\StopConvertObject;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\DomCrawler\Crawler;
use DB;

class RaspvariantXML implements SyncSourceInterface
{
    const SOURCE_NAME = 'raspvariant';

    /**
     * @var Crawler
     */
    private $xml_parser;

    /**
     * @var ConvertRulesInterface[]
     */
    protected $converters = [
        RaspvariantConvertObject::class,
        GraphConvertObject::class,
        SmenaConvertObject::class,
        EventConvertObject::class,
        StopConvertObject::class,
    ];

    /**
     * @var ConvertRulesInterface[]
     */
    protected $object_converter = [];

    public function __construct()
    {
        foreach ($this->converters as $converter) {
            $converter = new $converter;
            $this->object_converter[$converter->getClassName()] = $converter;
        }
    }

    public function getConverter(string $class_name) : ConvertRulesInterface
    {
        if (empty($this->object_converter[$class_name])) {
            throw new SyncLogicException("object_convert {$class_name} is not defined");
        }

        return $this->object_converter[$class_name];
    }

    public function setImportFile(string $file): void
    {
        $this->setImportString(
            file_get_contents($file)
        );
    }

    public function setImportString(string $xml): void
    {
        $this->xml_parser = new Crawler($xml);
    }

    public function import(): void
    {
        if (!$this->xml_parser) {
            throw new SyncLogicException('set XML first');
        }

        DB::transaction(function () {
            $this->run();
        });
    }

    protected function run(): void
    {
        $raspvariant_ids = [];
        $graph_ids = [];
        $smena_ids = [];
        $event_ids = [];
        $stop_ids = [];

        foreach ($this->xml_parser as $raspvariantNode) {
            $raspvariant = $this->getObjectFromNode(
                $raspvariantNode,
                $this->getConverter(Raspvariant::class)
            );
            $raspvariant->save();
            $raspvariant_ids[] = $raspvariant->id;
            foreach ($raspvariantNode->childNodes as $graphNode) {
                if (!$graphNode instanceof \DOMElement || $graphNode->nodeName != 'graph') {
                    continue;
                }

                $graph = $this->getObjectFromNode(
                    $graphNode,
                    $this->getConverter(Graph::class),
                    ['raspvariant_id' => $raspvariant->id]
                );

                $graph->save();
                $graph_ids[] = $graph->id;

                $smena = $this->getObjectFromNode(
                    $graphNode,
                    $this->getConverter(Smena::class),
                    ['graph_id' => $graph->id]
                );

                $smena->save();
                $smena_ids[] = $smena->id;

                foreach ($graphNode->childNodes as $eventNode) {
                    if (!$eventNode instanceof \DOMElement || $eventNode->nodeName != 'event') {
                        continue;
                    }
                    $event = $this->getObjectFromNode(
                        $eventNode,
                        $this->getConverter(Event::class),
                        ['smena_id' => $smena->id]
                    );
                    $event->save();
                    $event_ids[] = $event->id;

                    foreach ($eventNode->childNodes as $stopNode) {
                        if (!$stopNode instanceof \DOMElement || $stopNode->nodeName != 'stop') {
                            continue;
                        }
                        $stop = $this->getObjectFromNode(
                            $stopNode,
                            $this->getConverter(Stop::class),
                            ['event_id' => $event->id]
                        );
                        $stop->save();
                        $stop_ids[] = $stop->id;
                    }
                }
            }
        }
        Stop::whereNotIn('id', $stop_ids)->delete();
        Event::whereNotIn('id', $event_ids)->delete();
        Smena::whereNotIn('id', $smena_ids)->delete();
        Graph::whereNotIn('id', $graph_ids)->delete();
        Raspvariant::whereNotIn('id', $raspvariant_ids)->delete();
        Raspvariant::where('id', '>', 0)->delete();
    }

    protected function getObjectFromNode(
        \DOMElement $node,
        ConvertRulesInterface $converter,
        array $mixins = []
    ) : Model
    {
        $prop = [];
        foreach (array_keys($converter->getRules()) as $name) {

            if ($node->hasAttribute($name)) {
                $prop[$name] = $node->getAttribute($name);
            }
        }
        return  $converter->getObject($prop + $mixins);
    }

}
