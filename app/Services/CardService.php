<?php 

namespace App\Services;

use App\Features\Cards\Cardable;
use App\Repositories\BaseRepository;

class CardService extends BaseService
{
    /**
     * The path where our card feature details are.
     *
     * @var string
     */
    private $featureDir;

    /**
     * The namespace of the feature. We need this to get
     * the classes declared there.
     *
     * @var string
     */
    private $namespace;

    /**
     * The name of the main interface, responsible
     * for all cards in the project
     *
     * @var string
     */
    private $interfaceName;

    /**
     * Construct
     *
     * @param BaseRepository $baseRepo
     */
    public function __construct(BaseRepository $baseRepo)
    {
        parent::__construct($baseRepo);
        $this->featureDir = app_path() . '/Features/Cards';
        $this->namespace = 'App\\Features\\Cards';
        $this->interfaceName = Cardable::class;
    }

    /**
     * Get all the card types defined
     *
     * @return array
     */
    public function getTypes(): array
    {
        // get all the php files in the directory
        $files = glob($this->featureDir . '/*.php');

        $types = [];
        foreach ($files as $file) {

            // if it's not a php class, exclude it
            $shortName = basename($file, '.php');
            $class = $this->namespace . '\\' . $shortName;
            if (!class_exists($class)) {
                continue;
            }

            // if it does not implement the interface, exclude it
            $reflect = new \ReflectionClass($class);
            if (!$reflect->implementsInterface($this->interfaceName)) {
                continue;
            }

            $types[$shortName] = $class;
        }

        return $types;
    }
}