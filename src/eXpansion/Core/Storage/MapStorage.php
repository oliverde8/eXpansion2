<?php

namespace eXpansion\Core\Storage;

use Maniaplanet\DedicatedServer\Structures\Map;
use oliverde8\AssociativeArraySimplified\AssociativeArray;

/**
 * Class MapStorage stores data on the maps to be played & that is being currently played.
 *
 * @package eXpansion\Core\Storage
 * @author Oliver de Cramer
 */
class MapStorage
{
    /** @var Map[] List of all current maps on the server. */
    protected $maps = [];

    /** @var Map Current map being played. */
    protected $currentMap;

    /** @var Map Next map to be played. */
    protected $nexMap;

    /**
     * Add a map to the current map list.
     *
     * @param Map $map
     *
     */
    public function addMap(Map $map)
    {
        $this->maps[$map->uId] = $map;
    }

    /**
     * Get current map list.
     *
     * @return array
     */
    public function getMaps()
    {
        return $this->maps;
    }

    /**
     * Get a map.
     *
     * @param string $uid The unique id of the map to get.
     *
     * @return mixed
     */
    public function getMap($uid)
    {
        return AssociativeArray::getFromKey($this->maps, $uid, null);
    }

    /**
     * Reset map data.
     */
    public function resetMapData()
    {
        $this->maps = [];
    }

    /**
     * Get current map being played.
     *
     * @return Map
     */
    public function getCurrentMap()
    {
        return $this->currentMap;
    }

    /**
     * Set the current map when it's changed.
     *
     * @param Map $currentMap
     */
    public function setCurrentMap($currentMap)
    {
        $this->currentMap = $currentMap;
    }

    /**
     * Get next map to be played.
     *
     * @return Map
     */
    public function getNexMap()
    {
        return $this->nexMap;
    }

    /**
     * Set the next map that is going to be played.
     *
     * @param Map $nexMap
     */
    public function setNexMap($nexMap)
    {
        $this->nexMap = $nexMap;
    }
}