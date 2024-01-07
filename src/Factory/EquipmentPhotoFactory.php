<?php

namespace App\Factory;

use App\Entity\EquipmentPhoto;
use App\Repository\EquipmentPhotoRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<EquipmentPhoto>
 *
 * @method        EquipmentPhoto|Proxy create(array|callable $attributes = [])
 * @method static EquipmentPhoto|Proxy createOne(array $attributes = [])
 * @method static EquipmentPhoto|Proxy find(object|array|mixed $criteria)
 * @method static EquipmentPhoto|Proxy findOrCreate(array $attributes)
 * @method static EquipmentPhoto|Proxy first(string $sortedField = 'id')
 * @method static EquipmentPhoto|Proxy last(string $sortedField = 'id')
 * @method static EquipmentPhoto|Proxy random(array $attributes = [])
 * @method static EquipmentPhoto|Proxy randomOrCreate(array $attributes = [])
 * @method static EquipmentPhotoRepository|RepositoryProxy repository()
 * @method static EquipmentPhoto[]|Proxy[] all()
 * @method static EquipmentPhoto[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static EquipmentPhoto[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static EquipmentPhoto[]|Proxy[] findBy(array $attributes)
 * @method static EquipmentPhoto[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EquipmentPhoto[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class EquipmentPhotoFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'equipmentPhoto' => self::faker()->text(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(EquipmentPhoto $equipmentPhoto): void {})
        ;
    }

    protected static function getClass(): string
    {
        return EquipmentPhoto::class;
    }
}
