<?php

namespace Reactor\Files\Determine;


use Illuminate\Contracts\Config\Repository;
use Reactor\Files\Contract\Determine\ModelDeterminer as ModelDeterminerContract;

class ModelDeterminer implements ModelDeterminerContract {

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var string
     */
    protected $defaultMediaModel;

    /**
     * @var array
     */
    protected $mediaTypes;

    /**
     * @var array
     */
    protected $modelTypes;

    /**
     * Constructor
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;

        $this->mediaTypes = $this->config->get('files.media_types',
            [
                'audio'    => [
                    'audio/aac', 'audio/mp4', 'audio/mpeg', 'audio/ogg', 'audio/wav', 'audio/webm'
                ],
                'document' => [
                    'text/plain', 'application/pdf', 'application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ],
                'image'    => [
                    'image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'
                ],
                'video'    => [
                    'video/mp4', 'video/ogg', 'video/webm'
                ]
            ]);

        $this->modelTypes = $this->config->get('files.model_types',
            [
                'audio'    => 'Reactor\Files\Media\Audio',
                'document' => 'Reactor\Files\Media\Document',
                'image'    => 'Reactor\Files\Media\Image',
                'video'    => 'Reactor\Files\Media\Video'
            ]);

        $this->defaultMediaModel = $this->config->get('files.media_model', 'Reactor\Files\Media\Media');
    }

    /**
     * Returns the media type for given mimetype
     *
     * @param string $mimetype
     * @return string
     */
    public function getMediaType($mimetype)
    {
        foreach ($this->mediaTypes as $type => $mimeTypes)
        {
            if (in_array($mimetype, $mimeTypes))
            {
                return $type;
            }
        }

        return null;
    }

    /**
     * Returns the model class name for given type
     *
     * @param string $type
     * @return string
     */
    public function getMediaModelName($type)
    {
        return isset($this->modelTypes[$type]) ?
            $this->modelTypes[$type] :
            $this->getDefaultMediaModelName();
    }

    /**
     * Returns the default media model class path
     *
     * @return string
     */
    public function getDefaultMediaModelName()
    {
        return $this->defaultMediaModel;
    }

}